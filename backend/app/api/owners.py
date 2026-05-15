from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List, Optional

from app.database import get_db
from app.models.models import Owner, Car
from app.schemas.owner import OwnerCreate, OwnerResponse, OwnerUpdate
from app.schemas.car import CarResponse
from app.core.exceptions import raise_api_error, ErrorCodes

router = APIRouter()

def apply_owner_filters(query, nume: Optional[str] = None, cui_cnp: Optional[str] = None, tip: Optional[str] = None):
    if nume:
        query = query.filter(Owner.nume.ilike(f"%{nume}%"))
    if cui_cnp:
        query = query.filter(Owner.cui_cnp == cui_cnp)
    if tip:
        query = query.filter(Owner.tip == tip)
    return query

@router.post("/", response_model=OwnerResponse, status_code=status.HTTP_201_CREATED)
def create_owner(data: OwnerCreate, db: Session = Depends(get_db)):
    if db.query(Owner).filter(Owner.cui_cnp == data.cui_cnp).first():
        raise_api_error(ErrorCodes.OWNER_ALREADY_EXISTS, status.HTTP_400_BAD_REQUEST)

    noul_owner = Owner(**data.model_dump())
    db.add(noul_owner)
    db.commit()
    db.refresh(noul_owner)
    return noul_owner

@router.get("/", response_model=List[OwnerResponse])
def get_owners(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        nume: Optional[str] = None,
        cui_cnp: Optional[str] = None,
        tip: Optional[str] = None,
        db: Session = Depends(get_db)
):
    query = db.query(Owner)
    query = apply_owner_filters(query, nume, cui_cnp, tip)
    return query.offset(skip).limit(limit).all()

@router.get("/count", response_model=dict)
def get_owners_count(nume: Optional[str] = None, cui_cnp: Optional[str] = None, tip: Optional[str] = None,
                     db: Session = Depends(get_db)):
    query = db.query(Owner)
    query = apply_owner_filters(query, nume, cui_cnp, tip)
    return {"total": query.count()}

@router.get("/{owner_id}", response_model=OwnerResponse)
def get_owner_details(owner_id: int, db: Session = Depends(get_db)):
    owner = db.query(Owner).filter(Owner.id == owner_id).first()
    if not owner:
        raise_api_error(ErrorCodes.OWNER_NOT_FOUND, status.HTTP_404_NOT_FOUND)
    return owner

@router.get("/{owner_id}/cars", response_model=List[CarResponse])
def get_owner_cars(owner_id: int, db: Session = Depends(get_db)):
    owner = db.query(Owner).filter(Owner.id == owner_id).first()
    if not owner:
        raise_api_error(ErrorCodes.OWNER_NOT_FOUND, status.HTTP_404_NOT_FOUND)
    return owner.cars

@router.patch("/{owner_id}", response_model=OwnerResponse)
def update_owner(owner_id: int, data: OwnerUpdate, db: Session = Depends(get_db)):
    owner = db.query(Owner).filter(Owner.id == owner_id).first()
    if not owner:
        raise_api_error(ErrorCodes.OWNER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    update_data = data.model_dump(exclude_unset=True)
    for key, value in update_data.items():
        setattr(owner, key, value)

    db.commit()
    db.refresh(owner)
    return owner

@router.delete("/{owner_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_owner(owner_id: int, db: Session = Depends(get_db)):
    owner = db.query(Owner).filter(Owner.id == owner_id).first()
    if not owner:
        raise_api_error(ErrorCodes.OWNER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    if db.query(Car).filter(Car.owner_id == owner_id).count() > 0:
        raise_api_error(ErrorCodes.OWNER_HAS_ACTIVE_CARS, status.HTTP_400_BAD_REQUEST)

    db.delete(owner)
    db.commit()
    return None

@router.delete("/{owner_id}/clear-cars", status_code=status.HTTP_204_NO_CONTENT)
def delete_all_owner_cars(owner_id: int, db: Session = Depends(get_db)):
    owner = db.query(Owner).filter(Owner.id == owner_id).first()
    if not owner:
        raise_api_error(ErrorCodes.OWNER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.query(Car).filter(Car.owner_id == owner_id).delete()
    db.commit()
    return None
