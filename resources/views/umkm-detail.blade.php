<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $umkm->name }} - Portal UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<x-loading />
<body class="bg-gradient-to-b from-slate-50 via-white to-indigo-50 text-slate-800 antialiased font-sans">

    <nav class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center font-medium text-slate-600 transition-colors hover:text-emerald-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        
        <div class="mb-10 overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm sm:p-10">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-start">
                <div>
                    <span class="mb-3 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                        {{ $umkm->category->name }}
                    </span>
                    <h1 class="mb-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $umkm->name }}</h1>
                    <p class="text-base text-slate-600 sm:text-lg">{{ $umkm->description ?? 'Belum ada deskripsi usaha.' }}</p>

                    <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-2 flex items-start text-sm text-slate-600">
                            <svg class="mr-3 mt-0.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $umkm->address }}</span>
                        </div>

                        @if($umkm->google_maps_url)
                            <a href="{{ $umkm->google_maps_url }}" target="_blank" class="inline-flex items-center text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-700">
                                Buka Lokasi di Google Maps
                            </a>
                        @else
                            <p class="text-xs text-slate-500">Koordinat lokasi belum ditambahkan oleh pelaku UMKM.</p>
                        @endif
                    </div>
                    
                    @php
                        $waNumber = preg_replace('/^0/', '62', $umkm->contact);
                        $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waNumber) . "?text=Halo%20" . urlencode($umkm->name) . ",%20saya%20melihat%20produk%20Anda%20di%20Portal%20UMKM%20Desa.";
                    @endphp
                    
                    <a href="{{ $waLink }}" target="_blank" class="mt-4 inline-flex items-center justify-center rounded-full bg-green-500 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Hubungi Penjual
                    </a>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-100">
                    @if($umkm->placePhotos->count() > 0)
                        <div class="relative h-72 w-full sm:h-96" data-auto-carousel data-interval="3400">
                            <div class="flex h-full transition-transform duration-700 ease-out" data-carousel-track>
                                @foreach($umkm->placePhotos as $photo)
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto tempat {{ $umkm->name }} {{ $loop->iteration }}" class="h-full w-full shrink-0 object-cover">
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="flex h-72 w-full items-center justify-center text-sm text-slate-400 sm:h-96">Belum ada foto tempat usaha</div>
                    @endif
                </div>
            </div>
        </div>

        <div x-data="{
            openProductModal: false,
            selectedProduct: {
                name: '',
                price: '',
                description: '',
                imageUrl: '',
                imageAlt: '',
            },
            openModal(product) {
                this.selectedProduct = product;
                this.openProductModal = true;
                this.$nextTick(() => this.$refs.closeProductModalButton && this.$refs.closeProductModalButton.focus());
            },
            closeModal() {
                this.openProductModal = false;
            }
        }">
            <div class="mb-6 flex flex-col gap-4 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Katalog Produk</h2>
                    <p class="mt-1 text-sm text-slate-500">Cari produk yang ditawarkan oleh UMKM</p>
                </div>

                <form action="{{ route('public.umkm.show', $umkm->id) }}" method="GET" class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                    <div class="relative sm:w-80">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? request('search') }}"
                            placeholder="Cari produk..."
                            class="w-full rounded-full border-slate-300 bg-white px-4 py-2.5 pr-12 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                        @if(!empty($search ?? request('search')))
                            <a href="{{ route('public.umkm.show', $umkm->id) }}" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 transition-colors hover:text-emerald-600" aria-label="Reset pencarian produk">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @else
                            <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 transition-colors hover:text-emerald-600" aria-label="Cari produk">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    @if(!empty($search ?? request('search')))
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                            Cari
                        </button>
                    @endif
                </form>
            </div>

            @if($umkm->products->count() > 0)
                @if(!empty($search ?? request('search')))
                    <div class="mb-5 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        Menampilkan hasil pencarian untuk "<span class="font-semibold">{{ $search ?? request('search') }}</span>".
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($umkm->products as $p)
                        <button
                            type="button"
                            class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 text-left shadow-sm transition-shadow hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 hover:border-emerald-300"
                            @click="openModal({
                                name: @js($p->name),
                                price: @js('Rp ' . number_format($p->price, 0, ',', '.')),
                                description: @js($p->description ?? 'Belum ada deskripsi produk.'),
                                imageUrl: @js($p->image_path ? asset('storage/' . $p->image_path) : ''),
                                imageAlt: @js($p->name),
                            })"
                        >
                            
                            <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                                @if($p->image_path)
                                    <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm text-slate-400">Tanpa Foto</div>
                                @endif
                            </div>
                            
                            <div class="flex flex-1 flex-col justify-between p-5">
                                <div>
                                    <h3 class="mb-1 text-lg font-semibold leading-tight text-slate-900">{{ $p->name }}</h3>
                                    <p class="mb-3 line-clamp-2 text-sm text-slate-500">{{ $p->description }}</p>
                                </div>
                                <div class="text-xl font-bold text-emerald-600">
                                    Rp {{ number_format($p->price, 0, ',', '.') }}
                                </div>
                            </div>

                        </button>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 bg-white/80 py-12 text-center shadow-sm">
                    <p class="text-slate-500">
                        @if(!empty($search ?? request('search')))
                            Tidak ada produk yang cocok dengan kata kunci tersebut.
                        @else
                            UMKM ini belum mengunggah produk ke dalam katalog.
                        @endif
                    </p>
                </div>
            @endif

            <div
                x-show="openProductModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                style="display: none;"
                role="dialog"
                aria-modal="true"
                aria-labelledby="product-modal-title"
            >
                <!-- Backdrop dengan efek transisi -->
                <div 
                    x-show="openProductModal"
                    x-transition.opacity.duration.300ms
                    class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" 
                    @click="closeModal()"
                ></div>

                <!-- Konten Modal -->
                <div 
                    x-show="openProductModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative z-10 w-full max-w-4xl flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl"
                    @click.stop
                >
                    <!-- Bagian Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 px-6 py-4 sm:px-8">
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Detail Produk</p>
                        <button
                            type="button"
                            x-ref="closeProductModalButton"
                            class="rounded-full p-2 text-slate-400 transition-colors hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                            @click="closeModal()"
                        >
                            <span class="sr-only">Tutup modal</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Bagian Body (Grid) -->
                    <div class="grid grid-cols-1 lg:grid-cols-5">
                        
                        <!-- Sisi Kiri: Gambar Produk (Mengambil porsi 2 kolom di layar besar) -->
                        <div class="bg-slate-100 lg:col-span-2 relative">
                            <template x-if="selectedProduct.imageUrl">
                                <img :src="selectedProduct.imageUrl" :alt="selectedProduct.imageAlt" class="h-64 w-full object-cover sm:h-80 lg:absolute lg:inset-0 lg:h-full">
                            </template>
                            <template x-if="!selectedProduct.imageUrl">
                                <div class="flex h-64 w-full flex-col items-center justify-center text-slate-400 sm:h-80 lg:absolute lg:inset-0 lg:h-full">
                                    <svg class="mb-2 h-10 w-10 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-medium">Tidak ada foto produk</span>
                                </div>
                            </template>
                        </div>

                        <!-- Sisi Kanan: Konten Teks (Mengambil porsi 3 kolom di layar besar) -->
                        <div class="flex flex-col p-6 sm:p-8 lg:col-span-3">
                            <div class="flex-1">                                                                
                                {{-- <div class="mb-3 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200" x-text="selectedProduct.price"></div>                                 --}}
                                <h3 id="product-modal-title" class="text-2xl font-bold tracking-tight text-slate-900" x-text="selectedProduct.name"></h3>                                
                                <div class="mt-4 text-sm leading-relaxed text-slate-600">
                                    <p x-text="selectedProduct.description || 'Tidak ada deskripsi detail untuk produk ini.'"></p>
                                </div>

                                <!-- Kotak Informasi -->
                                <div class="mt-8 rounded-2xl border border-emerald-100 bg-emerald-50/30 p-5">
                                    <p class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Ringkasan Informasi</p>
                                    <dl class="space-y-3 text-sm text-slate-700">
                                        <div class="flex items-center justify-between border-b border-emerald-100/50 pb-3">
                                            <dt class="text-slate-500">Nama Produk</dt>
                                            <dd class="font-semibold text-slate-900 text-right" x-text="selectedProduct.name"></dd>
                                        </div>
                                        <div class="flex items-center justify-between pt-1">
                                            <dt class="text-slate-500">Harga Jual</dt>
                                            <dd class="font-bold text-emerald-600 text-right" x-text="selectedProduct.price"></dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- Footer / Tombol Aksi -->
                            <div class="mt-8 flex items-center justify-end border-t border-slate-100 pt-5">
                                <button type="button" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" @click="closeModal()">
                                    Tutup Detail
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>