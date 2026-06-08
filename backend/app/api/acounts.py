from fastapi import APIRouter, Depends, status
from sqlalchemy.orm import Session
from typing import List
from app.database import get_db
from app.models.models import Accounts
from app.schemas.account import AccountCreate, AccountResponse, AccountUpdate
from app.core.security import get_password_hash
from app.core.exceptions import ErrorCodes, raise_api_error
from app.api.dependencies import get_current_user

router = APIRouter(
    dependencies=[Depends(get_current_user)]
)

@router.post("/register", response_model=AccountResponse, status_code=status.HTTP_201_CREATED)
def register_user(user_in: AccountCreate, db: Session = Depends(get_db)):

    if db.query(Accounts).filter(Accounts.username == user_in.username).first():
        raise_api_error(ErrorCodes.USERNAME_ALREADY_USED, status_code=status.HTTP_400_BAD_REQUEST)
    if db.query(Accounts).filter(Accounts.email == user_in.email).first():
        raise_api_error(ErrorCodes.EMAIL_ALREADY_USED, status_code=status.HTTP_400_BAD_REQUEST)

    hashed_pwd = get_password_hash(user_in.password)

    new_user = Accounts(
        username=user_in.username,
        email=user_in.email,
        hashed_password=hashed_pwd,
        role=user_in.role,
        is_active=user_in.is_active
    )

    db.add(new_user)
    db.commit()
    db.refresh(new_user)
    return new_user

@router.get("/", response_model=List[AccountResponse])
def get_users(skip: int = 0, limit: int = 100, db: Session = Depends(get_db)):
    users = db.query(Accounts).offset(skip).limit(limit).all()
    return users


@router.patch("/{account_id}", response_model=AccountResponse)
def update_user(account_id: int, user_data: AccountUpdate, db: Session = Depends(get_db)):
    user = db.query(Accounts).filter(Accounts.id == account_id).first()
    if not user:
        raise_api_error(ErrorCodes.USER_NOT_FOUND, status_code=status.HTTP_404_NOT_FOUND)

    update_dict = user_data.model_dump(exclude_unset=True)

    if "username" in update_dict:
        existent_usr = db.query(Accounts).filter(Accounts.username == update_dict["username"],
                                                 Accounts.id != account_id).first()
        if existent_usr:
            raise_api_error(ErrorCodes.USERNAME_ALREADY_USED, status_code=status.HTTP_400_BAD_REQUEST)

    if "email" in update_dict:
        existent_mail = db.query(Accounts).filter(Accounts.email == update_dict["email"],
                                                  Accounts.id != account_id).first()
        if existent_mail:
            raise_api_error(ErrorCodes.EMAIL_ALREADY_USED, status_code=status.HTTP_400_BAD_REQUEST)

    for key, value in update_dict.items():
        setattr(user, key, value)

    db.commit()
    db.refresh(user)
    return user
