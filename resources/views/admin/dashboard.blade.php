<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Desa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">Daftar Pengajuan UMKM</h3>
                    <p class="mb-6 text-gray-600">Lakukan verifikasi data sebelum UMKM dipublikasikan ke halaman pengunjung.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama Usaha & Kategori</th>
                                    <th class="py-3 px-6 text-left">Pemilik & Kontak</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($umkms as $u)
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
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-6 text-center text-gray-500">Belum ada data UMKM yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>