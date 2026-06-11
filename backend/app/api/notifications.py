from fastapi import APIRouter, Depends, status, Query
from sqlalchemy.orm import Session
from typing import List
from app.database import get_db
from app.models.models import Notifications
from app.schemas.notifications import NotificationCreate, NotificationUpdate, NotificationResponse
from app.api.dependencies import get_current_user
from app.core.exceptions import raise_api_error, ErrorCodes

router = APIRouter(
    dependencies=[Depends(get_current_user)]
)

@router.post("/", response_model=NotificationResponse, status_code=status.HTTP_201_CREATED)
def create_notification(data: NotificationCreate, db: Session = Depends(get_db)):
    noua_notificare = Notifications(**data.model_dump())
    db.add(noua_notificare)
    db.commit()
    db.refresh(noua_notificare)
    return noua_notificare

@router.get("/", response_model=List[NotificationResponse])
def get_notifications(
    skip: int = Query(0, ge=0),
    limit: int = Query(50, ge=1, le=100),
    unread_only: bool = Query(False, description="Aduce doar notificările necitite dacă este true"),
    db: Session = Depends(get_db)
):
    query = db.query(Notifications)
    if unread_only:
        query = query.filter(Notifications.read == False)
    return query.order_by(Notifications.timestamp.desc()).offset(skip).limit(limit).all()

@router.get("/unread-count")
def get_unread_count(db: Session = Depends(get_db)):
    count = db.query(Notifications).filter(Notifications.read == False).count()
    return {"unread_count": count}


@router.patch("/{notif_id}/read", response_model=NotificationResponse)
def mark_notification_as_read(notif_id: int, db: Session = Depends(get_db)):
    notificare = db.query(Notifications).filter(Notifications.id == notif_id).first()
    if not notificare:
        raise_api_error(ErrorCodes.NOTIFICATION_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    notificare.read = True
    db.commit()
    db.refresh(notificare)
    return notificare


@router.patch("/mark-all-read", status_code=status.HTTP_200_OK)
def mark_all_as_read(db: Session = Depends(get_db)):
    notificari_necitite = db.query(Notifications).filter(Notifications.read == False).all()

    count = 0
    for notif in notificari_necitite:
        notif.read = True
        count += 1

    db.commit()
    return {"mesaj": f"{count} notificări au fost marcate ca citite."}


@router.delete("/{notif_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete_notification(notif_id: int, db: Session = Depends(get_db)):
    notificare = db.query(Notifications).filter(Notifications.id == notif_id).first()
    if not notificare:
        raise_api_error(ErrorCodes.NOTIFICATION_NOT_FOUND, status.HTTP_404_NOT_FOUND)

    db.delete(notificare)
    db.commit()
    return None