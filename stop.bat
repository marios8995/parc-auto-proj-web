@echo off
setlocal enabledelayedexpansion

echo Se opresc containerele Fleet Management...
docker-compose down
echo.
echo [OK] Toate containerele au fost oprite cu succes!
