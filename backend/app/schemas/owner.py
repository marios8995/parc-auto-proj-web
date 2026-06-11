from pydantic import BaseModel, Field, EmailStr, ConfigDict
from typing import Optional

class OwnerBase(BaseModel):
    nume: str = Field(..., min_length=2, max_length=100)
    tip: Optional[str] = Field(None, max_length=50)  # Ex: Leasing, SRL, PF
    cui_cnp: Optional[str] = Field(None, min_length=2, max_length=20)
    adresa: Optional[str] = Field(None, max_length=200)
    telefon_contact: Optional[str] = Field(None, max_length=20)
    email_contact: Optional[EmailStr] = None

class OwnerCreate(OwnerBase):
    nume: str = Field(..., min_length=2, max_length=100)
    cui_cnp: str = Field(..., min_length=2, max_length=20)

class OwnerUpdate(BaseModel):
    nume: Optional[str] = Field(None, min_length=2, max_length=100)
    tip: Optional[str] = Field(None, max_length=50)
    cui_cnp: Optional[str] = Field(None, min_length=2, max_length=20)
    adresa: Optional[str] = Field(None, max_length=200)
    telefon_contact: Optional[str] = Field(None, max_length=20)
    email_contact: Optional[EmailStr] = None

class OwnerResponse(OwnerBase):
    id: int
    model_config = ConfigDict(from_attributes=True)
