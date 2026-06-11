from pydantic import BaseModel, Field, ConfigDict
from typing import Optional
from datetime import datetime
from app.models.models import TipAsigurare

class AsigurareBase(BaseModel):
    tip: TipAsigurare
    companie: Optional[str] = Field(None, min_length=2, max_length=100)
    data_inceput: Optional[datetime] = None
    data_expirare: datetime
    cost: Optional[float] = Field(None, ge=0.0)

class AsigurareCreate(AsigurareBase):
    car_id: int

class AsigurareUpdate(BaseModel):
    tip: Optional[TipAsigurare] = None
    companie: Optional[str] = Field(None, min_length=2, max_length=100)
    data_inceput: Optional[datetime] = None
    data_expirare: Optional[datetime] = None
    cost: Optional[float] = Field(None, ge=0.0)

class AsigurareResponse(AsigurareBase):
    id: int
    car_id: int

    model_config = ConfigDict(from_attributes=True)
