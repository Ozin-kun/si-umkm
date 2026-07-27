<x-loading />
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Desa') }}
        </h2>
    </x-slot>

    <!-- Tambahkan x-data di pembungkus utama untuk mengelola state Modal -->
    <div class="py-4" x-data="{
        open: false,
        umkm: {},
        photos: [],
        formAction: '',
        openModal(data, action, photos) {
            this.umkm = data;
            this.formAction = action;
            this.photos = photos;
            this.open = true;
        }
    }" x-cloak>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-slate-200/80">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold tracking-tight text-slate-900">Menu Admin Cepat</h3>
                            <p class="mt-1 text-sm text-slate-500">Kelola kategori UMKM dari sini sebelum data dipakai oleh pelaku usaha.</p>
                        </div>
                        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                            Kelola Kategori
                        </a>
                    </div>
                </div>
            </div>

            <!-- KEMBALIKAN KARTU STATISTIK KE ATAS (Lengkap dengan Ikon) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-slate-200/80">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Ringkasan Data UMKM</h3>
                    <p class="mb-6 text-gray-600 text-sm">Pantau perkembangan digitalisasi potensi ekonomi warga melalui ringkasan di bawah ini.</p>

                    <!-- Grid Kartu Statistik -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-2">
                        <!-- Kartu Total -->
                        <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-blue-500 text-sm font-semibold uppercase tracking-wide">Total Terdaftar</p>
                                <h4 class="text-2xl font-bold text-blue-700 mt-1">{{ $totalUmkm }}</h4>
                            </div>
                            <div class="bg-blue-200 text-blue-600 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>

                        <!-- Kartu Disetujui -->
                        <div class="bg-green-50 border border-green-100 p-4 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-green-500 text-sm font-semibold uppercase tracking-wide">Terverifikasi</p>
                                <h4 class="text-2xl font-bold text-green-700 mt-1">{{ $approvedUmkm }}</h4>
                            </div>
                            <div class="bg-green-200 text-green-600 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Kartu Menunggu Verifikasi -->
                        <div class="bg-yellow-50 border border-yellow-100 p-4 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-yellow-600 text-sm font-semibold uppercase tracking-wide">Menunggu</p>
                                <h4 class="text-2xl font-bold text-yellow-700 mt-1">{{ $pendingUmkm }}</h4>
                            </div>
                            <div class="bg-yellow-200 text-yellow-700 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Kartu Bermasalah (Ditolak/Revisi) -->
                        <div class="bg-red-50 border border-red-100 p-4 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-red-500 text-sm font-semibold uppercase tracking-wide">Revisi/Ditolak</p>
                                <h4 class="text-2xl font-bold text-red-700 mt-1">{{ $rejectedUmkm }}</h4>
                            </div>
                            <div class="bg-red-200 text-red-600 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL DATA UMKM -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-slate-200/80">
                <div class="p-6 text-gray-900">                                   
                    <h3 class="text-lg font-bold mb-4">Daftar Pengajuan UMKM</h3>
                    <p class="mb-6 text-gray-600">Lakukan verifikasi data sebelum UMKM dipublikasikan ke halaman pengunjung.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" data-datatable data-page-length="10">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama Usaha & Kategori</th>
                                    <th class="py-3 px-6 text-left">Pemilik & Kontak</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($umkms as $u)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="font-bold text-gray-800">{{ $u->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $u->category->name }}</div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div>{{ $u->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $u->contact }}</div>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <span class="py-1 px-3 rounded-full text-xs font-bold
                                                @if($u->status == 'Disetujui') bg-green-200 text-green-700
                                                @elseif($u->status == 'Menunggu Verifikasi') bg-yellow-200 text-yellow-700
                                                @elseif($u->status == 'Nonaktif') bg-gray-200 text-gray-700
                                                @else bg-red-200 text-red-700 @endif">
                                                {{ $u->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 flex justify-center">
                                            <!-- Tombol untuk memicu Modal -->
                                            <button type="button" @click="openModal(
                                                    @js($u), 
                                                    '{{ route('admin.verify', $u->id) }}', 
                                                    @js($u->placePhotos)
                                                )" 
                                                class="inline-flex items-center justify-center rounded-full bg-indigo-50 px-4 py-2 text-xs font-medium text-indigo-700 transition-colors hover:bg-indigo-100 ring-1 ring-inset ring-indigo-200">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- MODAL DETAIL & VERIFIKASI UMKM -->
        <div x-show="open" 
             x-transition.opacity 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" 
             style="display: none;">
             
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" @click="open = false"></div>

            <!-- Konten Modal -->
            <div class="relative z-10 w-full max-w-4xl max-h-[95vh] flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl">
                
                <!-- Header Modal -->
                <div class="flex flex-shrink-0 items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-lg font-bold tracking-tight text-slate-900">
                            Detail Pengajuan: <span x-text="umkm.name" class="text-indigo-600"></span>
                        </h3>
                    </div>
                    <button type="button" class="rounded-full p-2 text-slate-400 transition-colors hover:bg-slate-200 hover:text-slate-700" @click="open = false">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Body Modal (Bisa di-scroll) -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Kolom Kiri: Info dan Foto -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3 border-b pb-2">Informasi Profil</h4>
                                <div class="space-y-3 text-sm text-slate-700">
                                    <div class="flex flex-col"><span class="text-slate-400 text-xs">Pemilik Usaha</span> <span class="font-medium" x-text="umkm.user?.name"></span></div>
                                    <div class="flex flex-col"><span class="text-slate-400 text-xs">Kategori</span> <span class="font-medium" x-text="umkm.category?.name"></span></div>
                                    <div class="flex flex-col"><span class="text-slate-400 text-xs">Nomor Kontak</span> <span class="font-medium" x-text="umkm.contact"></span></div>
                                    <div class="flex flex-col"><span class="text-slate-400 text-xs">Alamat Lengkap</span> <span x-text="umkm.address"></span></div>
                                    <div class="flex flex-col mt-2 rounded-xl bg-slate-50 p-3 border border-slate-100">
                                        <span class="text-slate-500 text-xs font-semibold mb-1">Deskripsi Usaha:</span>
                                        <span class="leading-relaxed" x-text="umkm.description || 'Tidak ada deskripsi.'"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3 border-b pb-2">Foto Tempat Usaha</h4>
                                <div x-show="photos.length > 0" class="grid grid-cols-2 gap-3">
                                    <template x-for="photo in photos" :key="photo.id">
                                        <a :href="'/storage/' + photo.image_path" target="_blank" class="block group overflow-hidden rounded-xl border border-slate-200">
                                            <img :src="'/storage/' + photo.image_path" class="h-28 w-full object-cover transition-transform group-hover:scale-105" alt="Foto">
                                        </a>
                                    </template>
                                </div>
                                <div x-show="photos.length === 0" class="rounded-xl border border-dashed border-slate-300 p-4 text-center text-sm text-slate-500 bg-slate-50">
                                    Tidak ada foto yang dilampirkan.
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Peta & Form Verifikasi -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3 border-b pb-2">Lokasi di Peta</h4>
                                <div class="h-56 w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 shadow-sm relative">
                                    <template x-if="umkm.latitude && umkm.longitude">
                                        <!-- Google Maps Embed dinamis berdasarkan koordinat -->
                                        <iframe width="100%" height="100%" frameborder="0" style="border:0" 
                                            :src="'https://maps.google.com/maps?q=' + umkm.latitude + ',' + umkm.longitude + '&z=15&output=embed'" 
                                            allowfullscreen>
                                        </iframe>
                                    </template>
                                    <div x-show="!umkm.latitude || !umkm.longitude" class="absolute inset-0 flex items-center justify-center text-sm text-slate-500">
                                        Koordinat lokasi belum diatur.
                                    </div>
                                </div>
                            </div>

                            <!-- Form Eksekusi Admin -->
                            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5 shadow-sm">
                                <h4 class="text-sm font-bold uppercase tracking-wider text-indigo-700 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Tindakan Verifikasi
                                </h4>
                                
                                <form :action="formAction" method="POST" class="space-y-4">
                                    @csrf
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Perbarui Status</label>
                                        <select name="status" x-model="umkm.status" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                                            <option value="Disetujui">Setujui & Publikasikan</option>
                                            <option value="Direvisi">Minta Revisi Data</option>
                                            <option value="Ditolak">Tolak Sepenuhnya</option>
                                            <option value="Nonaktif">Nonaktifkan Sementara</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Catatan / Alasan (Opsional)</label>
                                        <textarea name="reason" rows="3" placeholder="Contoh: Tolong perbaiki foto tempat atau alamat kurang lengkap..." class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                        <p class="mt-1 text-xs text-slate-500">Catatan ini sangat penting jika Anda memilih status Revisi/Ditolak.</p>
                                    </div>
                                    
                                    <div class="pt-2">
                                        <button type="submit" class="w-full flex justify-center items-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-md transition-colors hover:bg-indigo-700">
                                            Simpan Status Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>