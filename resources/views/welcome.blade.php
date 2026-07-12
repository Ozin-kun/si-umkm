<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal UMKM Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center font-bold text-xl text-indigo-600">
                    SI-UMKM
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                <a href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('umkm.dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-600 font-semibold">Kembali ke Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600 font-semibold">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-semibold transition-colors">Daftar UMKM</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-indigo-700 text-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4">
                Eksplorasi Potensi Lokal
            </h1>
            <p class="text-lg sm:text-xl text-indigo-100 max-w-2xl mx-auto mb-8">
                Temukan berbagai produk unggulan, kerajinan tangan, hingga kuliner autentik langsung dari para pelaku usaha mikro di desa kami.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Katalog Usaha Terverifikasi</h2>
                <p class="text-gray-500 mt-1">Mendukung pertumbuhan ekonomi warga.</p>
            </div>
        </div>

        @if($umkms->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($umkms as $u)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
                        <div class="p-6 flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full font-semibold">
                                    {{ $u->category->name }}
                                </span>
                            </div>
                            <a href="{{ route('public.umkm.show', $u->id) }}">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-indigo-600 transition-colors">{{ $u->name }}</h3>
                            </a>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $u->description ?? 'Pelaku usaha ini belum menambahkan deskripsi detail mengenai bisnis mereka.' }}
                            </p>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                            <div class="flex items-center text-sm text-gray-500 mb-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $u->address }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $u->contact }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg border border-gray-200 border-dashed">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada UMKM</h3>
                <p class="mt-1 text-sm text-gray-500">Saat ini belum ada data UMKM yang diverifikasi oleh Perangkat Desa.</p>
            </div>
        @endif
    </div>

</body>
</html>