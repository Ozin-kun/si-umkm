 <!-- NProgress CSS via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

<!-- Kustomisasi Warna NProgress agar senada dengan Tailwind Indigo-600 -->
<style>
    /* Mengubah warna bar utama */
    #nprogress .bar {
        background: #4f46e5 !important;
        height: 4px !important; /* Ketebalan garis loading */
    }
    
    /* Mengubah warna efek kilap (glow) di ujung garis */
    #nprogress .peg {
        box-shadow: 0 0 10px #4f46e5, 0 0 5px #4f46e5 !important;
    }

    /* Menyembunyikan spinner lingkaran bawaan (opsional, agar lebih bersih) */
    #nprogress .spinner-icon {
        display: none !important; 
    }
</style>

<!-- NProgress JS via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfigurasi dasar
        NProgress.configure({ showSpinner: false, minimum: 0.1, speed: 400 });

        // 1. Munculkan loading saat pengunjung mengklik tautan (<a>)
        document.addEventListener('click', function (e) {
            let target = e.target.closest('a');
            if (target) {
                let href = target.getAttribute('href');
                // Pastikan itu tautan valid, bukan anchor (#), dan tidak membuka tab baru
                if (href && !href.startsWith('#') && !href.startsWith('javascript') && target.target !== '_blank') {
                    NProgress.start();
                }
            }
        });

        // 2. Munculkan loading saat form dikirim (termasuk filter pencarian)
        document.addEventListener('submit', function () {
            NProgress.start();
        });

        // 3. Selesaikan loading saat halaman baru sudah selesai dirender
        window.addEventListener('load', function () {
            NProgress.done();
        });

        // 4. Pengaman jika pengguna menekan tombol Back/Forward di browser
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                NProgress.done();
            }
        });
    });
</script>