from pydantic import BaseModel, ConfigDict
from typing import Optional
from datetime import datetime

class DriverCarAssociationBase(BaseModel):
    driver_id: int
    car_id: int
    data_preluare: Optional[datetime] = None
    data_predare: Optional[datetime] = None

class DriverCarAssociationCreate(DriverCarAssociationBase):
    pass

class DriverCarAssociationUpdate(BaseModel):
    data_predare: datetime

class DriverCarAssociationResponse(DriverCarAssociationBase):
    id: int
    model_config = ConfigDict(from_attributes=True)
