from pydantic import BaseModel, Field, ConfigDict
from typing import Optional
from app.models.models import SezonAnvelopa


class AnvelopaBase(BaseModel):
    sezon: SezonAnvelopa
    marca: Optional[str] = Field(None, min_length=2, max_length=50)
    dimensiuni: Optional[str] = Field(None, max_length=20, description="Ex: 205/55 R16")
    stare_uzura: Optional[str] = Field(None, max_length=50, description="Ex: Nou, Bun, De schimbat, 5mm")
    locatie: Optional[str] = Field(None, max_length=100, description="Ex: Pe mașină, Depozit sediu, Hotel")


class AnvelopaCreate(AnvelopaBase):
    car_id: Optional[int] = None

class AnvelopaUpdate(BaseModel):
    sezon: Optional[SezonAnvelopa] = None
    marca: Optional[str] = Field(None, min_length=2, max_length=50)
    dimensiuni: Optional[str] = Field(None, max_length=20)
    stare_uzura: Optional[str] = Field(None, max_length=50)
    locatie: Optional[str] = Field(None, max_length=100)

    car_id: Optional[int] = None

class AnvelopaResponse(AnvelopaBase):
    id: int
    car_id: Optional[int] = None

    model_config = ConfigDict(from_attributes=True)
