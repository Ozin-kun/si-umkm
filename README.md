<div align="center">
  <h1>SI-UMKM Desa Joho 🏪</h1>
  <p><strong>Portal Sistem Informasi dan Katalog Digital UMKM Desa Joho, Kecamatan Prambanan</strong></p>
</div>

---

## 📖 Tentang Proyek
Sistem Informasi UMKM (SI-UMKM) adalah platform berbasis web yang dikembangkan untuk mendigitalkan ekosistem Usaha Mikro, Kecil, dan Menengah (UMKM) di Desa Joho. Proyek ini diinisiasi sebagai bentuk pengabdian masyarakat oleh Kelompok KKN 120 UIN Sunan Kalijaga Desa Joho untuk membantu pelaku usaha lokal memperluas jangkauan pasar, memudahkan promosi produk, serta memberikan kemudahan akses informasi bagi warga dan wisatawan.

## ✨ Fitur Utama
* **Katalog Produk Publik:** Etalase digital responsif dengan fitur pencarian cerdas.
* **Integrasi WhatsApp:** Pengunjung dapat langsung menghubungi penjual melalui tautan WhatsApp.
* **Integrasi Lokasi:** Navigasi ke lokasi UMKM yang terhubung langsung dengan Google Maps.
* **Dashboard Administrator:** Panel khusus bagi Perangkat Desa untuk mengelola data kategori, memverifikasi akun UMKM, dan memantau aktivitas sistem.
* **Dashboard UMKM:** Panel mandiri bagi pelaku usaha untuk memperbarui profil, titik lokasi, serta mengunggah foto tempat dan katalog produk.

## 🛠️ Teknologi yang Digunakan
* **Framework Backend:** [Laravel 10](https://laravel.com/) (PHP)
* **Framework Frontend:** [Tailwind CSS](https://tailwindcss.com/) & Alpine.js
* **Database:** MySQL / MariaDB
* **Web Server (Production):** Nginx (di VPS Linux Ubuntu)

## 🚀 Panduan Instalasi (Lokal)

Jika Anda ingin menjalankan proyek ini di komputer lokal untuk pengembangan lanjutan, ikuti langkah-langkah berikut:

**Prasyarat:**
* PHP >= 8.1
* Composer
* Node.js & NPM
* MySQL (XAMPP/Laragon/DBngin)

**Langkah Instalasi:**
1. Clone repositori ini
   ```bash
   git clone https://github.com/Ozin-kun/si-umkm.git
   cd si-umkm
2. Instal dependensi PHP menggunakan Composer
   ```bash
   composer install
3. Instal dependensi Node.js
   ```bash
   npm install
4. Salin file konfigurasi environment
   ```bash
   cp .env.example .env
5. Hasilkan Application Key Laravel
   ```bash
   php artisan key:generate
6. Atur konfigurasi database pada file .env
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
7. Jalankan migrasi dan tanam data bawaan (seeder)
   ```bash
   php artisan migrate --seed
8. Build aset visual (Tailwind CSS)
   ```bash
   npm run dev
9. Jalankan server lokal
    ``` bash
    php artisan serve
