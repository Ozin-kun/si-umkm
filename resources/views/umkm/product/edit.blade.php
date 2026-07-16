<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight tracking-tight text-slate-900">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-sm">
                <div class="p-6 text-slate-800 sm:p-8">

                    <form action="{{ route('umkm.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Nama Produk / Jasa</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Harga (Rupiah)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600">Deskripsi Produk</label>
                            <textarea name="description" rows="4"
                                class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="mb-2 block text-sm font-medium text-slate-600">Foto Produk Saat Ini</label>
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Foto Produk" class="mb-3 h-32 w-32 rounded-2xl border border-slate-200 object-cover">
                            @endif
                            
                            <label class="mb-1 block text-sm font-medium text-slate-600">Ganti Foto Baru (Opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                class="block w-full rounded-2xl border border-slate-300 p-1 text-sm text-slate-500 shadow-sm file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-slate-500">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('umkm.product.index') }}" class="rounded-full bg-slate-100 px-4 py-2.5 font-medium text-slate-700 transition-colors hover:bg-slate-200">
                                Batal
                            </a>
                            <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2.5 font-medium text-white transition-colors hover:bg-indigo-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>