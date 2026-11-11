@echo off
rem Liga o servidor do treino de ingles e abre o navegador.
rem Para desligar, feche esta janela.

cd /d "%~dp0"

echo Treino de ingles ligado em http://localhost:8123
echo Para desligar, feche esta janela.
echo.

rem Abre o navegador um segundo depois, para dar tempo de o servidor ligar.
start "" /b cmd /c "ping -n 2 127.0.0.1 >nul & start http://localhost:8123"

php -d upload_max_filesize=10M -d post_max_size=12M -S localhost:8123 -t public

echo.
echo O servidor parou. Se apareceu um erro acima, mostre para o Claude.
pause
