from fastapi import HTTPException, status

class ErrorCodes:
    NOTIFICATION_NOT_FOUND = "NOTIFICATION_NOT_FOUND"
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
    EMAIL_ALREADY_USED = "EMAIL_ALREADY_USED"
    USERNAME_ALREADY_USED = "USERNAME_ALREADY_USED"
    USER_NOT_FOUND = "USER_NOT_FOUND"
    CREDENTIALS_EXCEPTION = "CREDENTIALS_EXCEPTION"
    ACCOUNT_INACTIVE = "ACCOUNT_INACTIVE"
    ACCOUNT_NOT_ADMIN = "ACCOUNT_NOT_ADMIN"

ERROR_MESSAGES = {
    ErrorCodes.NOTIFICATION_NOT_FOUND: "Notificarea căutată nu a fost găsită.",
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
    ErrorCodes.VIGNETTE_NOT_FOUND: "Vinieta specificată nu a fost găsită.",
    ErrorCodes.EMAIL_ALREADY_USED: "Acest email este deja folosit.",
    ErrorCodes.USERNAME_ALREADY_USED: "Acest username este deja folosit.",
    ErrorCodes.USER_NOT_FOUND: "Utilizatorul specificat nu a fost găsit.",
    ErrorCodes.CREDENTIALS_EXCEPTION: "Credențiale invalide sau token expirat",
    ErrorCodes.ACCOUNT_INACTIVE: "Contul utilizatorului este inactiv.",
    ErrorCodes.ACCOUNT_NOT_ADMIN: "Nu ai permisiuni suficiente pentru această acțiune."
}

def raise_api_error(error_code: str, status_code: int = status.HTTP_400_BAD_REQUEST, headers=None):
    if headers is None:
        headers = {}
    raise HTTPException(
        status_code=status_code,
        detail={
            "code": error_code,
            "message": ERROR_MESSAGES.get(error_code, "Eroare internă necunoscută.")
        },
        headers=headers
    )
