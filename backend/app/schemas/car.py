from pydantic import BaseModel, Field, field_validator, ConfigDict
from typing import Optional, Literal
from datetime import datetime

class CarBase(BaseModel):
    nr_inmatriculare: str = Field(..., min_length=5, max_length=20)
    marca: str = Field(..., min_length=2, max_length=50)
    model: str = Field(..., min_length=1, max_length=50)
    an_fabricatie: int
    kilometraj: float = Field(default=0.0, ge=0.0)

    status: Literal["activ", "in_service", "inactiv"] = "activ"
    data_expirare_itp: Optional[datetime] = None

    tip_caroserie: Optional[str] = Field(None, max_length=50)
    tip_combustibil: Optional[str] = Field(None, max_length=50)
    numar_locuri: Optional[int] = Field(None, gt=0, le=60)
    culoare: Optional[str] = Field(None, max_length=30)
    categorie: Optional[str] = Field(None, max_length=30)
    capacitate_cilindrica: Optional[float] = Field(None, gt=0.0)
    putere: Optional[float] = Field(None, gt=0.0)

    pret: Optional[float] = Field(None, ge=0.0)
    disponibil: bool = True

    img_url: Optional[str] = None

    @field_validator('an_fabricatie')
    @classmethod
    def validate_an_fabricatie(cls, value: int) -> int:
        an_curent = datetime.now().year
        if value < 1900 or value > an_curent:
            raise ValueError(f"Anul de fabricație trebuie să fie între 1900 și {an_curent}.")
        return value

class CarCreate(CarBase):
    serie_sasiu: str = Field(..., min_length=17, max_length=17)

class CarUpdate(BaseModel):
    nr_inmatriculare: Optional[str] = Field(None, min_length=5, max_length=20)
    kilometraj: Optional[float] = Field(None, ge=0.0)
    status: Optional[Literal["activ", "in_service", "inactiv"]] = None
    data_expirare_itp: Optional[datetime] = None
    disponibil: Optional[bool] = None
    culoare: Optional[str] = Field(None, max_length=30)
    pret: Optional[float] = Field(None, ge=0.0)

class CarResponse(CarBase):
    id: int
    serie_sasiu: str
    created_at: datetime
    updated_at: datetime

    model_config = ConfigDict(from_attributes=True)
