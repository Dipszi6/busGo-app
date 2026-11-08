@props(['judul', 'subjudul' => null, 'aktif' => 'masuk'])

<x-layouts.public :title="$judul">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8">
        <div class="grid gap-6 lg:grid-cols-[1fr_1.1fr]">

            <aside class="hidden flex-col justify-between gap-10 rounded-2xl bg-[#174E3F] p-10 text-white lg:flex">
                <div>
                    <p class="text-xs font-bold tracking-wide">SELAMAT DATANG DI</p>
                    <h2 class="mt-4 text-4xl font-extrabold uppercase leading-tight">{{ config('app.name') }}</h2>
                    <p class="mt-5 max-w-xs text-sm leading-relaxed text-white/80">
                        Nikmati perjalanan yang nyaman, aman, dan terpercaya bersama kami.
                    </p>
                </div>

                <div class="rounded-2xl bg-[#DDEAE3] p-8">
                    <x-bus-illustration body="#253C34" roda="#0F2922" />
                </div>

                <div>
                    <h3 class="text-lg font-bold">Perjalanan Anda, Prioritas Kami.</h3>
                    <p class="mt-2 text-sm leading-relaxed text-white/80">
                        Pesan tiket bus dengan mudah dan praktis.<br>
                        Mulai perjalanan bersama {{ config('app.name') }}.
                    </p>
                </div>
            </aside>

            <section class="rounded-2xl bg-white p-6 sm:p-10">
                <h1 class="text-2xl font-bold text-[#253C34]">{{ $judul }}</h1>
                @if ($subjudul)
                    <p class="mt-2 text-xs text-[#64756D]">{{ $subjudul }}</p>
                @endif

                <div class="mt-6 grid grid-cols-2 gap-3 text-sm font-semibold">
                    <a href="{{ route('login') }}"
                        class="rounded-xl py-3 text-center {{ $aktif === 'masuk' ? 'bg-[#174E3F] text-white' : 'bg-[#F6F2E9] text-[#64756D] hover:bg-[#ece6d8]' }}">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="rounded-xl py-3 text-center {{ $aktif === 'daftar' ? 'bg-[#174E3F] text-white' : 'bg-[#F6F2E9] text-[#64756D] hover:bg-[#ece6d8]' }}">
                        Daftar
                    </a>
                </div>

                {{ $slot }}
            </section>
        </div>
    </div>
</x-layouts.public>
