from pydantic import BaseModel, Field, field_validator, ConfigDict
from typing import Optional
from datetime import datetime

class VinietaBase(BaseModel):
    tara: str = Field(..., min_length=2, max_length=10, description="Codul țării, ex: RO, HU, AT")
    data_inceput: Optional[datetime] = None
    data_expirare: datetime
    cost: Optional[float] = Field(None, ge=0.0)

    @field_validator('tara')
    @classmethod
    def uppercase_tara(cls, value: str) -> str:
        return value.upper() if value else value

class VinietaCreate(VinietaBase):
    car_id: int

class VinietaUpdate(BaseModel):
    tara: Optional[str] = Field(None, min_length=2, max_length=10)
    data_inceput: Optional[datetime] = None
    data_expirare: Optional[datetime] = None
    cost: Optional[float] = Field(None, ge=0.0)

    @field_validator('tara')
    @classmethod
    def uppercase_tara(cls, value: Optional[str]) -> Optional[str]:
        return value.upper() if value else value

class VinietaResponse(VinietaBase):
    id: int
    car_id: int

    model_config = ConfigDict(from_attributes=True)
