<x-layouts.public title="Hasil Pencarian Tiket">

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8">

        <div class="mb-2 flex items-center gap-2 text-xs text-[#1B4D3E]/60">
            <a href="{{ route('home') }}" class="transition-colors hover:text-[#E2603F]">Beranda</a>
            <span>/</span>
            <span class="font-semibold text-[#1B4D3E]">Pencarian Tiket</span>
        </div>

        <h1 class="text-2xl font-bold text-[#253C34]">Hasil Pencarian Tiket</h1>
        <p class="mt-1 text-sm text-[#64756D]">Temukan perjalanan terbaik untuk tujuan Anda.</p>

        <div class="mt-6">
            <x-tiket.search-summary :asal="$pencarian['asal']" :tujuan="$pencarian['tujuan']" :tanggal="$tanggalTampil" :tanggal-raw="$pencarian['tanggal']"
                :penumpang="$pencarian['penumpang']" :kota="$kota" />
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[17rem_1fr]">

            <x-tiket.filter-sidebar :pencarian="$pencarian" :filter="$filter" />

            <section>
                <h2 class="text-lg font-bold text-[#253C34]">Bus Tersedia</h2>
                <p class="mt-1 text-xs text-[#64756D]">{{ $hasil->count() }} pilihan perjalanan ditemukan</p>

                <div class="mt-4 space-y-4">
                    @forelse ($hasil as $bus)
                        <x-tiket.bus-card :nama="$bus['nama']" :kelas="$bus['kelas']" :fasilitas="$bus['fasilitas']" :href="route('tiket.detail', ['id' => $bus['id']] + $pencarian)"
                            :berangkat="$bus['berangkat']" :tiba="$bus['tiba']" :asal="$pencarian['asal']" :tujuan="$pencarian['tujuan']"
                            :durasi="$bus['durasi']" :harga="$bus['harga']" />
                    @empty
                        <div class="rounded-2xl bg-white p-8 text-center text-sm text-[#64756D]">
                            Tidak ada bus yang cocok. Coba ubah filter atau tanggal pencarian.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-layouts.public>
