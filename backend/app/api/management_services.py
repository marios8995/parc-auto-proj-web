from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from sqlalchemy import func
from typing import List, Optional
from app.database import get_db
from app.models.models import ManagementService, Car
from app.schemas.management_service import (
    ManagementServiceCreate,
    ManagementServiceUpdate,
    ManagementServiceResponse
)
from app.core.exceptions import raise_api_error, ErrorCodes
from app.api.dependencies import get_current_user

router = APIRouter(
    dependencies=[Depends(get_current_user)]
)

@router.post("/", response_model=ManagementServiceResponse, status_code=status.HTTP_201_CREATED)
def create_service_record(data: ManagementServiceCreate, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == data.car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    nou_service = ManagementService(**data.model_dump())
    db.add(nou_service)

    if not data.data_iesire:
        masina.status = "in_service"
        masina.disponibil = False

    if data.kilometraj_la_serviciu and data.kilometraj_la_serviciu > masina.kilometraj:
        masina.kilometraj = data.kilometraj_la_serviciu

    db.commit()
    db.refresh(nou_service)
    return nou_service

@router.get("/", response_model=List[ManagementServiceResponse])
def get_service_records(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        car_id: Optional[int] = Query(None, description="Filtrează istoricul unei mașini"),
        in_lucru: Optional[bool] = Query(None,
                                         description="True pentru mașini care încă sunt în service (fără dată ieșire)"),
        db: Session = Depends(get_db)
):
    query = db.query(ManagementService)

    if car_id:
        query = query.filter(ManagementService.car_id.ilike(f"%{car_id}%"))
    if in_lucru is not None:
        if in_lucru:
            query = query.filter(ManagementService.data_iesire is None)
        else:
            query = query.filter(ManagementService.data_iesire is not None)
    return query.order_by(ManagementService.data_intrare.desc()).offset(skip).limit(limit).all()

@router.patch("/{service_id}", response_model=ManagementServiceResponse)
def update_service_record(service_id: int, data: ManagementServiceUpdate, db: Session = Depends(get_db)):
    service = db.query(ManagementService).filter(ManagementService.id == service_id).first()
    if not service:
        raise_api_error(ErrorCodes.SERVICE_RECORD_NOT_FOUND, status.HTTP_404_NOT_FOUND)
    update_data = data.model_dump(exclude_unset=True)

    if "data_iesire" in update_data and update_data["data_iesire"] is not None:
        masina = db.query(Car).filter(Car.id == service.car_id).first()
        if masina:
            masina.status = "activ"
            masina.disponibil = True

    for key, value in update_data.items():
        setattr(service, key, value)

    db.commit()
    db.refresh(service)
    return service

@router.delete("/{service_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_service_record(service_id: int, db: Session = Depends(get_db)):
    service = db.query(ManagementService).filter(ManagementService.id == service_id).first()
    if not service:
        raise_api_error(ErrorCodes.SERVICE_RECORD_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(service)
    db.commit()
    return None

@router.get("/car/{car_id}/total-cost")
def get_car_total_service_cost(car_id: int, db: Session = Depends(get_db)):
    masina = db.query(Car).filter(Car.id == car_id).first()
    if not masina:
        raise_api_error(ErrorCodes.CAR_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    rezultat = db.query(func.sum(ManagementService.cost_total)).filter(
        ManagementService.car_id == car_id
    ).scalar()
    cost_total = rezultat if rezultat is not None else 0.0

    return {
        "car_id": car_id,
        "marca": masina.marca,
        "nr_inmatriculare": masina.nr_inmatriculare,
        "cost_total_mentenanta": cost_total
    }
