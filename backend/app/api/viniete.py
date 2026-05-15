from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List, Optional
from datetime import datetime, timedelta

from app.database import get_db
from app.models.models import Vinieta, Car
from app.schemas.vinieta import VinietaCreate, VinietaUpdate, VinietaResponse
from app.core.exceptions import raise_api_error, ErrorCodes

router = APIRouter()

def get_viniete_in_prag_de_expirare(db: Session, zile_avertizare: int = 7):
    prag_alerta = datetime.now() + timedelta(days=zile_avertizare)
    viniete_cu_probleme = db.query(Vinieta).filter(Vinieta.data_expirare <= prag_alerta).all()
    return viniete_cu_probleme

@router.post("/", response_model=VinietaResponse, status_code=status.HTTP_201_CREATED)
def create_vinieta(data: VinietaCreate, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == data.car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    noua_vinieta = Vinieta(**data.model_dump())
    db.add(noua_vinieta)
    db.commit()
    db.refresh(noua_vinieta)
    return noua_vinieta

@router.get("/", response_model=List[VinietaResponse])
def get_viniete(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        car_id: Optional[int] = None,
        tara: Optional[str] = Query(None, description="Filtru după țară (ex: RO, HU)"),
        doar_active: Optional[bool] = Query(None, description="True pentru viniete încă valabile"),
        db: Session = Depends(get_db)
):
    query = db.query(Vinieta)

    if car_id:
        query = query.filter(Vinieta.car_id == car_id)
    if tara:
        query = query.filter(Vinieta.tara == tara.upper())

    if doar_active is not None:
        acum = datetime.now()
        if doar_active:
            query = query.filter(Vinieta.data_expirare >= acum)
        else:
            query = query.filter(Vinieta.data_expirare < acum)

    return query.order_by(Vinieta.data_expirare.asc()).offset(skip).limit(limit).all()

@router.get("/car/{car_id}/status")
def get_vinieta_status(car_id: int, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    acum = datetime.now()
    toate_vinietele = db.query(Vinieta).filter(Vinieta.car_id == car_id).order_by(Vinieta.data_expirare.desc()).all()

    if not toate_vinietele:
        return {
            "car_id": car_id,
            "mesaj": "Mașina nu are nicio vinietă înregistrată.",
            "viniete": []
        }
    tari_procesate = set()
    status_viniete = []

    for vin in toate_vinietele:
        if vin.tara not in tari_procesate:
            tari_procesate.add(vin.tara)

            este_valida = vin.data_expirare > acum
            zile_ramase = (vin.data_expirare - acum).days

            status_viniete.append({
                "id": vin.id,
                "tara": vin.tara,
                "valida": este_valida,
                "zile_ramase": zile_ramase,
                "data_expirare": vin.data_expirare,
                "flag": not este_valida or zile_ramase <= 5
            })

    return {
        "car_id": car_id,
        "mesaj": "Status generat cu succes.",
        "viniete": status_viniete
    }

@router.patch("/{vin_id}", response_model=VinietaResponse)
def update_vinieta(vin_id: int, data: VinietaUpdate, db: Session = Depends(get_db)):
    vin = db.query(Vinieta).filter(Vinieta.id == vin_id).first()
    if not vin:
        raise_api_error(ErrorCodes.VIGNETTE_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    update_data = data.model_dump(exclude_unset=True)
    for key, value in update_data.items():
        setattr(vin, key, value)

    db.commit()
    db.refresh(vin)
    return vin


@router.delete("/{vin_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_vinieta(vin_id: int, db: Session = Depends(get_db)):
    vin = db.query(Vinieta).filter(Vinieta.id == vin_id).first()
    if not vin:
        raise_api_error(ErrorCodes.VIGNETTE_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(vin)
    db.commit()
    return None
