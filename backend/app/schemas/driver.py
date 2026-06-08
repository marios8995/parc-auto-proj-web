from pydantic import BaseModel, Field, field_validator, ConfigDict
from typing import Optional
from datetime import datetime

class DriverBase(BaseModel):
    nume_complet: str = Field(..., min_length=3, max_length=100)
    telefon: Optional[str] = Field(None, max_length=20)
    cnp: Optional[str] = Field(None, min_length=13, max_length=13)
    numar_permis: Optional[str] = Field(None, max_length=50)
    data_expirare_permis: Optional[datetime] = None

    @field_validator('cnp')
    @classmethod
    def validate_cnp(cls, value: Optional[str]) -> Optional[str]:
        if value is not None and not value.isdigit():
            raise ValueError("CNP-ul trebuie să conțină exact 13 cifre, fără litere sau alte caractere.")
        return value

class DriverCreate(DriverBase):
    cnp: str = Field(..., min_length=13, max_length=13)
    numar_permis: str = Field(..., min_length=3, max_length=50)

class DriverUpdate(BaseModel):
    nume_complet: Optional[str] = Field(None, min_length=3, max_length=100)
    telefon: Optional[str] = Field(None, max_length=20)
    cnp: Optional[str] = Field(None, min_length=13, max_length=13)
    numar_permis: Optional[str] = Field(None, max_length=50)
    data_expirare_permis: Optional[datetime] = None

class DriverResponse(DriverBase):
    id: int

    model_config = ConfigDict(from_attributes=True)
