from fastapi import HTTPException, status

class ErrorCodes:
    CAR_NOT_FOUND = "CAR_NOT_FOUND"
    CAR_ALREADY_EXISTS = "CAR_ALREADY_EXISTS"
    DRIVER_NOT_FOUND = "DRIVER_NOT_FOUND"
    INVALID_CREDENTIALS = "INVALID_CREDENTIALS"

ERROR_MESSAGES = {
    ErrorCodes.CAR_NOT_FOUND: "Mașina căutată nu a fost găsită în baza de date.",
    ErrorCodes.CAR_ALREADY_EXISTS: "Există deja o mașină cu acest număr de înmatriculare.",
    ErrorCodes.DRIVER_NOT_FOUND: "Șoferul specificat nu există.",
    ErrorCodes.INVALID_CREDENTIALS: "Email sau parolă incorectă.",
}

def raise_api_error(error_code: str, status_code: int = status.HTTP_400_BAD_REQUEST):
    raise HTTPException(
        status_code=status_code,
        detail={
            "code": error_code,
            "message": ERROR_MESSAGES.get(error_code, "Eroare internă necunoscută.")
        }
    )
