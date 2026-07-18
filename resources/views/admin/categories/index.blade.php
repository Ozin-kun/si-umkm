<x-loading />
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight tracking-tight text-slate-900">
                    {{ __('Manajemen Kategori') }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">Kelola kategori UMKM dan pastikan kategori yang masih dipakai tidak dihapus.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="adminCategoryPage()" x-cloak>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-sm">
                <div class="p-6 text-slate-800 sm:p-8">
                    <div class="mb-5 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Kategori hanya bisa dihapus jika tidak ada UMKM yang masih menggunakannya.
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left" data-datatable data-page-length="10">
                            <thead>
                                <tr class="bg-slate-100 text-sm uppercase leading-normal text-slate-700">
                                    <th class="px-6 py-3 text-left">Nama Kategori</th>
                                    <th class="px-6 py-3 text-left">Deskripsi</th>
                                    <th class="px-6 py-3 text-center">Jumlah UMKM</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-light text-slate-600">
                                @foreach($categories as $category)
                                    <tr class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $category->name }}</td>
                                        <td class="max-w-lg px-6 py-4 truncate">{{ $category->description ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center font-semibold text-slate-900">{{ $category->umkms_count }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition-colors hover:bg-amber-100"
                                                    @click="openEditModal({
                                                        action: '{{ route('admin.categories.update', $category) }}',
                                                        category: @js([
                                                            'id' => $category->id,
                                                            'name' => $category->name,
                                                            'description' => $category->description,
                                                        ])
                                                    })"
                                                >
                                                    Edit
                                                </button>

                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1.5 text-xs font-medium text-rose-700 transition-colors hover:bg-rose-100" @click="confirmDeleteCategory($el.closest('form'), @js($category->name))">
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
            aria-labelledby="edit-category-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="absolute inset-0 bg-slate-950/50" @click="closeEditModal()"></div>

            <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-slate-100 px-6 py-4 sm:px-8">
                    <div>
                        <h3 id="edit-category-title" class="text-lg font-semibold tracking-tight text-slate-900">Edit Kategori</h3>
                        <p class="mt-1 text-sm text-slate-500">Perubahan kategori disimpan tanpa membuka halaman baru.</p>
                    </div>
                    <button type="button" class="rounded-full p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700" @click="closeEditModal()">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="px-6 py-6 sm:px-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Nama Kategori</label>
                            <input x-ref="nameInput" type="text" name="name" x-model="form.name" required maxlength="100" class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600">Deskripsi</label>
                            <textarea name="description" rows="4" x-model="form.description" class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button type="button" class="rounded-full bg-slate-100 px-4 py-2.5 font-medium text-slate-700 transition-colors hover:bg-slate-200" @click="closeEditModal()">Batal</button>
                        <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2.5 font-medium text-white transition-colors hover:bg-indigo-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
