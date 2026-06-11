import os
from dotenv import load_dotenv
from sqlalchemy.orm import Session
from app.database import SessionLocal, engine
from app.models.models import Base, Accounts, UserRole
from app.core.security import get_password_hash

load_dotenv()
def init():
    Base.metadata.create_all(bind=engine)

def create_first_admin():
    db = SessionLocal()
    try:
        user = db.query(Accounts).first()
        if user:
            print("Baza de date are deja utilizatori. Se sare peste crearea primului admin.")
            return

        print("Tabelul de conturi este gol. Se creează primul Admin...")

        username = os.getenv("FIRST_ADMIN_USERNAME")
        email = os.getenv("FIRST_ADMIN_EMAIL")
        password = os.getenv("FIRST_ADMIN_PASSWORD")

        if not username:
            raise ValueError("FIRST_ADMIN_USERNAME nu este setat în mediul de rulare!")
        if not email:
            raise ValueError("FIRST_ADMIN_EMAIL nu este setat în mediul de rulare!")
        if not password:
            raise ValueError("FIRST_ADMIN_PASSWORD nu este setat în mediul de rulare!")

        hashed_password = get_password_hash(password)

        first_admin = Accounts(
            username=username,
            email=email,
            hashed_password=hashed_password,
            role=UserRole.ADMIN,
            is_active=True
        )

        db.add(first_admin)
        db.commit()
        print(f"Adminul '{username}' a fost creat cu succes!")

    except Exception as e:
        print(f"A apărut o eroare: {e}")
    finally:
        db.close()


if __name__ == "__main__":
    init()
    create_first_admin()
