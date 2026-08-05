<x-guest-layout>
    <!-- Header Form -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang</h2>
        <p class="mt-2 text-sm text-slate-500">Masuk untuk mengelola profil dan etalase usaha Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="mt-1 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm transition-colors focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400" placeholder="nama@email.com">
            @error('email')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="mt-1 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm transition-colors focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400" placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                <span class="ms-2 text-sm text-slate-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-emerald-600 transition-colors hover:text-emerald-700" href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center items-center rounded-full bg-emerald-600 px-4 py-3.5 text-sm font-bold text-white shadow-md transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Masuk ke Sistem
            </button>
        </div>
        
        <p class="text-center text-sm text-slate-600 mt-6">
            Belum mendaftarkan usaha? 
            <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>