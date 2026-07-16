Testing Strategy & QA

1. Fokus Pengujian

Karena proyek ini adalah Solo Development, pengujian akan difokuskan pada pengujian fungsional manual dan validasi Business Rules.

2. Skenario Uji Kritis (Test Cases)

A. Autentikasi

[ ] User tidak bisa registrasi dengan email yang sudah ada.

[ ] User salah password gagal login.

[ ] User tipe 'Pelaku UMKM' mencoba mengakses URL /admin harus ditolak (403 Forbidden).

B. Alur Verifikasi (Sesuai State Diagram)

[ ] Profil baru otomatis berstatus "Menunggu Verifikasi".

[ ] Profil dengan status "Menunggu Verifikasi" tidak muncul di halaman pencarian Publik.

[ ] Admin menerima profil -> Status berubah "Disetujui" -> Tampil di Publik.

[ ] Admin menolak profil -> Harus mengisi kolom alasan penolakan.

[ ] Profil yang disetujui diedit oleh Pelaku UMKM -> Status kembali ke "Menunggu Verifikasi".

C. Manajemen Data (CRUD)

[ ] Pelaku UMKM A tidak dapat mengedit, menghapus, atau melihat produk milik Pelaku UMKM B.

[ ] Fitur Upload menolak file .pdf atau gambar lebih dari 2MB.

[ ] Pencarian (Search) di halaman publik menampilkan hasil yang relevan.

3. User Acceptance Testing (UAT)

Dilakukan bersama Dosen Pembimbing dan Perangkat Desa pada tahap akhir increment:

Mendemonstrasikan kelancaran alur Pendaftaran -> Verifikasi -> Tampil di Katalog Publik.