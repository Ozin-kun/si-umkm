<x-loading />
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Desa') }}
        </h2>
    </x-slot>

    <div class="py-4">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
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
                                <p class="text-green-500 text-sm font-semibold uppercase tracking-wide">Terverifikasi dan Publik</p>
                                <h4 class="text-2xl font-bold text-green-700 mt-1">{{ $approvedUmkm }}</h4>
                            </div>
                            <div class="bg-green-200 text-green-600 p-3 rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Kartu Menunggu Verifikasi -->
                        <div class="bg-yellow-50 border border-yellow-100 p-4 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-yellow-600 text-sm font-semibold uppercase tracking-wide">Menunggu Verifikasi</p>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Tabel Manajemen Verifikasi</h3>                    
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
                                        <td class="py-3 px-6 text-center">
                                            <form action="{{ route('admin.verify', $u->id) }}" method="POST" class="flex justify-center items-center space-x-2">
                                                @csrf
                                                <select name="status" required class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="" disabled selected>Ubah Status</option>
                                                    <option value="Disetujui">Setujui</option>
                                                    <option value="Direvisi">Minta Revisi</option>
                                                    <option value="Ditolak">Tolak</option>
                                                    <option value="Nonaktif">Nonaktifkan</option>
                                                </select>
                                                <input type="text" name="reason" placeholder="Catatan (Opsional)" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm w-32">
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1.5 px-4 rounded">
                                                    Simpan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>    
</x-app-layout>