from pydantic import BaseModel, Field, ConfigDict
from datetime import datetime

class NotificationBase(BaseModel):
    title: str = Field(..., min_length=2, max_length=100)
    message: str = Field(..., min_length=2, max_length=255)
    type: str = Field(..., max_length=50, description="Ex: ITP_EXPIRA, RCA_EXPIRA")
    read: bool = False

class NotificationCreate(NotificationBase):
    pass

class NotificationUpdate(BaseModel):
    read: bool

class NotificationResponse(NotificationBase):
    id: int
    timestamp: datetime

    model_config = ConfigDict(from_attributes=True)
