<x-layouts.public title="Detail Perjalanan">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8">

        <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-[#174E3F]/60">
            <a href="{{ route('home') }}" class="transition-colors hover:text-[#DF603F]">Beranda</a>
            <span>/</span>
            <a href="{{ route('tiket.cari', $pencarian) }}" class="transition-colors hover:text-[#DF603F]">Hasil
                Pencarian</a>
            <span>/</span>
            <span class="font-semibold text-[#174E3F]">Detail Perjalanan</span>
        </div>

        <h1 class="text-2xl font-bold text-[#253C34]">Detail Perjalanan</h1>
        <p class="mt-1 text-sm text-[#64756D]">Periksa informasi perjalanan sebelum memilih kursi.</p>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem] lg:items-start">

            <div class="space-y-6">
                <x-tiket.bus-detail-card :nama="$bus['nama']" :kelas="$bus['kelas']" :fasilitas="$bus['fasilitas']" :deskripsi="$bus['deskripsi']" />

                <x-tiket.schedule-card :berangkat="$bus['berangkat']" :tiba="$bus['tiba']" :terminal-asal="$bus['terminal_asal'] . ', ' . $pencarian['asal']" :terminal-tujuan="$bus['terminal_tujuan'] . ', ' . $pencarian['tujuan']"
                    :durasi="$bus['durasi']" />
            </div>

            <x-tiket.trip-summary :asal="$pencarian['asal']" :tujuan="$pencarian['tujuan']" :tanggal="$tanggalTampil" :penumpang="$pencarian['penumpang']"
                :harga="$bus['harga']" :href="route('tiket.kursi', ['id' => $bus['id']] + $pencarian)" />
        </div>
    </div>
</x-layouts.public>
