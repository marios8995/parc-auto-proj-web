@echo off
setlocal enabledelayedexpansion

IF NOT EXIST ".env" (
    echo [!] Nu s-a gasit fisierul .env.
    echo.

    set /p DB_PASS="1. Alege o parola pt Baza de Date: "
    set /p ADMIN_PASS="2. Alege o parola pt contul tau de Admin: "
    set /p SECRET="3. Tasteaza cateva litere la intamplare (cheie de securitate): "

    echo Creare fisier .env...
    echo DB_USER=fleetuser> .env
    echo DB_PASSWORD=!DB_PASS!>> .env
    echo DB_HOST=db>> .env
    echo DB_PORT=3306>> .env
    echo DB_NAME=fleet_db>> .env
    
    echo SECRET_KEY=!SECRET!>> .env
    echo ALGORITHM=HS256>> .env
    echo ACCESS_TOKEN_EXPIRE_MINUTES=60>> .env
    
    echo FIRST_ADMIN_USERNAME=admin>> .env
    echo FIRST_ADMIN_PASSWORD=!ADMIN_PASS!>> .env
    echo FIRST_ADMIN_EMAIL=admin@flota.ro>> .env

    echo.
    echo [OK] Fisierul .env a fost creat cu succes!
    echo.
) ELSE (
    echo [OK] Fisierul .env exista deja. Trecem la pornire...
    echo.
)

echo Pornim containerele Docker...
docker-compose up -d --build

echo.
echo ====================================================
echo  API-ul ruleaza cu succes.
echo  Poți accesa documentația API-ului la adresa:
echo  http://localhost:8000/docs
echo ====================================================
pause
