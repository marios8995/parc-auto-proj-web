from fastapi import APIRouter, Depends, status
from fastapi.security import OAuth2PasswordRequestForm
from sqlalchemy.orm import Session
from app.database import get_db
from app.models.models import Accounts
from app.schemas.token import Token
from app.core.security import verify_password, create_access_token
from app.core.exceptions import ErrorCodes, raise_api_error
from app.api.dependencies import get_current_user

router = APIRouter(
    dependencies=[Depends(get_current_user)]
)

@router.post("/login", response_model=Token)
def login_for_access_token(
        form_data: OAuth2PasswordRequestForm = Depends(),
        db: Session = Depends(get_db())
):
    user = db.query(Accounts).filter(Accounts.username == form_data.username).first()
    if not user or not verify_password(form_data.password, user.hashed_password):
        raise_api_error(
            ErrorCodes.INVALID_CREDENTIALS,
            status_code=status.HTTP_401_UNAUTHORIZED,
            headers={"WWW-Authenticate": "Bearer"}
        )

    access_token = create_access_token(data={"sub": user.username})
    return {"access_token": access_token, "token_type": "bearer"}
