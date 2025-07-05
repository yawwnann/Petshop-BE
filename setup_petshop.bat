@echo off
echo ========================================
echo Setup PetShop - Migration dan Seeding
echo ========================================

echo.
echo 1. Menjalankan migration...
php artisan migrate:fresh

echo.
echo 2. Menjalankan seeder...
php artisan db:seed

echo.
echo 3. Setup selesai!
echo ========================================
pause 