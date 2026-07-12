<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Form menggunakan method POST tapi kita tipu menjadi PUT dengan @method('PUT') -->
                    <form action="{{ route('umkm.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Produk / Jasa</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Harga (Rupiah)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                            <textarea name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk Saat Ini</label>
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Foto Produk" class="w-32 h-32 object-cover rounded-md border mb-3">
                            @endif
                            
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Baru (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                class="block w-full text-sm text-gray-500 border border-gray-300 rounded-md p-1 shadow-sm">
                            <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-3 mt-4">
                            <a href="{{ route('umkm.product.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>