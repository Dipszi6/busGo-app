<x-auth.split-layout judul="Buat Akun Baru" subjudul="Daftar sekarang dan mulai pesan tiket dengan mudah." aktif="daftar">

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf

        <x-auth.field name="name" label="Nama Lengkap" type="text" placeholder="Masukkan nama lengkap Anda"
            autocomplete="name" required autofocus />

        <x-auth.field name="email" label="Alamat Email" type="email" placeholder="Masukkan alamat email Anda"
            autocomplete="username" required />

        <x-auth.field name="password" label="Kata Sandi" type="password" placeholder="Minimal 8 karakter"
            autocomplete="new-password" required />

        <x-auth.field name="password_confirmation" label="Konfirmasi Kata Sandi" type="password"
            placeholder="Ulangi kata sandi Anda" autocomplete="new-password" required />

        <button type="submit"
            class="w-full rounded-xl bg-[#174E3F] py-3.5 text-sm font-bold text-white transition hover:bg-[#123d32]">
            Daftar Sekarang
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-[#64756D]">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="ml-1 font-bold text-[#DF603F] hover:underline">Masuk Sekarang</a>
    </p>

</x-auth.split-layout>
