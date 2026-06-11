from fastapi import Depends, status, HTTPException
from fastapi.security import OAuth2PasswordBearer
from sqlalchemy.orm import Session
import jwt

from app.core.exceptions import raise_api_error, ErrorCodes
from app.database import get_db
from app.core.security import SECRET_KEY, ALGORITHM
from app.models.models import Accounts, UserRole

oauth2_scheme = OAuth2PasswordBearer(tokenUrl="/api/auth/login")

def get_current_user(token: str = Depends(oauth2_scheme), db: Session = Depends(get_db)):

    try:
        print("\n=== 🔍 DEBUG AUTENTIFICARE ===")
        print(f"1. Token primit (primele caractere): {token[:15]}...")

        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        username: str = payload.get("sub")
        print(f"2. Username extras din token: '{username}'")

        if username is None:
            print("❌ Eroare: Câmpul 'sub' lipsește din token!")
            raise_api_error(ErrorCodes.CREDENTIALS_EXCEPTION, status_code=status.HTTP_401_UNAUTHORIZED, headers={"WWW-Authenticate": "Bearer"})

    except jwt.ExpiredSignatureError:
        print("❌ Eroare: Token-ul a expirat (ExpiredSignatureError)!")
        raise_api_error(ErrorCodes.CREDENTIALS_EXCEPTION, status_code=status.HTTP_401_UNAUTHORIZED, headers={"WWW-Authenticate": "Bearer"})
    except jwt.PyJWTError as e:
        print(f"❌ Eroare: Token-ul este invalid sau modificat ({e})!")
        raise_api_error(ErrorCodes.CREDENTIALS_EXCEPTION, status_code=status.HTTP_401_UNAUTHORIZED, headers={"WWW-Authenticate": "Bearer"})
    except Exception as e:
        print(f"❌ Eroare neprevăzută la decodare: {e}")
        raise_api_error(ErrorCodes.CREDENTIALS_EXCEPTION, status_code=status.HTTP_401_UNAUTHORIZED, headers={"WWW-Authenticate": "Bearer"})

    user = db.query(Accounts).filter(Accounts.username == username).first()
    if user is None:
        print(f"❌ Eroare: Utilizatorul '{username}' nu există în tabela 'accounts'!")
        raise_api_error(ErrorCodes.CREDENTIALS_EXCEPTION, status_code=status.HTTP_401_UNAUTHORIZED, headers={"WWW-Authenticate": "Bearer"})

    if not user.is_active:
        print(f"❌ Eroare: Utilizatorul '{username}' are contul inactiv!")
        raise HTTPException(status_code=400, detail="Acest cont este inactiv.")

    print("✅ [SUCCESS] Autentificare reușită pentru:", username)
    return user

def get_current_admin(current_user: Accounts = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise_api_error(ErrorCodes.ACCOUNT_NOT_ADMIN, status_code=status.HTTP_403_FORBIDDEN)
    return current_user
