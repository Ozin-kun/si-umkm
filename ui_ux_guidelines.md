UI/UX Design Guidelines

1. Prinsip Desain

Mobile-First: Pendekatan responsif wajib dilakukan karena pelaku UMKM dan pengunjung kemungkinan besar menggunakan smartphone.

Keep it Simple: Antarmuka harus bersih, minim clutter, dan mudah dipahami oleh pengguna awam (warga desa).

Konsistensi Visual: Gunakan utilitas framework Tailwind CSS secara konsisten untuk membangun button, form, dan typography (hindari CSS custom berlebihan).

2. Struktur Tata Letak (Layouts)

A. Tampilan Publik (Katalog)

Header/Navbar: Logo desa, menu navigasi (Beranda, Kategori, Tentang), dan tombol "Login/Daftar".

Hero Section: Banner sambutan dan kolom pencarian (Search Bar).

Katalog (Grid): Daftar UMKM berupa Card (Foto utama, Nama, Kategori, Label "Terverifikasi"). Tailwind Grid/Flexbox sangat disarankan di sini.

Footer: Informasi kontak desa dan tautan penting.

B. Tampilan Dashboard (Internal Admin & UMKM)

Sidebar (Kiri): Menu navigasi vertikal (collapsible di mobile menggunakan script JS sederhana).

Top Bar (Atas): Info user yang sedang login, tombol Logout.

Main Content (Tengah): Tabel data (responsive tables), form input, stat-cards.

3. Komponen Spesifik

Status Badges: - Disetujui: Hijau (Tailwind: bg-green-100 text-green-800)

Menunggu Verifikasi: Kuning/Oranye (Tailwind: bg-yellow-100 text-yellow-800)

Ditolak/Direvisi: Merah (Tailwind: bg-red-100 text-red-800)

Nonaktif: Abu-abu (Tailwind: bg-gray-100 text-gray-800)

Forms: Wajib memiliki label yang jelas, border state untuk error (Tailwind: border-red-500), teks pesan error, dan placeholder.