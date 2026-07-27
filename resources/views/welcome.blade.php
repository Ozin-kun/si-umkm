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
<body class="bg-gradient-to-b from-slate-50 via-white to-indigo-50 text-slate-800 antialiased font-sans">

    <nav class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-3 font-semibold tracking-wide text-indigo-600">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-sm font-bold text-white shadow-sm">S</span>
                    <span>SI-UMKM</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-3 text-sm font-medium">
                        @auth
                            <a href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('umkm.dashboard') }}" class="text-slate-600 transition-colors hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 transition-colors hover:text-indigo-600">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-white shadow-sm transition-all hover:bg-indigo-700 hover:shadow-md">Daftar UMKM</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-[radial-gradient(circle_at_top,rgba(79,70,229,0.14),transparent_65%)]"></div>
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
            <div class="max-w-3xl">
                <div class="mb-4 inline-flex items-center rounded-full border border-indigo-100 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 shadow-sm">
                    Portal UMKM Desa
                </div>
                <h1 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-6xl">
                    Eksplorasi potensi lokal.
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                    Temukan produk unggulan, kerajinan tangan, dan kuliner autentik dari pelaku usaha mikro desa Joho Prambanan Klaten.
                </p>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col gap-4 border-y border-slate-200/80 py-6 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Katalog usaha terverifikasi</h2>
                <p class="mt-1 text-sm text-slate-500">Disusun untuk membantu warga dan pengunjung menemukan usaha di desa Joho secara cepat.</p>
            </div>
            <form action="{{ route('home') }}" method="GET" class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">
                {{-- <select name="kategori" onchange="this.form.submit()" class="rounded-full border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        class="flex w-full items-center justify-between rounded-full border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm transition-colors hover:border-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
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
                                 class="cursor-pointer px-4 py-2.5 text-sm transition-colors hover:bg-indigo-50 hover:text-indigo-700"
                                 :class="value == option.id ? 'bg-indigo-50 font-medium text-indigo-700' : 'text-slate-700'"
                            >
                                <span x-text="option.name"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="relative flex-1 sm:w-72">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama usaha..."
                        class="w-full rounded-full border-slate-300 bg-white px-4 py-2.5 pr-12 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 transition-colors hover:text-indigo-600">
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
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($umkms as $u)
                    <div data-reveal style="transition-delay: {{ $loop->index * 80 }}ms" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-md hover:-translate-y-1 hover:shadow-xl backdrop-blur-sm hover:border-indigo-300 ">
                        <div class="flex-1 p-6">
                            <div class="mb-4 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                                @if($u->placePhotos->count() > 0)
                                    <div class="relative h-44 w-full" data-auto-carousel data-interval="3200">
                                        <div class="flex h-full transition-transform duration-700 ease-out" data-carousel-track>
                                            @foreach($u->placePhotos as $photo)
                                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto tempat {{ $u->name }} {{ $loop->iteration }}" class="h-full w-full shrink-0 object-cover">
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="flex h-44 w-full items-center justify-center text-sm text-slate-400">Belum ada foto tempat usaha</div>
                                @endif
                            </div>

                            <div class="mb-4 flex items-start justify-between">
                                <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-100">
                                    {{ $u->category->name }}
                                </span>
                            </div>
                            <a href="{{ route('public.umkm.show', $u->id) }}" class="block">
                                <h3 class="text-xl font-semibold tracking-tight text-slate-900 transition-colors group-hover:text-indigo-600">{{ $u->name }}</h3>
                            </a>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">
                                {{ $u->description ?? 'Pelaku usaha ini belum menambahkan deskripsi detail mengenai bisnis mereka.' }}
                            </p>
                        </div>
                        <div class="border-t border-slate-100 bg-slate-50/80 px-6 py-4">
                            <div class="mb-2 flex items-center text-sm text-slate-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $u->address }}
                            </div>
                            <div class="flex items-center text-sm text-slate-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $u->contact }}
                            </div>
                            @if($u->google_maps_url)
                                <a href="{{ $u->google_maps_url }}" target="_blank" class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-indigo-600 transition-colors hover:text-indigo-800">                                    
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                    Buka Lokasi di Google Maps
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
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
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 transition-colors hover:bg-indigo-100">
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
        });
    </script>

</body>
</html>