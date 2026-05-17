from fastapi import FastAPI
from fastapi.staticfiles import StaticFiles
from fastapi.middleware.cors import CORSMiddleware
import os
from app.models.models import Base
from app.database import engine
from app.api import (
    cars, drivers, driver_car_associations, owners,
    management_services, anvelope, asigurari, viniete,
    auth, acounts
)

Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="Fleet Management System API",
    description="API pentru gestiunea parcului auto, șoferi, service și asigurări",
    version="1.0.0"
)

origins = [
    "http://localhost:3000",
    "http://localhost:5173",
    "http://localhost:3306",
    "http://127.0.0.1:3000",
    "http://127.0.0.1:5173",
    "http://127.0.0.1:3306",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


os.makedirs("uploads/cars", exist_ok=True)
app.mount("/uploads", StaticFiles(directory="uploads"), name="uploads")

@app.get("/", tags=["Root"])
def read_root():
    return {
        "status": "Online",
        "message": "Sistemul de Management Parc Auto este funcțional"
    }

app.include_router(cars.router, prefix="/api/cars", tags=["Cars"])
app.include_router(drivers.router, prefix="/api/drivers", tags=["Drivers"])
app.include_router(driver_car_associations.router, prefix="/api/associations", tags=["Driver-Car Associations"])
app.include_router(owners.router, prefix="/api/owners", tags=["Owners"])
app.include_router(management_services.router, prefix="/api/services", tags=["Management Services"])
app.include_router(anvelope.router, prefix="/api/anvelope", tags=["Anvelope"])
app.include_router(asigurari.router, prefix="/api/asigurari", tags=["Asigurare"])
app.include_router(viniete.router, prefix="/api/viniete", tags=["Viniete"])
app.include_router(auth.router, prefix="/api/auth", tags=["Authentication"])
app.include_router(acounts.router, prefix="/api/accounts", tags=["Accounts"])
