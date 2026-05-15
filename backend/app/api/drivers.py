from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List, Optional
from datetime import datetime, timedelta

from app.database import get_db
from app.models.models import Driver
from app.schemas.driver import DriverCreate, DriverResponse, DriverUpdate
from app.core.exceptions import raise_api_error, ErrorCodes

router = APIRouter()


def get_permise_in_prag_de_expirare(db: Session, zile_avertizare: int = 30):
    prag_alerta = datetime.now() + timedelta(days=zile_avertizare)

    soferi_cu_probleme = db.query(Driver).filter(
        Driver.data_expirare_permis is not None,
        Driver.data_expirare_permis <= prag_alerta
    ).all()

    return soferi_cu_probleme

@router.post("/", response_model=DriverResponse, status_code=status.HTTP_201_CREATED)
def create_driver(driver_data: DriverCreate, db: Session = Depends(get_db)):
    if db.query(Driver).filter(Driver.cnp == driver_data.cnp).first():
        raise_api_error(ErrorCodes.DRIVER_ALREADY_EXISTS, status.HTTP_400_BAD_REQUEST)

    if db.query(Driver).filter(Driver.numar_permis == driver_data.numar_permis).first():
        raise_api_error(ErrorCodes.DRIVER_ALREADY_EXISTS, status.HTTP_400_BAD_REQUEST)

    nou_sofer = Driver(**driver_data.model_dump())
    db.add(nou_sofer)
    db.commit()
    db.refresh(nou_sofer)
    return nou_sofer


# ================= 2. READ (Lista cu paginare și căutare) =================
@router.get("/", response_model=List[DriverResponse])
def get_drivers(
        skip: int = Query(0, ge=0),
        limit: int = Query(10, ge=1, le=100),
        nume: Optional[str] = Query(None, description="Caută după nume complet"),
        cnp: Optional[str] = Query(None, description="Caută după CNP"),
        numar_permis: Optional[str] = Query(None, description="Caută după număr de permis"),
        telefon: Optional[str] = Query(None, description="Caută după număr de telefon"),
        permis_expirat: Optional[bool] = Query(None, description="Filtrează șoferii cu permis expirat (true/false)"),
        db: Session = Depends(get_db)
):
    query = db.query(Driver)

    if nume:
        query = query.filter(Driver.nume_complet.ilike(f"%{nume}%"))
    if cnp:
        query = query.filter(Driver.cnp.ilike(f"%{cnp}%"))
    if numar_permis:
        query = query.filter(Driver.numar_permis.ilike(f"%{numar_permis}%"))
    if telefon:
        query = query.filter(Driver.telefon.ilike(f"%{telefon}%"))
    if permis_expirat is not None:
        if permis_expirat:
            query = query.filter(Driver.data_expirare_permis < datetime.now())
        else:
            query = query.filter(Driver.data_expirare_permis >= datetime.now())

    soferi = query.offset(skip).limit(limit).all()
    return soferi

@router.patch("/{driver_id}", response_model=DriverResponse)
def update_driver(driver_id: int, driver_data: DriverUpdate, db: Session = Depends(get_db)):
    sofer = db.query(Driver).filter(Driver.id == driver_id).first()
    if not sofer:
        raise_api_error(ErrorCodes.DRIVER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    update_data = driver_data.model_dump(exclude_unset=True)
    if "cnp" in update_data:
        existent = db.query(Driver).filter(Driver.cnp == update_data["cnp"], Driver.id != driver_id).first()
        if existent:
            raise_api_error(ErrorCodes.CNP_ALREADY_USED, status.HTTP_400_BAD_REQUEST)

    for key, value in update_data.items():
        setattr(sofer, key, value)

    db.commit()
    db.refresh(sofer)
    return sofer

@router.delete("/{driver_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_driver(driver_id: int, db: Session = Depends(get_db)):
    sofer = db.query(Driver).filter(Driver.id == driver_id).first()
    if not sofer:
        raise_api_error(ErrorCodes.DRIVER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(sofer)
    db.commit()
    return None

@router.get("/{driver_id}/permis-status")
def get_driver_permis_status(driver_id: int, db: Session = Depends(get_db)):
    sofer = db.query(Driver).filter(Driver.id == driver_id).first()

    if not sofer:
        raise_api_error(ErrorCodes.DRIVER_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    if not sofer.data_expirare_permis:
        return {
            "driver_id": driver_id,
            "permis_valid": False,
            "mesaj": "Data de expirare a permisului nu este setată.",
            "zile_ramase": None
        }

    acum = datetime.now()
    este_valid = sofer.data_expirare_permis > acum
    diferenta_zile = (sofer.data_expirare_permis - acum).days

    return {
        "driver_id": driver_id,
        "nume_sofer": sofer.nume_complet,
        "permis_valid": este_valid,
        "data_expirare_permis": sofer.data_expirare_permis,
        "zile_ramase": diferenta_zile if este_valid else diferenta_zile,
        "mesaj": "Permis Valid" if este_valid else f"Permis Expirat de {abs(diferenta_zile)} zile!"
    }
