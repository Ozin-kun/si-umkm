Security Guidelines

1. Autentikasi & Otorisasi

Password Hashing: Semua kata sandi wajib di-hash menggunakan bcrypt (bawaan Laravel Hash::make()). Jangan pernah simpan dalam plain-text.

Role-Based Access Control (RBAC): Lindungi routes (URL) menggunakan Middleware.

Akses /admin/* hanya untuk Role = Admin.

Akses /dashboard/* hanya untuk Role = Pelaku UMKM.

Session Security: Aktifkan session timeout untuk keamanan akun publik di komputer bersama.

2. Proteksi Input & Serangan

CSRF Protection: Wajib sertakan token @csrf di setiap form HTML (POST, PUT, DELETE).

SQL Injection Prevention: Selalu gunakan Query Builder atau Eloquent ORM Laravel (otomatis me-escape parameter). Jangan gunakan parameter kueri mentah (raw queries).

XSS Prevention: Gunakan sintaks double curly braces {{ $variabel }} di file Blade agar output otomatis di-escape dengan htmlspecialchars. Hindari penggunaan {!! !!} kecuali benar-benar perlu (seperti konten berita dari Rich Text Editor tepercaya).

3. Validasi & File Upload

Server-side Validation: Wajib mevalidasi semua input di tingkat Controller menggunakan $request->validate(). Jangan hanya mengandalkan validasi HTML5.

File Upload Security: - Batasi ekstensi ke mimes:jpeg,png,jpg,webp.

Batasi ukuran maksimal ke max:2048 (2MB).

Gunakan hashed name untuk penyimpanan file agar sulit ditebak.