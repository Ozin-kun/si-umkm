Task Instruction & Implementation Plan (Incremental)

Increment 1: Inisiasi & Autentikasi Dasar

Target: Aplikasi bisa diakses, database terhubung, bisa Login/Register.

Setup Project: Install Laravel 10, atur .env, dan inisialisasi framework UI (Tailwind CSS melalui npm atau Vite).

Database Migration: Buat tabel roles, users dan seeder data Admin.

Auth System: Buat fungsi Registrasi, Login, dan Logout (gunakan Breeze minimalis atau buat manual).

Middleware: Buat middleware kustom IsAdmin dan IsUmkm (atau manfaatkan route middleware Laravel 10) untuk memproteksi akses dashboard.

Increment 2: Manajemen Profil & Alur Verifikasi (MVP Kritis)

Target: Pelaku UMKM bisa melengkapi profil, Admin bisa melakukan verifikasi.

Database Migration: Buat tabel umkms, categories, verification_logs.

UMKM Dashboard: Buat form UI (menggunakan Tailwind classes) untuk melengkapi profil (Nama, Alamat, Kategori, Foto).

File Upload: Terapkan logika unggah foto dengan validasi ketat.

Admin Dashboard: Buat tabel daftar pengajuan UMKM.

Logika Verifikasi: Implementasi fungsi tombol "Setujui" dan "Tolak" (beserta input alasan penolakan).

Implementasi Aturan Bisnis: Pastikan BR-04 (edit data mengubah status kembali pending) berjalan.

Increment 3: Katalog Produk & Berita

Target: Pelaku UMKM bisa menambah barang dagangan.

Database Migration: Buat tabel products.

Product CRUD: Buat fungsi Tambah, Edit, Hapus, Tampil produk di dashboard UMKM.

News CRUD: Buat fungsi kelola berita di dashboard Admin.

Increment 4: Sisi Pengunjung (Public Frontend)

Target: Publik bisa mencari UMKM.

Beranda & Pencarian: Buat UI Katalog, terapkan logika pencarian nama dan filter kategori (Pastikan hanya query UMKM berstatus "Disetujui").

Halaman Detail: Buat halaman detail profil UMKM yang menampilkan galeri/produk dan peta Google Maps (titik koordinat).

Increment 5: Finishing & Testing

Target: Siap rilis.

Dashboard Statistik: Buat chart/cards rangkuman di halaman beranda Admin.

QA & Bug Fixing: Lakukan uji coba berdasarkan skenario di testing.md.

Deployment: Pindahkan ke hosting.