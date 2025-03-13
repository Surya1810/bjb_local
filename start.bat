@echo off
:: Menjalankan Laragon dalam mode minimize
start /min C:\laragon\laragon.exe

:: Menunggu beberapa detik agar Laragon sepenuhnya berjalan
timeout /t 2 /nobreak >nul

:: Menampilkan IP Address
echo Menampilkan IP Address...
ipconfig | findstr /i "IPv4"

:: Menjalankan Laravel Reverb dalam mode minimize
start /min cmd /c "cd /d C:\laragon\www\bjb_local && C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan reverb:serve"

:: Menunggu beberapa detik agar Laravel siap
timeout /t 3 /nobreak >nul

:: Membuka Laravel di browser
start http://192.168.0.101:3000

exit
