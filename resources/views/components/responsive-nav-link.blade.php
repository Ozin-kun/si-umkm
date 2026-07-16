@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-start text-base font-medium text-indigo-700 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 transition duration-150 ease-in-out'
            : 'block w-full rounded-2xl border border-transparent px-4 py-3 text-start text-base font-medium text-slate-600 hover:border-slate-200 hover:bg-slate-50 hover:text-slate-800 focus:outline-none focus:text-slate-800 focus:bg-slate-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
