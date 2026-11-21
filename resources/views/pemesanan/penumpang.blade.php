<x-layouts.public title="Data Penumpang">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8">

        <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-[#174E3F]/60">
            <a href="{{ route('home') }}" class="transition-colors hover:text-[#DF603F]">Beranda</a>
            <span>/</span>
            <a href="{{ route('tiket.cari', $pencarian) }}" class="transition-colors hover:text-[#DF603F]">Pencarian</a>
            <span>/</span>
            <a href="{{ route('tiket.detail', ['id' => $bus['id']] + $pencarian) }}"
                class="transition-colors hover:text-[#DF603F]">Detail Perjalanan</a>
            <span>/</span>
            <a href="{{ route('tiket.kursi', ['id' => $bus['id']] + $pencarian) }}"
                class="transition-colors hover:text-[#DF603F]">Pilih Kursi</a>
            <span>/</span>
            <span class="font-semibold text-[#174E3F]">Data Penumpang</span>
        </div>

        <h1 class="text-2xl font-bold text-[#253C34]">Data Penumpang</h1>
        <p class="mt-1 text-sm text-[#64756D]">Lengkapi identitas penumpang untuk melanjutkan pemesanan tiket.</p>

        <div class="mt-6">
            <x-tiket.stepper :aktif="2" />
        </div>

        <form method="POST" action="{{ route('pemesanan.penumpang.simpan', ['id' => $bus['id']]) }}">
            @csrf

            @foreach ($pencarian as $nama => $nilai)
                <input type="hidden" name="{{ $nama }}" value="{{ $nilai }}">
            @endforeach
            @foreach ($kursi as $no)
                <input type="hidden" name="kursi[]" value="{{ $no }}">
            @endforeach

            <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem] lg:items-start">

                <section class="rounded-2xl bg-white p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-[#253C34]">Informasi Penumpang</h2>
                    <p class="mt-1 text-xs text-[#64756D]">Masukkan data sesuai identitas penumpang.</p>

                    @foreach ($kursi as $i => $no)
                        <x-pemesanan.passenger-fields :index="$i" :kursi="$no" :banyak="count($kursi) > 1" />
                    @endforeach
                </section>

                <x-pemesanan.order-summary :operator="$bus['nama']" :asal="$pencarian['asal']" :tujuan="$pencarian['tujuan']" :tanggal="$tanggalTampil"
                    :jam="$bus['berangkat']" :kursi="$kursi" :total="$total" />
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
                <a href="{{ route('tiket.kursi', ['id' => $bus['id']] + $pencarian) }}"
                    class="rounded-xl border-2 border-[#174E3F] px-10 py-3.5 text-center text-sm font-bold text-[#174E3F] transition hover:bg-[#174E3F] hover:text-white">
                    Kembali
                </a>
                <button type="submit"
                    class="rounded-xl bg-[#174E3F] px-10 py-3.5 text-sm font-bold text-white transition hover:bg-[#123d32] sm:min-w-[18rem]">
                    Lanjut ke Ringkasan
                </button>
            </div>
        </form>
    </div>
</x-layouts.public>
