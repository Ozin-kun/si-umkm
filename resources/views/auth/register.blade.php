<x-guest-layout>
    <!-- Header Form -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">Daftar Akun Baru</h2>
        <p class="mt-2 text-sm text-slate-500">Bergabunglah untuk mempublikasikan produk UMKM Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap Pemilik</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="mt-1 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm transition-colors focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400" placeholder="Sesuai KTP">
            @error('name')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="mt-1 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm transition-colors focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400" placeholder="nama@email.com">
            @error('email')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="mt-1 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm transition-colors focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400" placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="mt-1 block w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm transition-colors focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400" placeholder="Ulangi kata sandi">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-5">
            <button type="submit" class="w-full flex justify-center items-center rounded-full bg-emerald-600 px-4 py-3.5 text-sm font-bold text-white shadow-md transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Daftarkan Akun
            </button>
        </div>

        <p class="text-center text-sm text-slate-600 mt-6">
            Sudah mendaftarkan akun? 
            <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>