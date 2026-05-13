from pydantic import BaseModel, Field, ConfigDict
from typing import Optional
from datetime import datetime

class ManagementServiceBase(BaseModel):
    nume_serviciu: str = Field(..., min_length=2, max_length=100)
    descriere_lucrare: Optional[str] = Field(None, max_length=255)
    data_intrare: Optional[datetime] = None
    data_iesire: Optional[datetime] = None
    cost_total: Optional[float] = Field(None, ge=0.0)
    kilometraj_la_serviciu: Optional[float] = Field(None, ge=0.0)

class ManagementServiceCreate(ManagementServiceBase):
    car_id: int

class ManagementServiceUpdate(BaseModel):
    nume_serviciu: Optional[str] = Field(None, min_length=2, max_length=100)
    descriere_lucrare: Optional[str] = Field(None, max_length=255)
    data_intrare: Optional[datetime] = None
    data_iesire: Optional[datetime] = None
    cost_total: Optional[float] = Field(None, ge=0.0)
    kilometraj_la_serviciu: Optional[float] = Field(None, ge=0.0)

class ManagementServiceResponse(ManagementServiceBase):
    id: int
    car_id: int

    model_config = ConfigDict(from_attributes=True)