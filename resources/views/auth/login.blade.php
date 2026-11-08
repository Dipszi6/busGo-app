<x-auth.split-layout judul="Masuk ke Akun" subjudul="Silakan masuk untuk melanjutkan pemesanan tiket." aktif="masuk">

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-[#DDEAE3] p-3 text-xs text-[#174E3F]">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <x-auth.field name="email" label="Alamat Email" type="email" placeholder="Masukkan alamat email Anda"
            autocomplete="username" required autofocus />

        <x-auth.field name="password" label="Kata Sandi" type="password" placeholder="Masukkan kata sandi Anda"
            autocomplete="current-password" required />

        @if (Route::has('password.request'))
            <div class="text-right text-xs">
                <a href="{{ route('password.request') }}" class="text-[#DF603F] hover:underline">Lupa Kata Sandi?</a>
            </div>
        @endif

        <button type="submit"
            class="w-full rounded-xl bg-[#174E3F] py-3.5 text-sm font-bold text-white transition hover:bg-[#123d32]">
            Masuk
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-[#64756D]">
        Belum memiliki akun?
        <a href="{{ route('register') }}" class="ml-1 font-bold text-[#DF603F] hover:underline">Daftar Sekarang</a>
    </p>
</x-auth.split-layout>
