<x-layouts.public title="Pilih Kursi">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8" x-data="{
        maks: {{ (int) $pencarian['penumpang'] }},
        harga: {{ (int) $bus['harga'] }},
        dipilih: [],
        toggle(no) {
            if (this.dipilih.includes(no)) {
                this.dipilih = this.dipilih.filter(n => n !== no);
            } else if (this.dipilih.length < this.maks) {
                this.dipilih.push(no);
                this.dipilih.sort();
            } else if (this.maks === 1) {
                this.dipilih = [no];
            }
        },
        rupiah(n) { return 'Rp' + n.toLocaleString('id-ID'); },
    }">

        <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-[#174E3F]/60">
            <a href="{{ route('home') }}" class="transition-colors hover:text-[#DF603F]">Beranda</a>
            <span>/</span>
            <a href="{{ route('tiket.cari', $pencarian) }}" class="transition-colors hover:text-[#DF603F]">Hasil
                Pencarian</a>
            <span>/</span>
            <a href="{{ route('tiket.detail', ['id' => $bus['id']] + $pencarian) }}"
                class="transition-colors hover:text-[#DF603F]">Detail Perjalanan</a>
            <span>/</span>
            <span class="font-semibold text-[#174E3F]">Pilih Kursi</span>
        </div>

        <h1 class="text-2xl font-bold text-[#253C34]">Pilih Kursi Anda</h1>
        <p class="mt-1 text-sm text-[#64756D]">
            Silakan pilih tempat duduk yang tersedia untuk perjalanan Anda.
            Jumlah kursi yang dipilih: <span class="font-semibold">{{ $pencarian['penumpang'] }}</span>.
        </p>

        <div class="mt-6">
            <x-tiket.stepper :aktif="1" />
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem] lg:items-start">
            <x-tiket.seat-map :nama="$bus['nama']" :denah="$bus['denah']" :kapasitas="$bus['kapasitas']" :terisi="$bus['kursi_terisi']" />

            <x-tiket.booking-summary :asal="$pencarian['asal']" :tujuan="$pencarian['tujuan']" :tanggal="$tanggalTampil" :jam="$bus['berangkat']"
                :harga="$bus['harga']" />
        </div>

        <form action="{{ route('pemesanan.penumpang', ['id' => $bus['id']]) }}" method="GET" class="mt-6">
            @foreach ($pencarian as $nama => $nilai)
                <input type="hidden" name="{{ $nama }}" value="{{ $nilai }}">
            @endforeach
            <template x-for="no in dipilih" :key="no">
                <input type="hidden" name="kursi[]" :value="no">
            </template>

            <button type="submit" :disabled="dipilih.length !== maks"
                class="w-full rounded-xl bg-[#174E3F] py-4 text-sm font-bold text-white transition hover:bg-[#123d32] disabled:cursor-not-allowed disabled:opacity-50">
                Lanjutkan ke Data Penumpang
            </button>
            <p x-show="dipilih.length !== maks"
                x-text="'Pilih ' + (maks - dipilih.length) + ' kursi lagi untuk melanjutkan'"
                class="mt-2 text-center text-xs text-[#64756D]"></p>
        </form>
    </div>
</x-layouts.public>
