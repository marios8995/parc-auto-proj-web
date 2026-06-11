import os
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from dotenv import load_dotenv

load_dotenv()

user = os.getenv("DB_USER")
password = os.getenv("DB_PASSWORD")
host = os.getenv("DB_HOST")
port = os.getenv("DB_PORT")
db_name = os.getenv("DB_NAME")

if not user:
    raise ValueError("DB_USER nu este setat în mediul de rulare!")
if not password:
    raise ValueError("DB_PASSWORD nu este setat în mediul de rulare!")
if not host:
    raise ValueError("DB_HOST nu este setat în mediul de rulare!")
if not port:
    raise ValueError("DB_PORT nu este setat în mediul de rulare!")
if not db_name:
    raise ValueError("DB_NAME nu este setat în mediul de rulare!")

SQLALCHEMY_DATABASE_URL = f"mysql+pymysql://{user}:{password}@{host}:{port}/{db_name}"

engine = create_engine(SQLALCHEMY_DATABASE_URL)
Session = sessionmaker(autocommit=False, autoflush=False, bind=engine)

def get_db():
    db = Session()
    try:
        yield db
    finally:
        db.close()
