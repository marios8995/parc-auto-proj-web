from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List, Optional
from datetime import datetime, timedelta

from app.database import get_db
from app.models.models import Asigurare, Car, TipAsigurare
from app.schemas.asigurare import AsigurareCreate, AsigurareUpdate, AsigurareResponse
from app.core.exceptions import raise_api_error, ErrorCodes

router = APIRouter()

def get_asigurari_in_prag_de_expirare(db: Session, zile_avertizare: int = 30):
    acum = datetime.now() + timedelta(days=zile_avertizare)
    asigurari_expirate = db.query(Asigurare).filter(
        Asigurare.data_expirare is not None,
        Asigurare.data_expirare < acum).all()
    return asigurari_expirate

@router.post("/", response_model=AsigurareResponse, status_code=status.HTTP_201_CREATED)
def create_asigurare(data: AsigurareCreate, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == data.car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    noua_asigurare = Asigurare(**data.model_dump())
    db.add(noua_asigurare)
    db.commit()
    db.refresh(noua_asigurare)
    return noua_asigurare

@router.get("/", response_model=List[AsigurareResponse])
def get_asigurari(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        car_id: Optional[int] = None,
        tip: Optional[TipAsigurare] = None,
        doar_active: Optional[bool] = Query(None, description="True pentru asigurările încă valabile"),
        db: Session = Depends(get_db)
):
    query = db.query(Asigurare)
    if car_id:
        query = query.filter(Asigurare.car_id == car_id)
    if tip:
        query = query.filter(Asigurare.tip == tip)
    if doar_active is not None:
        acum = datetime.now()
        if doar_active:
            query = query.filter(Asigurare.data_expirare >= acum)
        else:
            query = query.filter(Asigurare.data_expirare < acum)
    return query.order_by(Asigurare.data_expirare.asc()).offset(skip).limit(limit).all()

@router.get("/car/{car_id}/status")
def get_asigurari_status(car_id: int, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)
    acum = datetime.now()
    rca = db.query(Asigurare).filter(Asigurare.car_id == car_id, Asigurare.tip == TipAsigurare.RCA).order_by(
        Asigurare.data_expirare.desc()).first()
    casco = db.query(Asigurare).filter(Asigurare.car_id == car_id, Asigurare.tip == TipAsigurare.CASCO).order_by(
        Asigurare.data_expirare.desc()).first()

    def construieste_status(asig):
        if not asig:
            return {"exista": False, "valida": False, "mesaj": "Nu are asigurare înregistrată."}

        este_valida = asig.data_expirare > acum
        zile_ramase = (asig.data_expirare - acum).days

        return {
            "exista": True,
            "id": asig.id,
            "companie": asig.companie,
            "valida": este_valida,
            "zile_ramase": zile_ramase,
            "data_expirare": asig.data_expirare,
            "flag": not este_valida or zile_ramase <= 15
        }

    return {
        "car_id": car_id,
        "RCA": construieste_status(rca),
        "CASCO": construieste_status(casco)
    }

@router.patch("/{asig_id}", response_model=AsigurareResponse)
def update_asigurare(asig_id: int, data: AsigurareUpdate, db: Session = Depends(get_db)):
    asig = db.query(Asigurare).filter(Asigurare.id == asig_id).first()
    if not asig:
        raise_api_error(ErrorCodes.INSURANCE_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    update_data = data.model_dump(exclude_unset=True)
    for key, value in update_data.items():
        setattr(asig, key, value)

    db.commit()
    db.refresh(asig)
    return asig

@router.delete("/{asig_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_asigurare(asig_id: int, db: Session = Depends(get_db)):
    asig = db.query(Asigurare).filter(Asigurare.id == asig_id).first()
    if not asig:
        raise_api_error(ErrorCodes.INSURANCE_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(asig)
    db.commit()
    return None
