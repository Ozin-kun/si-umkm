<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Katalog Produk UMKM') }}
            </h2>
            <a href="{{ route('umkm.product.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm shadow-sm transition-colors">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">Daftar Produk Anda</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left w-32">Foto</th>
                                    <th class="py-3 px-6 text-left">Nama Produk</th>
                                    <th class="py-3 px-6 text-left">Harga</th>
                                    <th class="py-3 px-6 text-left">Deskripsi</th>
                                    <th class="py-3 px-6 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($products as $p)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            @if($p->image_path)
                                                <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}" class="w-20 h-20 object-cover rounded-md border">
                                            @else
                                                <div class="w-20 h-20 bg-gray-200 rounded-md flex items-center justify-center text-xs text-gray-400">Tidak ada foto</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 font-bold text-gray-800">
                                            {{ $p->name }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-900 font-semibold">
                                            Rp {{ number_format($p->price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-6 max-w-xs truncate">
                                            {{ $p->description ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center flex justify-center space-x-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('umkm.product.edit', $p->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1.5 px-3 rounded">
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus dengan Konfirmasi JS -->
                                            <form action="{{ route('umkm.product.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1.5 px-3 rounded">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-6 text-center text-gray-500">Belum ada produk yang ditambahkan ke etalase.</td>
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