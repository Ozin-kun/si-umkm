Product Requirements Document (PRD) - SI-UMKM

1. Visi Produk

Katalog digital terpusat untuk mendata, memverifikasi, dan mempromosikan UMKM di lingkungan desa agar mudah diakses oleh masyarakat luas.

2. Scope & Out-of-Scope

In-Scope: Registrasi akun, kelola profil UMKM, katalog produk, galeri foto, sistem verifikasi (Terima/Tolak/Revisi), dashboard statistik sederhana, pencarian & filter publik.

Out-of-Scope: Transaksi online (Checkout/Cart), Payment Gateway, Pengiriman/Logistik, Fitur Chat internal (diarahkan ke WhatsApp).

3. User Personas

Admin Desa: Verifikator kelayakan data UMKM. Butuh dashboard rekapitulasi yang jelas.

Pelaku UMKM: Pemilik usaha. Fokus pada kemudahan input data dan unggah foto produk dari HP.

Pengunjung: Masyarakat umum. Fokus pada kemudahan mencari produk dan melihat lokasi peta.

4. Prioritas Fitur (MVP)

P0 (Kritis): Auth (Login/Register), CRUD Profil UMKM, CRUD Produk, Verifikasi Admin.

P1 (Penting): Katalog Publik, Pencarian/Filter, Galeri Foto.

P2 (Tambahan): Manajemen Berita, Dashboard Grafik Statistik.

5. Aturan Bisnis Kunci

1 Akun Email = 1 User.

1 Akun Pelaku UMKM = 1 Profil Usaha.

Profil dan Produk tidak tampil di publik jika status belum "Disetujui".

Perubahan data krusial memicu status kembali ke "Menunggu Verifikasi".

Data yang disetujui tidak bisa dihapus Admin, hanya di-"Nonaktifkan".