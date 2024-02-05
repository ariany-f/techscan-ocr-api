::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:: Framework Tecno command shell
:: @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
:: @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
@echo.
@echo off
SET app=%0
SET lib=%~dp0
php "%lib%tecnoprog.php" %*
echo.
exit /B %ERRORLEVEL%