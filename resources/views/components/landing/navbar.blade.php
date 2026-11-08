<header class="sticky top-0 z-50 mb-0 w-full bg-[#1B4D3E] text-white shadow-md">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo {{ config('app.name') }}" class="h-9 w-9 rounded-full">
            <span class="text-lg font-bold leading-none">{{ config('app.name') }}</span>
        </a>

        <ul class="hidden items-center gap-6 text-sm md:flex">
            <li><a href="{{ route('home') }}" class="rounded-lg bg-white/15 px-4 py-2 font-semibold">Beranda</a></li>
            <li><a href="#tentang" class="transition-colors hover:text-[#F0B94A]">Tentang Kami</a></li>
            <li><a href="#armada" class="transition-colors hover:text-[#F0B94A]">Armada</a></li>
            <li><a href="#cari" class="transition-colors hover:text-[#F0B94A]">Rute &amp; Jadwal</a></li>
            <li><a href="#kontak" class="transition-colors hover:text-[#F0B94A]">Kontak</a></li>
        </ul>

        <div class="flex items-center gap-2 text-sm font-semibold">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="rounded-lg bg-[#E2603F] px-5 py-2 transition-colors hover:bg-[#cf5434]">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="rounded-lg border border-white/70 px-5 py-2 transition-colors hover:bg-white/10">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-[#E2603F] px-5 py-2 transition-colors hover:bg-[#cf5434]">Daftar</a>
            @endauth
        </div>
    </nav>
</header>