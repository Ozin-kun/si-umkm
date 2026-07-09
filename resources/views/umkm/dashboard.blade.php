<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pelaku UMKM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">Profil Usaha Anda</h3>
                    
                    @if($umkm)
                        <div class="mb-6 p-4 rounded-md 
                            @if($umkm->status == 'Disetujui') bg-green-50 border border-green-200 
                            @elseif($umkm->status == 'Ditolak' || $umkm->status == 'Direvisi') bg-red-50 border border-red-200
                            @else bg-yellow-50 border border-yellow-200 @endif">
                            <p class="font-semibold">Status Saat Ini: 
                                <span class="uppercase">{{ $umkm->status }}</span>
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('umkm.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Usaha</label>
                            <input type="text" name="name" value="{{ old('name', $umkm->name ?? '') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $umkm->category_id ?? '') == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="contact" value="{{ old('contact', $umkm->contact ?? '') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea name="address" rows="3" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $umkm->address ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat Usaha</label>
                            <textarea name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $umkm->description ?? '') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Profil
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>