<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight tracking-tight text-slate-900">
            {{ __('Dashboard Pelaku UMKM') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-300 bg-white shadow-sm backdrop-blur-sm">
                <div class="p-6 text-slate-800 sm:p-8">
                    
                    <h3 class="mb-4 text-lg font-semibold tracking-tight text-slate-900">Profil Usaha Anda</h3>
                    
                    @if($umkm)
                        <div class="mb-6 rounded-2xl p-4 
                            @if($umkm->status == 'Disetujui') bg-emerald-50 border border-emerald-200 
                            @elseif($umkm->status == 'Ditolak' || $umkm->status == 'Direvisi') bg-rose-50 border border-rose-200
                            @else bg-amber-50 border border-amber-200 @endif">
                            <p class="font-medium text-slate-800">Status Saat Ini: 
                                <span class="uppercase">{{ $umkm->status }}</span>
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Nama Usaha</label>
                            <input type="text" name="name" value="{{ old('name', $umkm->name ?? '') }}" required
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Kategori</label>
                            <select name="category_id" required class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $umkm->category_id ?? '') == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="contact" value="{{ old('contact', $umkm->contact ?? '') }}" required
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Alamat Lengkap</label>
                            <textarea name="address" rows="3" required
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $umkm->address ?? '') }}</textarea>
                        </div>

                        @php
                            $defaultLatitude = old('latitude', $umkm->latitude ?? '-7.719814');
                            $defaultLongitude = old('longitude', $umkm->longitude ?? '110.515290');
                        @endphp

                        <div class="mb-4 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <div class="mb-3 flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600">Lokasi Usaha di Peta</label>
                                    <p class="mt-1 text-xs text-slate-500">Geser marker atau klik peta untuk menentukan koordinat yang lebih presisi.</p>
                                </div>

                                <button type="button" id="btn-gps" class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-3 text-xs font-medium text-indigo-700 transition-colors hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span id="gps-text">Gunakan Lokasi Saat Ini</span>
                                </button>                                
                            </div>

                            <div
                                class="h-80 overflow-hidden rounded-2xl border border-slate-200 bg-white"
                                data-umkm-location-map
                                data-lat="{{ $defaultLatitude }}"
                                data-lng="{{ $defaultLongitude }}"
                            ></div>

                            <input type="hidden" name="latitude" value="{{ $defaultLatitude }}" data-coordinate-lat>
                            <input type="hidden" name="longitude" value="{{ $defaultLongitude }}" data-coordinate-lng>

                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600">
                                    Latitude: <span class="font-semibold text-slate-900" data-coordinate-lat-display>{{ $defaultLatitude }}</span>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600">
                                    Longitude: <span class="font-semibold text-slate-900" data-coordinate-lng-display>{{ $defaultLongitude }}</span>
                                </div>
                            </div>

                            @if(!empty($umkm?->google_maps_url))
                                <div class="mt-4 flex justify-end">
                                    <a href="{{ $umkm->google_maps_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-700">
                                        <!-- Menambahkan ikon map lipat agar konsisten dengan halaman welcome -->
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                        </svg>
                                        Lihat lokasi saat ini di Google Maps
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Deskripsi Singkat Usaha</label>
                            <textarea name="description" rows="4"
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $umkm->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Foto Tempat Usaha (Bisa lebih dari satu)</label>
                            <input type="file" name="place_images[]" multiple accept="image/*"
                                class="mt-1 block w-full rounded-2xl border border-slate-300 p-2 text-sm text-slate-500 shadow-sm file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-slate-500">Maksimal 10 foto per upload, ukuran tiap foto maksimal 4MB.</p>
                        </div>

                        @if(!empty($umkm) && $umkm->placePhotos->count() > 0)
                            <div class="mb-4">
                                <p class="mb-3 text-sm font-medium text-slate-600">Foto Tempat yang Sudah Tersimpan</p>
                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                    @foreach($umkm->placePhotos as $photo)
                                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto Tempat {{ $loop->iteration }}" class="h-24 w-full rounded-2xl border border-slate-200 object-cover">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-6 flex items-center justify-end">
                            <button type="submit" class="rounded-full bg-indigo-600 px-5 py-2.5 font-medium text-white transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                Simpan Profil
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>    
</x-app-layout>