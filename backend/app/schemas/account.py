from pydantic import BaseModel, Field, EmailStr, field_validator, ConfigDict
from typing import Optional
from datetime import datetime
from app.models.models import UserRole

class AccountBase(BaseModel):
    username: str = Field(..., min_length=3, max_length=50)
    email: EmailStr
    is_active: Optional[bool] = True
    role: Optional[UserRole] = UserRole.USER

class AccountCreate(AccountBase):
    password: str = Field(..., min_length=8, max_length=100)

    @field_validator('password')
    @classmethod
    def validate_password_strength(cls, value: str) -> str:
        if not any(char.isdigit() for char in value):
            raise ValueError("Parola trebuie să conțină cel puțin o cifră.")
        if not any(char.isupper() for char in value):
            raise ValueError("Parola trebuie să conțină cel puțin o literă mare.")
        return value

class AccountUpdate(BaseModel):
    username: Optional[str] = Field(None, min_length=3, max_length=50)
    email: Optional[EmailStr] = None
    is_active: Optional[bool] = None
    role: Optional[UserRole] = None

class AccountResponse(AccountBase):
    id: int
    created_at: datetime
    updated_at: datetime

    model_config = ConfigDict(from_attributes=True)
