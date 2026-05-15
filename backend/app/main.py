from fastapi import FastAPI
from app.models.models import Base
from app.database import engine
from app.api import cars, drivers, driver_car_associations, owners, management_services, anvelope, asigurari, viniete

Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="Fleet Management System API",
    description="API pentru gestiunea parcului auto, șoferi, service și asigurări",
    version="1.0.0"
)

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
