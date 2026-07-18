<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight tracking-tight text-slate-900">
                {{ __('Katalog Produk UMKM') }}
            </h2>
            <a href="{{ route('umkm.product.create') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-4" x-data="productCatalogPage()" x-cloak>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-sm">
                <div class="p-6 text-slate-800 sm:p-8">
                    <h3 class="mb-4 text-lg font-semibold tracking-tight text-slate-900">Daftar Produk Anda</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left" data-datatable data-page-length="10">
                            <thead>
                                <tr class="bg-slate-100 text-sm uppercase leading-normal text-slate-700">
                                    <th class="w-32 px-6 py-3 text-left">Foto</th>
                                    <th class="px-6 py-3 text-left">Nama Produk</th>
                                    <th class="px-6 py-3 text-left">Harga</th>
                                    <th class="px-6 py-3 text-left">Deskripsi</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-light text-slate-600">
                                @foreach($products as $p)
                                    <tr class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="px-6 py-4">
                                            @if($p->image_path)
                                                <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}" class="h-20 w-20 rounded-2xl border border-slate-200 object-cover">
                                            @else
                                                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100 text-xs text-slate-400">Tidak ada foto</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $p->name }}</td>
                                        <td class="px-6 py-4 font-semibold text-slate-900">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                        <td class="max-w-xs px-6 py-4 truncate">{{ $p->description ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition-colors hover:bg-amber-100"
                                                    @click="openModal({
                                                        action: '{{ route('umkm.product.update', $p->id) }}',
                                                        product: @js([
                                                            'id' => $p->id,
                                                            'name' => $p->name,
                                                            'price' => $p->price,
                                                            'description' => $p->description,
                                                        ])
                                                    })"
                                                >
                                                    Edit
                                                </button>

                                                <form action="{{ route('umkm.product.destroy', $p->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1.5 text-xs font-medium text-rose-700 transition-colors hover:bg-rose-100" @click="confirmDeleteProduct($el.closest('form'), @js($p->name))">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6"
            style="display: none;"
            aria-labelledby="edit-product-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="absolute inset-0 bg-slate-950/50" @click="closeModal()"></div>

            <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-slate-100 px-6 py-4 sm:px-8">
                    <div>
                        <h3 id="edit-product-title" class="text-lg font-semibold tracking-tight text-slate-900">Edit Produk</h3>
                        <p class="mt-1 text-sm text-slate-500">Perubahan akan disimpan tanpa pindah halaman.</p>
                    </div>
                    <button type="button" class="rounded-full p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700" @click="closeModal()">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" enctype="multipart/form-data" class="px-6 py-6 sm:px-8">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-600">Nama Produk / Jasa</label>
                            <input x-ref="nameInput" type="text" name="name" x-model="form.name" required class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600">Harga (Rupiah)</label>
                            <input type="number" name="price" min="0" x-model="form.price" required class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600">Foto Baru (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="mt-1 block w-full rounded-2xl border border-slate-300 p-2 text-sm text-slate-500 shadow-sm file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-600">Deskripsi Produk</label>
                            <textarea name="description" rows="4" x-model="form.description" class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button type="button" class="rounded-full bg-slate-100 px-4 py-2.5 font-medium text-slate-700 transition-colors hover:bg-slate-200" @click="closeModal()">Batal</button>
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2.5 font-medium text-white transition-colors hover:bg-indigo-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
