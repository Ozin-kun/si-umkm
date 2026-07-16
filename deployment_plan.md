Deployment & Hosting Plan

1. Infrastruktur Target

Mengingat proyek KKN memerlukan solusi terjangkau yang mudah dioperasikan desa, lingkungan deployment yang direkomendasikan adalah:

Shared Hosting (dengan dukungan SSH dan PHP/Composer) ATAU VPS Sederhana (misal: Niagahoster, Hostinger).

Domain spesifik desa (misal: umkm.nama-desa.desa.id).

2. Ceklis Pra-Deployment (Server-side)

Versi PHP: Pastikan server menjalankan minimal PHP 8.1 (Syarat wajib untuk Laravel 10).

Ekstensi PHP: Pastikan bcmath, ctype, fileinfo, json, mbstring, openssl, PDO, tokenizer, xml telah aktif.

Database: Buat database MySQL di CPanel/Panel VPS.

3. Langkah-langkah Deployment

Upload Code: Lakukan git clone (jika ada akses SSH) atau kompres kode sumber ke dalam format .zip dan ekstrak di public_html atau direktori addon domain.

Konfigurasi Environment: - Kopi file .env.example menjadi .env.

Konfigurasi parameter DB_DATABASE, DB_USERNAME, DB_PASSWORD.

Ubah APP_ENV=production dan APP_DEBUG=false.

Set APP_URL ke domain resmi.

Instalasi Dependensi: Jalankan composer install --optimize-autoloader --no-dev.

Generate Key: Jalankan php artisan key:generate.

Migrasi Database: Jalankan php artisan migrate --seed (jika menggunakan Seeder akun awal Admin).

Storage Link: Jalankan php artisan storage:link agar file gambar bisa diakses publik.

4. Keamanan Pasca-Deployment

Pastikan folder selain /public tidak dapat diakses langsung oleh browser (lindung via .htaccess).

Instal sertifikat SSL (Let's Encrypt / AutoSSL CPanel) untuk akses HTTPS.