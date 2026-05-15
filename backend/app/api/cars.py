from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List, Optional
from datetime import datetime, timedelta

from app.database import get_db
from app.models.models import Car
from app.schemas.car import CarCreate, CarResponse, CarUpdate
from app.core.exceptions import raise_api_error, ErrorCodes

router = APIRouter()

def apply_car_filters(
    query,
    marca: Optional[str] = None,
    status_masina: Optional[str] = None,
    disponibil: Optional[bool] = None,
    model: Optional[str] = None,
    an_fabricatie: Optional[int] = None,
    tip_caroserie: Optional[str] = None,
    tip_combustibil: Optional[str] = None,
    numar_locuri: Optional[int] = None,
    culoare: Optional[str] = None,
    categorie: Optional[str] = None,
    capacitate_cilindrica: Optional[float] = None,
    pret_min: Optional[float] = None,
    pret_max: Optional[float] = None
):
    if marca:
        query = query.filter(Car.marca.ilike(f"%{marca}%"))
    if status_masina:
        query = query.filter(Car.status == status_masina)
    if disponibil is not None:
        query = query.filter(Car.disponibil == disponibil)
    if model:
        query = query.filter(Car.model.ilike(f"%{model}%"))
    if an_fabricatie is not None:
        query = query.filter(Car.an_fabricatie == an_fabricatie)
    if tip_caroserie:
        query = query.filter(Car.tip_caroserie.ilike(f"%{tip_caroserie}%"))
    if tip_combustibil:
        query = query.filter(Car.tip_combustibil.ilike(f"%{tip_combustibil}%"))
    if numar_locuri is not None:
        query = query.filter(Car.numar_locuri == numar_locuri)
    if culoare:
        query = query.filter(Car.culoare.ilike(f"%{culoare}%"))
    if categorie:
        query = query.filter(Car.categorie.ilike(f"%{categorie}%"))
    if capacitate_cilindrica:
        query = query.filter(Car.capacitate_cilindrica == capacitate_cilindrica)
    if pret_min is not None:
        query = query.filter(Car.pret >= pret_min)
    if pret_max is not None:
        query = query.filter(Car.pret <= pret_max)
    return query


def get_itp_in_prag_de_expirare(db: Session, zile_avertizare: int = 30):
    prag_alerta = datetime.now() + timedelta(days=zile_avertizare)

    masini_cu_probleme = db.query(Car).filter(
        Car.data_expirare_itp is not None,
        Car.data_expirare_itp <= prag_alerta
    ).all()

    return masini_cu_probleme

@router.post("/", response_model=CarResponse, status_code=status.HTTP_201_CREATED)
def create_car(car_data: CarCreate, db: Session = Depends(get_db)):
    if db.query(Car).filter(Car.nr_inmatriculare == car_data.nr_inmatriculare).first():
        raise_api_error(ErrorCodes.CAR_ALREADY_EXISTS, status.HTTP_400_BAD_REQUEST)

    if db.query(Car).filter(Car.serie_sasiu == car_data.serie_sasiu).first():
        raise_api_error(ErrorCodes.CAR_ALREADY_EXISTS, status.HTTP_400_BAD_REQUEST)

    noua_masina = Car(**car_data.model_dump())
    db.add(noua_masina)
    db.commit()
    db.refresh(noua_masina)
    return noua_masina


@router.get("/count", response_model=dict)
def get_cars_count(
        marca: Optional[str] = None,
        status_masina: Optional[str] = None,
        disponibil: Optional[bool] = None,
        model: Optional[str] = None,
        an_fabricatie: Optional[int] = None,
        tip_caroserie: Optional[str] = None,
        tip_combustibil: Optional[str] = None,
        numar_locuri: Optional[int] = None,
        culoare: Optional[str] = None,
        categorie: Optional[str] = None,
        capacitate_cilindrica: Optional[float] = None,
        pret_min: Optional[float] = Query(None, ge=0.0, description="Preț minim"),
        pret_max: Optional[float] = Query(None, ge=0.0, description="Preț maxim"),
        db: Session = Depends(get_db)
):
    query = db.query(Car)
    query = apply_car_filters(query, marca, status_masina, disponibil, model, an_fabricatie, tip_caroserie,
                              tip_combustibil, numar_locuri, culoare, categorie, capacitate_cilindrica,
                              pret_min, pret_max)
    total = query.count()
    return {"total": total}


@router.get("/", response_model=List[CarResponse])
def get_cars(
        skip: int = Query(0, ge=0, description="Câte mașini să sară (offset)"),
        limit: int = Query(10, ge=1, le=100, description="Câte mașini să returneze (limit)"),
        marca: Optional[str] = None,
        status_masina: Optional[str] = None,
        disponibil: Optional[bool] = None,
        model: Optional[str] = None,
        an_fabricatie: Optional[int] = None,
        tip_caroserie: Optional[str] = None,
        tip_combustibil: Optional[str] = None,
        numar_locuri: Optional[int] = None,
        culoare: Optional[str] = None,
        categorie: Optional[str] = None,
        capacitate_cilindrica: Optional[float] = None,
        pret_min: Optional[float] = Query(None, ge=0.0, description="Preț minim"),
        pret_max: Optional[float] = Query(None, ge=0.0, description="Preț maxim"),
        db: Session = Depends(get_db)
):
    query = db.query(Car)
    query = apply_car_filters(query, marca, status_masina, disponibil, model, an_fabricatie, tip_caroserie,
                              tip_combustibil, numar_locuri, culoare, categorie, capacitate_cilindrica,
                              pret_min, pret_max)
    masini = query.offset(skip).limit(limit).all()
    return masini

@router.patch("/{car_id}", response_model=CarResponse)
def update_car(car_id: int, car_data: CarUpdate, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    update_data = car_data.model_dump(exclude_unset=True)

    for key, value in update_data.items():
        setattr(masina, key, value)

    db.commit()
    db.refresh(masina)
    return masina

@router.delete("/{car_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_car(car_id: int, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(masina)
    db.commit()
    return None


@router.get("/{car_id}/itp-status")
def get_car_itp_status(car_id: int, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()

    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    if not masina.data_expirare_itp:
        return {
            "car_id": car_id,
            "itp_valid": False,
            "mesaj": "Data de expirare ITP nu este setată pentru această mașină.",
            "zile_ramase": None
        }

    acum = datetime.now()
    este_valid = masina.data_expirare_itp > acum
    diferenta_zile = (masina.data_expirare_itp - acum).days

    return {
        "car_id": car_id,
        "itp_valid": este_valid,
        "data_expirare_itp": masina.data_expirare_itp,
        "zile_ramase": diferenta_zile if este_valid else diferenta_zile,
        "mesaj": "ITP Valid" if este_valid else f"ITP Expirat de {abs(diferenta_zile)} zile!"
    }
