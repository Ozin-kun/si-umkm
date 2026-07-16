<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight tracking-tight text-slate-900">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-sm">
                <div class="p-6 text-slate-800 sm:p-8">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-slate-600">Nama Kategori</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" required maxlength="100" class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600">Deskripsi</label>
                            <textarea name="description" rows="4" class="mt-1 block w-full rounded-2xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('admin.categories.index') }}" class="rounded-full bg-slate-100 px-4 py-2.5 font-medium text-slate-700 transition-colors hover:bg-slate-200">Batal</a>
                            <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2.5 font-medium text-white transition-colors hover:bg-indigo-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
