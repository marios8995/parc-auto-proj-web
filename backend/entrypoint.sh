#!/bin/sh

echo "[DOCKER] Se inițializează containerul backend..."

python -c "
import time, pymysql, os

host = os.getenv('DB_HOST', 'db')
user = os.getenv('DB_USER', 'fleetuser')
password = os.getenv('DB_PASSWORD')
db_name = os.getenv('DB_NAME', 'fleet_db')

print(f'Așteptăm conexiunea la baza de date {host}...')
while True:
    try:
        conn = pymysql.connect(host=host, user=user, password=password, database=db_name, connect_timeout=3)
        conn.close()
        print('[DOCKER] Baza de date este gata și acceptă conexiuni!')
        break
    except Exception:
        print('[DOCKER] Baza de date nu e gata încă. Reîncercăm în 2 secunde...')
        time.sleep(2)
"

echo "[DOCKER] Se verifică/creează contul de Administrator suprem..."
python -m app.init_admin

echo "[DOCKER] Se lansează serverul FastAPI web..."
exec uvicorn app.main:app --host 0.0.0.0 --port 8000
