from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List, Optional

from app.database import get_db
from app.models.models import Anvelopa, Car, SezonAnvelopa
from app.schemas.anvelopa import AnvelopaCreate, AnvelopaUpdate, AnvelopaResponse
from app.core.exceptions import raise_api_error, ErrorCodes
from app.api.dependencies import get_current_user

router = APIRouter(
    dependencies=[Depends(get_current_user)]
)


def get_anvelope_de_schimbat(db: Session):
    anvelope_uzate = db.query(Anvelopa).filter(
        (Anvelopa.stare_uzura.ilike("%schimbat%")) |
        (Anvelopa.stare_uzura.ilike("%uzat%")) |
        (Anvelopa.stare_uzura.ilike("%rau%")) |
        (Anvelopa.stare_uzura.ilike("%critic%"))
    ).all()
    return anvelope_uzate

@router.post("/", response_model=AnvelopaResponse, status_code=status.HTTP_201_CREATED)
def create_anvelopa(data: AnvelopaCreate, db: Session = Depends(get_db)):
    if data.car_id:
        masina = db.query(Car).filter(Car.id == data.car_id).first()
        if not masina:
            raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    noua_anvelopa = Anvelopa(**data.model_dump())
    db.add(noua_anvelopa)
    db.commit()
    db.refresh(noua_anvelopa)
    return noua_anvelopa

@router.get("/", response_model=List[AnvelopaResponse])
def get_anvelope(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        sezon: Optional[SezonAnvelopa] = None,
        locatie: Optional[str] = Query(None, description="Ex: Depozit, Pe mașină"),
        car_id: Optional[int] = None,
        db: Session = Depends(get_db)
):
    query = db.query(Anvelopa)
    if sezon:
        query = query.filter(Anvelopa.sezon == sezon)
    if locatie:
        query = query.filter(Anvelopa.locatie.ilike(f"%{locatie}%"))
    if car_id is not None:
        query = query.filter(Anvelopa.car_id == car_id)

    return query.offset(skip).limit(limit).all()

@router.get("/car/{car_id}", response_model=List[AnvelopaResponse])
def get_car_tires(car_id: int, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)
    return masina.anvelope

@router.patch("/{anvelopa_id}", response_model=AnvelopaResponse)
def update_anvelopa(anvelopa_id: int, data: AnvelopaUpdate, db: Session = Depends(get_db)):
    anvelopa = db.query(Anvelopa).filter(Anvelopa.id == anvelopa_id).first()
    if not anvelopa:
        raise_api_error(ErrorCodes.TIRE_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    update_data = data.model_dump(exclude_unset=True)
    for key, value in update_data.items():
        setattr(anvelopa, key, value)

    db.commit()
    db.refresh(anvelopa)
    return anvelopa

@router.delete("/{anvelopa_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_anvelopa(anvelopa_id: int, db: Session = Depends(get_db)):
    anvelopa = db.query(Anvelopa).filter(Anvelopa.id == anvelopa_id).first()
    if not anvelopa:
        raise_api_error(ErrorCodes.TIRE_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(anvelopa)
    db.commit()
    return None

@router.patch("/car/{car_id}/swap-season", response_model=dict)
def swap_car_tires_season(car_id: int, noul_sezon: SezonAnvelopa, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    anvelope_curente = db.query(Anvelopa).filter(
        Anvelopa.car_id == car_id,
        Anvelopa.locatie.ilike("%mașină%")
    ).all()

    for anvelopa in anvelope_curente:
        anvelopa.locatie = "Depozit"

    anvelope_noi = db.query(Anvelopa).filter(
        Anvelopa.car_id == car_id,
        Anvelopa.sezon == noul_sezon
    ).all()

    for anvelopa in anvelope_noi:
        anvelopa.locatie = "Pe mașină"

    db.commit()

    mesaj_extra = ""
    if not anvelope_noi:
        mesaj_extra = f" Atenție: Nu s-au găsit anvelope de {noul_sezon.value} în depozit pentru această mașină!"

    return {
        "car_id": car_id,
        "sezon_actual_masina": noul_sezon.value,
        "mesaj": f"Schimb sezonier efectuat cu succes.{mesaj_extra}"
    }
