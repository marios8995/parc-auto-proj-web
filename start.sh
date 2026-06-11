#!/bin/bash

set -e

if [ ! -f ".env" ]; then
    echo "[!] Nu s-a găsit fișierul .env."
    echo ""
    echo -n "1. Alege o parolă pt Baza de Date: "
    read -s DB_PASS
    echo ""
    
    echo -n "2. Alege o parolă pt contul tău de Admin: "
    read -s ADMIN_PASS
    echo ""
    
    read -p "3. Tastează câteva litere la întâmplare (cheie de securitate JWT): " SECRET

    echo "Se generează fișierul .env..."
    cat << EOF > .env
DB_USER=fleetuser
DB_PASSWORD=$DB_PASS
DB_HOST=db
DB_PORT=3306
DB_NAME=fleet_db

SECRET_KEY=$SECRET
ALGORITHM=HS256
ACCESS_TOKEN_EXPIRE_MINUTES=60

FIRST_ADMIN_USERNAME=admin
FIRST_ADMIN_PASSWORD=$ADMIN_PASS
FIRST_ADMIN_EMAIL=admin@flota.ro
EOF

    echo ""
    echo "[OK] Fișierul .env a fost creat cu succes!"
    echo ""
else
    echo "[OK] Fișierul .env există deja. Trecem direct la pornire..."
    echo ""
fi

echo "Se pornesc containerele Docker în fundal (detached)..."
docker-compose up -d --build

echo ""
echo "===================================================="
echo "  API-ul rulează în fundal."
echo "  Poți accesa documentația API-ului la adresa:"
echo "  http://localhost:8000/docs"
echo "===================================================="
