Architecture & Tech Stack Guidelines

1. Tech Stack Inti

Backend Framework: Laravel (PHP) - Versi 10.

Database: MySQL / MariaDB.

Frontend: Blade Templating Engine + Tailwind CSS.

Web Server: Apache / Nginx.

2. Pola Arsitektur (MVC)

Sistem mematuhi pola Model-View-Controller murni:

Model (M): Representasi entitas (User, UMKM, Product, Category, VerificationLog). Menangani logika bisnis database dan relasi (Eloquent ORM).

View (V): Antarmuka pengguna berbasis file .blade.php. Terbagi menjadi layout publik dan layout admin/dashboard menggunakan gaya utilitas Tailwind.

Controller (C): Penghubung V dan M. (Contoh: UmkmController, AuthController, ProductController).

3. Modul Sistem (Berdasarkan Component Diagram)

Authentication Module: Menangani registrasi, login, logout, password hashing, dan sesi.

Public Catalog Module: (Read-only untuk publik) Menampilkan daftar UMKM dan detail produk.

Dashboard UMKM Module: Panel untuk pelaku usaha mengelola data usahanya.

Dashboard Admin Module: Panel untuk Admin desa memverifikasi UMKM dan mengelola Master Data.

4. Database Schema Guidelines

Gunakan fitur Migration Laravel 10 untuk mendefinisikan skema.

Terapkan Foreign Key Constraints dengan onDelete('cascade') atau onDelete('restrict') sesuai kebutuhan logika (Misal: User dihapus -> UMKM dihapus).