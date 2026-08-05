<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal UMKM') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-gradient-to-b from-stone-50 via-white to-emerald-50">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 sm:px-6 lg:px-8 relative overflow-hidden">
            
            <!-- Ornamen Dekorasi Background -->
            <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-[radial-gradient(circle_at_top,rgba(4,120,87,0.1),transparent_50%)]"></div>

            @include('layouts.flash-notifications')
            
            <!-- Logo SI-UMKM -->
            <div class="mb-8 relative z-10">
                <a href="/" class="flex items-center gap-3 font-semibold tracking-wide text-emerald-700 transition-transform hover:scale-105">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-600 text-lg font-bold text-white shadow-md">S</span>
                    <span class="text-2xl">SI-UMKM</span>
                </a>
            </div>

            <!-- Card Pembungkus Form -->
            <div class="w-full sm:max-w-md relative z-10 overflow-hidden rounded-3xl border border-emerald-200/80 bg-white/90 px-6 py-8 shadow-xl shadow-emerald-100/50 backdrop-blur-md sm:px-10">
                {{ $slot }}
            </div>
        </div>

        @stack('scripts')
    </body>
</html>