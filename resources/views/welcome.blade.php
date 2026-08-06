<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal UMKM Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [data-reveal] {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 700ms ease, transform 700ms ease, box-shadow 250ms ease;
            will-change: opacity, transform;
        }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<x-loading />
    <body class="bg-gradient-to-b from-stone-50 via-white to-emerald-50 text-slate-800 antialiased font-sans">

    <nav class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-3 font-semibold tracking-wide text-emerald-700">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-700 text-sm font-bold text-white shadow-sm">S</span>
                    <span>SI-UMKM</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-3 text-sm font-medium">
                        @auth
                            <a href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('umkm.dashboard') }}" class="text-slate-600 transition-colors hover:text-emerald-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 transition-colors hover:text-emerald-700">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-emerald-700 px-4 py-2 text-white shadow-sm transition-all hover:bg-emerald-800 hover:shadow-md">Daftar UMKM</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="relative flex min-h-[calc(100vh-4rem)] items-center overflow-hidden bg-slate-900" 
         x-data="{ 
            activeSlide: 0, 
            slides: [
                // Gambar 1: Terasering / Persawahan Desa (Alam)
                'https://images.unsplash.com/photo-1559628233-eb1b1a45564b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                // Gambar 2: Pasar Tradisional / Kerajinan Anyaman
                'https://images.unsplash.com/photo-1605810230434-7631ac76ec81?auto=format&fit=crop&w=1920&q=80',
                // Gambar 3: Kuliner Tradisional / Rempah
                'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 5000);
            }
         }">
         
        <!-- Wadah Gambar Carousel (Menggunakan Z-0 agar tidak tenggelam) -->
        <div class="absolute inset-0 z-0 h-full w-full">
            <template x-for="(slide, index) in slides" :key="index">
                <img :src="slide" 
                     alt="Potensi Lokal Desa" 
                     x-show="activeSlide === index"
                     x-transition:enter="transition ease-in-out duration-1000"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in-out duration-1000"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-105"
                     class="absolute inset-0 h-full w-full object-cover object-center">
            </template>
        </div>
        
        <!-- Overlay Gradasi Gelap (Z-10: Berada di atas gambar, di bawah teks) -->
        <div class="absolute inset-0 z-10 bg-gradient-to-r from-slate-950/90 via-slate-900/70 to-slate-900/30"></div>

        <!-- Konten Teks (Z-20: Paling depan) -->
        <div class="relative z-20 w-full mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <!-- Badge -->
                <div class="mb-6 inline-flex items-center rounded-full border border-emerald-400/30 bg-emerald-500/20 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-emerald-100 shadow-sm backdrop-blur-md ring-1 ring-emerald-500/50">
                    Portal UMKM Desa Joho
                </div>
                
                <!-- Judul Utama -->
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl drop-shadow-lg">
                    Etalase Keunggulan Potensi Lokal.
                </h1>
                
                <!-- Deskripsi -->
                <p class="mt-6 max-w-xl text-base font-medium leading-relaxed text-slate-200 sm:text-lg drop-shadow-md">
                    Mari dukung kemandirian ekonomi desa dengan menjelajahi ragam produk unggulan, kerajinan inovatif, serta kuliner autentik karya pelaku UMKM Desa Joho, Kecamatan Prambanan, Kabupaten Klaten.
                </p>
                
                <!-- Tombol Aksi (Dengan animasi panah bergerak) -->
                <div class="mt-10 flex items-center gap-4">
                    <button type="button" onclick="document.querySelector('form').scrollIntoView({ behavior: 'smooth' })" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-8 py-3.5 text-base font-bold text-white shadow-lg transition-all hover:bg-emerald-500 hover:shadow-emerald-500/30 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                        Jelajahi Direktori
                        <svg class="ml-2 h-5 w-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col gap-4 border-y border-slate-200/80 py-6 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Direktori UMKM Terverifikasi</h2>
                <p class="mt-1 text-sm text-slate-500">Platform resmi yang memudahkan masyarakat dan pengunjung untuk mengakses informasi produk serta layanan terpercaya di Desa Joho.</p>
            </div>
            <form action="{{ route('home') }}" method="GET" class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">
                {{-- <select name="kategori" onchange="this.form.submit()" class="rounded-full border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select> --}}
                <div x-data="{
                        open: false,
                        value: '{{ request('kategori') }}',
                        label: 'Semua Kategori',
                        options: [
                            { id: '', name: 'Semua Kategori' },
                            @foreach($categories as $cat)
                            { id: '{{ $cat->id }}', name: '{{ $cat->name }}' },
                            @endforeach
                        ],
                        init() {
                            // Mencocokkan label saat halaman dimuat (jika ada kategori yang sedang aktif)
                            const selected = this.options.find(opt => opt.id == this.value);
                            if (selected) this.label = selected.name;
                        },
                        selectOption(id, name) {
                            this.value = id;
                            this.label = name;
                            this.open = false;
                            // Submit form otomatis setelah memilih opsi
                            this.$nextTick(() => {this.$el.closest('form').requestSubmit();});
                        }
                    }"
                    class="relative w-full sm:w-56"
                    @click.outside="open = false"
                >                    
                    <input type="hidden" name="kategori" :value="value">

                    <!-- Tombol Trigger Dropdown -->
                    <button type="button" @click="open = !open"
                        class="flex w-full items-center justify-between rounded-full border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm transition-colors hover:border-emerald-300 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        <span x-text="label" class="truncate"></span>
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Kotak Menu Dropdown -->
                    <div x-show="open"
                         x-transition.opacity
                         x-transition:enter.duration.200ms
                         x-transition:leave.duration.150ms
                         style="display: none;"
                         class="absolute z-50 mt-2 max-h-60 w-full overflow-auto rounded-2xl border border-slate-200 bg-white py-1 shadow-lg">
                        <template x-for="option in options" :key="option.id">
                            <!-- Baris Opsi -->
                            <div @click="selectOption(option.id, option.name)"
                                 class="cursor-pointer px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50 hover:text-emerald-700"
                                 :class="value == option.id ? 'bg-emerald-50 font-medium text-emerald-700' : 'text-slate-700'"
                            >
                                <span x-text="option.name"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="relative flex-1 sm:w-72">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama usaha..."
                        class="w-full rounded-full border-slate-300 bg-white px-4 py-2.5 pr-12 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 transition-colors hover:text-emerald-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

                @if(request('cari') || request('kategori'))
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:border-slate-300 hover:bg-slate-100">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        @if($umkms->count() > 0)
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3" data-umkm-grid>
                @include('partials.public-umkm-cards', ['umkms' => $umkms->items()])
            </div>

            @if($umkms->hasMorePages())
                <div class="mt-8 flex justify-center">
                    <div
                        data-umkm-lazy-loader
                        data-next-url="{{ $umkms->nextPageUrl() }}"
                        data-loading-text="Memuat usaha lainnya..."
                        class="flex w-full max-w-xl items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white/90 px-4 py-4 text-sm text-slate-500 shadow-sm"
                    >
                        <svg data-umkm-lazy-spinner class="h-5 w-5 animate-spin text-emerald-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M12 2a10 10 0 0 1 10 10h-4a6 6 0 1 0-6 6v4A10 10 0 0 1 12 2z"></path>
                        </svg>
                        <span data-umkm-lazy-message>Gulir ke bawah untuk memuat UMKM berikutnya.</span>
                        <span data-umkm-lazy-loading class="hidden rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">Sedang memuat...</span>
                    </div>
                </div>
            @endif
        @else
            <div class="rounded-2xl border border-dashed border-slate-200 bg-white/80 py-16 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-3 text-sm font-medium text-slate-900">Tidak ada hasil ditemukan</h3>
                <p class="mt-2 text-sm text-slate-500">
                    @if(request('cari') || request('kategori'))
                        Coba gunakan kata kunci atau kategori lain.
                    @else
                        Saat ini belum ada data UMKM yang diverifikasi oleh Perangkat Desa.
                    @endif
                </p>
                @if(request('cari') || request('kategori'))
                    <div class="mt-5">
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 transition-colors hover:bg-emerald-100">
                            Lihat Semua UMKM
                        </a>
                    </div>
                @endif
            </div>
        @endif

    </div>
<x-footer />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var targets = document.querySelectorAll('[data-reveal]');

            if (!('IntersectionObserver' in window)) {
                targets.forEach(function (element) {
                    element.classList.add('is-visible');
                });
                return;
            }

            var observer = new IntersectionObserver(function (entries, observerInstance) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observerInstance.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -8% 0px'
            });

            targets.forEach(function (element) {
                observer.observe(element);
            });

            const lazyLoader = document.querySelector('[data-umkm-lazy-loader]');
            const grid = document.querySelector('[data-umkm-grid]');

            if (!lazyLoader || !grid || !('IntersectionObserver' in window)) {
                return;
            }

            let loading = false;
            let nextUrl = lazyLoader.dataset.nextUrl;
            const lazyMessage = lazyLoader.querySelector('[data-umkm-lazy-message]');
            const lazyLoadingBadge = lazyLoader.querySelector('[data-umkm-lazy-loading]');
            const lazySpinner = lazyLoader.querySelector('[data-umkm-lazy-spinner]');

            const appendLazyCards = function (html) {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = html;
                const cards = wrapper.children;

                Array.from(cards).forEach(function (card) {
                    grid.appendChild(card);
                    if (elementObserver) {
                        elementObserver.observe(card);
                    }
                });
            };

            const loadNextPage = async function () {
                if (loading || !nextUrl) {
                    return;
                }

                loading = true;
                if (lazyMessage) {
                    lazyMessage.textContent = lazyLoader.dataset.loadingText;
                }
                if (lazyLoadingBadge) {
                    lazyLoadingBadge.classList.remove('hidden');
                }
                if (lazySpinner) {
                    lazySpinner.classList.add('animate-spin');
                    lazySpinner.classList.remove('hidden');
                }

                try {
                    const url = new URL(nextUrl, window.location.origin);
                    url.searchParams.set('lazy', '1');

                    const response = await fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load more UMKM');
                    }

                    const payload = await response.json();
                    if (payload.html) {
                        appendLazyCards(payload.html);
                    }

                    nextUrl = payload.next_page_url;
                    if (!nextUrl) {
                        lazyLoader.remove();
                        lazyObserver.disconnect();
                        return;
                    }

                    if (lazyMessage) {
                        lazyMessage.textContent = 'Gulir ke bawah untuk memuat UMKM berikutnya.';
                    }
                    if (lazyLoadingBadge) {
                        lazyLoadingBadge.classList.add('hidden');
                    }
                } catch (error) {
                    console.error(error);
                    if (lazyMessage) {
                        lazyMessage.textContent = 'Gagal memuat data tambahan. Coba gulir lagi atau muat ulang halaman.';
                    }
                    if (lazyLoadingBadge) {
                        lazyLoadingBadge.classList.add('hidden');
                    }
                } finally {
                    loading = false;
                }
            };

            const lazyObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        loadNextPage();
                    }
                });
            }, {
                rootMargin: '250px 0px',
                threshold: 0.1,
            });

            lazyObserver.observe(lazyLoader);

            const elementObserver = new IntersectionObserver(function (entries, observerInstance) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observerInstance.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -8% 0px'
            });
        });
    </script>

</body>
</html>