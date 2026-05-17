from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List

from app.database import get_db
from app.models.models import DriverCarAssociation, Car, Driver
from app.schemas.driver_car_association import (
    DriverCarAssociationCreate,
    DriverCarAssociationResponse,
    DriverCarAssociationUpdate
)
from app.core.exceptions import raise_api_error, ErrorCodes
from app.api.dependencies import get_current_user

router = APIRouter(
    dependencies=[Depends(get_current_user)]
)


@router.post("/", response_model=DriverCarAssociationResponse, status_code=status.HTTP_201_CREATED)
def create_association(data: DriverCarAssociationCreate, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == data.car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    sofer = db.query(Driver).filter(Driver.id == data.driver_id).first()
    if not sofer:
        raise_api_error(ErrorCodes.DRIVER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    noua_asociere = DriverCarAssociation(**data.model_dump())
    db.add(noua_asociere)

    masina.disponibil = False

    db.commit()
    db.refresh(noua_asociere)
    return noua_asociere

@router.get("/", response_model=List[DriverCarAssociationResponse])
def get_associations(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        db: Session = Depends(get_db)
):
    asocieri = db.query(DriverCarAssociation).offset(skip).limit(limit).all()
    return asocieri

@router.patch("/{assoc_id}", response_model=DriverCarAssociationResponse)
def update_association(assoc_id: int, data: DriverCarAssociationUpdate, db: Session = Depends(get_db)):
    asociere = db.query(DriverCarAssociation).filter(DriverCarAssociation.id == assoc_id).first()
    if not asociere:
        raise_api_error(ErrorCodes.ASSOCIATION_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    asociere.data_predare = data.data_predare

    masina = db.query(Car).filter(Car.id == asociere.car_id).first()
    if masina:
        masina.disponibil = True

    db.commit()
    db.refresh(asociere)
    return asociere

@router.delete("/{assoc_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_association(assoc_id: int, db: Session = Depends(get_db)):
    asociere = db.query(DriverCarAssociation).filter(DriverCarAssociation.id == assoc_id).first()
    if not asociere:
        raise_api_error("ASSOCIATION_NOT_FOUND", status.HTTP_404_NOT_FOUND)

    db.delete(asociere)
    db.commit()
    return None

@router.get("/car/{car_id}", response_model=List[DriverCarAssociationResponse])
def get_car_history(car_id: int, db: Session = Depends(get_db)):
    if not db.query(Car).filter(Car.id == car_id).first():
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    istoric = db.query(DriverCarAssociation).filter(DriverCarAssociation.car_id == car_id).order_by(
        DriverCarAssociation.data_preluare.desc()).all()
    return istoric

@router.get("/driver/{driver_id}", response_model=List[DriverCarAssociationResponse])
def get_driver_history(driver_id: int, db: Session = Depends(get_db)):
    if not db.query(Driver).filter(Driver.id == driver_id).first():
        raise_api_error(ErrorCodes.DRIVER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    istoric = db.query(DriverCarAssociation).filter(DriverCarAssociation.driver_id == driver_id).order_by(
        DriverCarAssociation.data_preluare.desc()).all()
    return istoric
