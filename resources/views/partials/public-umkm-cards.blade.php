@foreach($umkms as $u)
    <div data-reveal style="transition-delay: {{ $loop->index * 80 }}ms" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-md hover:-translate-y-1 hover:shadow-xl backdrop-blur-sm hover:border-emerald-300">
        <div class="flex-1 p-6">
            <div class="mb-4 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                @if($u->placePhotos->count() > 0)
                    <div class="relative h-44 w-full" data-auto-carousel data-interval="3200">
                        <div class="flex h-full transition-transform duration-700 ease-out" data-carousel-track>
                            @foreach($u->placePhotos as $photo)
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Foto tempat {{ $u->name }} {{ $loop->iteration }}" class="h-full w-full shrink-0 object-cover">
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex h-44 w-full items-center justify-center text-sm text-slate-400">Belum ada foto tempat usaha</div>
                @endif
            </div>

            <div class="mb-4 flex items-start justify-between">
                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                    {{ $u->category->name }}
                </span>
            </div>
            <a href="{{ route('public.umkm.show', $u->id) }}" class="block">
                <h3 class="text-xl font-semibold tracking-tight text-slate-900 transition-colors group-hover:text-emerald-600">{{ $u->name }}</h3>
            </a>
            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">
                {{ $u->description ?? 'Pelaku usaha ini belum menambahkan deskripsi detail mengenai bisnis mereka.' }}
            </p>
        </div>
        <div class="border-t border-slate-100 bg-slate-50/80 px-6 py-4">
            <div class="mb-2 flex items-center text-sm text-slate-500">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ $u->address }}
            </div>
            <div class="flex items-center text-sm text-slate-500">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                {{ $u->contact }}
            </div>
            @if($u->google_maps_url)
                <a href="{{ $u->google_maps_url }}" target="_blank" class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-indigo-600 transition-colors hover:text-indigo-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    Buka Lokasi di Google Maps
                </a>
            @endif
        </div>
    </div>
@endforeach