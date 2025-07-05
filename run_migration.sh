#!/bin/bash

echo "🚀 Memulai migrasi dari sistem Pupuk ke sistem ATK..."

echo "📦 Menjalankan migration..."
php artisan migrate

echo "🌱 Menjalankan seeder..."
php artisan db:seed

echo "🖼️  Mengisi gambar ATK..."
php artisan atk:populate-images

echo "✅ Migrasi selesai!"
echo ""
echo "📋 Informasi penting:"
echo "- Email admin: admin@atk.com"
echo "- Password: password"
echo "- API endpoint: /api/atk"
echo "- Filament admin: /admin"
echo ""
echo "🔗 Endpoint API baru:"
echo "- GET /api/atk - Daftar ATK"
echo "- GET /api/atk/{slug} - Detail ATK"
echo "- GET /api/kategori - Daftar kategori"
echo ""
echo "🎯 Selamat! Sistem ATK sudah siap digunakan." 