from fastapi import HTTPException, status

class ErrorCodes:
    TIRE_NOT_FOUND = "TIRE_NOT_FOUND"
    ASSOCIATION_NOT_FOUND = "ASSOCIATION_NOT_FOUND"
    CAR_NOT_FOUND = "CAR_NOT_FOUND"
    CAR_ALREADY_EXISTS = "CAR_ALREADY_EXISTS"
    DRIVER_NOT_FOUND = "DRIVER_NOT_FOUND"
    INVALID_CREDENTIALS = "INVALID_CREDENTIALS"
    DRIVER_ALREADY_EXISTS = "DRIVER_ALREADY_EXISTS"
    CNP_ALREADY_USED = "CNP_ALREADY_USED"
    OWNER_ALREADY_EXISTS = "OWNER_ALREADY_EXISTS"
    OWNER_NOT_FOUND = "OWNER_NOT_FOUND"
    OWNER_HAS_ACTIVE_CARS = "OWNER_HAS_ACTIVE_CARS"
    SERVICE_RECORD_NOT_FOUND = "SERVICE_RECORD_NOT_FOUND"
    INSURANCE_NOT_FOUND = "INSURANCE_NOT_FOUND"
    VIGNETTE_NOT_FOUND = "VIGNETTE_NOT_FOUND"

ERROR_MESSAGES = {
    ErrorCodes.TIRE_NOT_FOUND: "Anvelopa căutată nu a fost găsită.",
    ErrorCodes.ASSOCIATION_NOT_FOUND: "Asocierea căutată nu a fost găsită.",
    ErrorCodes.CAR_NOT_FOUND: "Mașina căutată nu a fost găsită în baza de date.",
    ErrorCodes.CAR_ALREADY_EXISTS: "Există deja o mașină cu acest număr de înmatriculare.",
    ErrorCodes.DRIVER_NOT_FOUND: "Șoferul specificat nu există.",
    ErrorCodes.INVALID_CREDENTIALS: "Email sau parolă incorectă.",
    ErrorCodes.DRIVER_ALREADY_EXISTS: "Există deja un șofer cu acest CNP sau număr de permis.",
    ErrorCodes.CNP_ALREADY_USED: "Acest CNP este deja folosit de alt șofer.",
    ErrorCodes.OWNER_ALREADY_EXISTS: "Există deja un proprietar cu acest CUI/CNP.",
    ErrorCodes.OWNER_NOT_FOUND: "Proprietarul specificat nu a fost găsit.",
    ErrorCodes.OWNER_HAS_ACTIVE_CARS: "Acest proprietar are mașini active și nu poate fi șters.",
    ErrorCodes.SERVICE_RECORD_NOT_FOUND: "Înregistrarea de service specificată nu a fost găsită.",
    ErrorCodes.INSURANCE_NOT_FOUND: "Asigurarea specificată nu a fost găsită.",
    ErrorCodes.VIGNETTE_NOT_FOUND: "Vinieta specificată nu a fost găsită."
}

def raise_api_error(error_code: str, status_code: int = status.HTTP_400_BAD_REQUEST):
    raise HTTPException(
        status_code=status_code,
        detail={
            "code": error_code,
            "message": ERROR_MESSAGES.get(error_code, "Eroare internă necunoscută.")
        }
    )
