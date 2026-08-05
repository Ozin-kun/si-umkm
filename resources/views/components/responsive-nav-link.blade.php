@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-start text-base font-medium text-emerald-700 focus:outline-none focus:text-emerald-800 focus:bg-emerald-100 transition duration-150 ease-in-out'
            : 'block w-full rounded-2xl border border-transparent px-4 py-3 text-start text-base font-medium text-slate-600 hover:border-emerald-100 hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus:text-emerald-700 focus:bg-emerald-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
