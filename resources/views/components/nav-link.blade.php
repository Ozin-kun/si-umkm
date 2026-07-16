@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-2 text-sm font-medium leading-5 text-indigo-700 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-full border border-transparent px-3 py-2 text-sm font-medium leading-5 text-slate-500 hover:border-slate-200 hover:bg-slate-50 hover:text-slate-800 focus:outline-none focus:text-slate-800 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
