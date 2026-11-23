<x-layouts.public title="Dashboard Penumpang">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-[#253C34]">
                Halo, {{ auth()->user()->name }}!
            </h1>
            <p class="mt-1 text-sm text-[#64756D]">
                Kelola tiket perjalanan dan pantau status pemesanan BusGo kamu di sini.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <x-dashboard.sidebar />
            </div>

            <div class="lg:col-span-3 space-y-8">
                <x-dashboard.stat-cards :statistik="$statistik" />

                @if ($perjalananBerikutnya)
                    <section>
                        <div class="mb-3 flex items-center justify-between">
                            <h2 class="text-base font-bold text-[#253C34]">Perjalanan Berikutnya</h2>
                            <span class="rounded-full bg-[#DDEAE3] px-3 py-0.5 text-xs font-semibold text-[#174E3F]">
                                Siap Berangkat
                            </span>
                        </div>
                        <x-dashboard.booking-card :item="$perjalananBerikutnya" />
                    </section>
                @endif

                <section>
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-base font-bold text-[#253C34]">Pemesanan Terbaru</h2>
                        <a href="{{ route('riwayat.index') }}"
                            class="text-xs font-semibold text-[#174E3F] hover:underline">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    @if ($transaksiTerbaru->isEmpty())
                        <div class="rounded-2xl bg-white p-10 text-center border border-[#174E3F]/10">
                            <p class="font-bold text-[#253C34]">Belum ada pemesanan tiket</p>
                            <p class="mt-1 text-xs text-[#64756D]">Mulai cari rute dan pesan kursi bus pertamamu
                                sekarang.</p>
                            <a href="{{ route('home') }}"
                                class="mt-5 inline-block rounded-xl bg-[#174E3F] px-6 py-2.5 text-xs font-bold text-white hover:bg-[#123d32] transition">
                                Cari Tiket Bus
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($transaksiTerbaru as $item)
                                <x-dashboard.booking-card :item="$item" />
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-layouts.public>
