from fastapi import Depends, status
from fastapi.security import OAuth2PasswordBearer
from sqlalchemy.orm import Session
import jwt

from app.core.exceptions import raise_api_error, ErrorCodes
from app.database import get_db
from app.core.security import SECRET_KEY, ALGORITHM
from app.models.models import Accounts, UserRole

oauth2_scheme = OAuth2PasswordBearer(tokenUrl="/api/auth/login")

def get_current_user(token: str = Depends(oauth2_scheme), db: Session = Depends(get_db)):

    credentials_exception = raise_api_error(
                ErrorCodes.CREDENTIALS_EXCEPTION,
                status_code=status.HTTP_401_UNAUTHORIZED,
                headers={"WWW-Authenticate": "Bearer"}
            )

    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        username: str = payload.get("sub")
        if username is None:
            raise credentials_exception
    except jwt.PyJWTError:
        raise credentials_exception

    user = db.query(Accounts).filter(Accounts.username == username).first()

    if user is None:
        raise credentials_exception
    if not user.is_active:
        raise_api_error(ErrorCodes.ACCOUNT_INACTIVE, status_code=status.HTTP_400_BAD_REQUEST)

    return user

def get_current_admin(current_user: Accounts = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise_api_error(ErrorCodes.ACCOUNT_NOT_ADMIN, status_code=status.HTTP_403_FORBIDDEN)
    return current_user
