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

        {{-- Breadcrumb --}}
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

            {{-- Denah kursi --}}
            @php
                $grup = array_map('intval', explode('-', $bus['denah']));
                $perBaris = array_sum($grup);
                $baris = (int) ceil($bus['kapasitas'] / $perBaris);
                $terisi = $bus['kursi_terisi'];
                $no = 0;
            @endphp

            <section class="rounded-2xl bg-white p-6">
                <h2 class="text-xl font-bold text-[#253C34]">Denah Kursi Bus</h2>
                <p class="mt-1 text-xs text-[#64756D]">
                    {{ $bus['nama'] }} &bull; Kapasitas {{ $bus['kapasitas'] }} Kursi
                </p>

                {{-- Legenda --}}
                <div class="mt-4 flex flex-wrap gap-5 text-xs text-[#52645C]">
                    <span class="flex items-center gap-2">
                        <span class="h-4 w-4 rounded bg-[#DDEAE3]"></span>Tersedia
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="h-4 w-4 rounded bg-[#DF603F]"></span>Dipilih
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="h-4 w-4 rounded bg-[#AEB8B2]"></span>Terisi
                    </span>
                </div>

                {{-- Badan bus --}}
                <div class="mx-auto mt-6 max-w-xs rounded-[2rem] border-2 border-[#AABBB1] bg-[#F8FAF7] p-4 sm:p-6">

                    {{-- Baris sopir dan pintu --}}
                    <div class="flex justify-between">
                        <div
                            class="flex h-12 w-24 items-center justify-center rounded-lg border-2 border-dashed border-[#174E3F]/40 text-xs text-[#174E3F]/70">
                            Pintu
                        </div>
                        <div
                            class="flex h-12 w-24 items-center justify-center rounded-lg bg-[#AEB8B2] text-xs text-white">
                            Sopir
                        </div>
                    </div>

                    {{-- Baris kursi --}}
                    <div class="mt-6 space-y-3">
                        @for ($r = 0; $r < $baris; $r++)
                            <div class="flex items-center justify-center gap-8">
                                @foreach ($grup as $jumlah)
                                    <div class="flex gap-2">
                                        @for ($i = 0; $i < $jumlah; $i++)
                                            @php $no++; @endphp

                                            @if ($no > $bus['kapasitas'])
                                                <div class="h-11 w-11"></div>
                                            @else
                                                @php $label = sprintf('%02d', $no); @endphp

                                                @if (in_array($label, $terisi))
                                                    <div title="Kursi {{ $label }} sudah terisi"
                                                        class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#AEB8B2] text-xs font-bold text-white">
                                                        {{ $label }}
                                                    </div>
                                                @else
                                                    <button type="button" @click="toggle('{{ $label }}')"
                                                        :class="dipilih.includes('{{ $label }}') ?
                                                            'bg-[#DF603F] text-white' :
                                                            'bg-[#DDEAE3] text-[#174E3F] hover:bg-[#c9ddd2]'"
                                                        :aria-pressed="dipilih.includes('{{ $label }}')"
                                                        title="Kursi {{ $label }}"
                                                        class="h-11 w-11 rounded-lg text-xs font-bold transition">
                                                        {{ $label }}
                                                    </button>
                                                @endif
                                            @endif
                                        @endfor
                                    </div>
                                @endforeach
                            </div>
                        @endfor
                    </div>
                </div>
            </section>

            {{-- Ringkasan pemesanan --}}
            <aside class="h-fit rounded-2xl bg-white p-6">
                <h2 class="text-xl font-bold text-[#253C34]">Ringkasan Pemesanan</h2>

                <dl class="mt-4 space-y-4 border-t border-[#174E3F]/10 pt-4">
                    <div>
                        <dt class="text-xs text-[#64756D]">Rute Perjalanan</dt>
                        <dd class="mt-1 font-bold text-[#253C34]">{{ $pencarian['asal'] }} &rarr;
                            {{ $pencarian['tujuan'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#64756D]">Tanggal Keberangkatan</dt>
                        <dd class="mt-1 font-bold text-[#253C34]">{{ $tanggalTampil }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#64756D]">Jam Keberangkatan</dt>
                        <dd class="mt-1 font-bold text-[#253C34]">{{ $bus['berangkat'] }} WIB</dd>
                    </div>
                </dl>

                <dl class="mt-4 space-y-4 border-t border-[#174E3F]/10 pt-4">
                    <div>
                        <dt class="text-xs text-[#64756D]">Kursi Dipilih</dt>
                        <dd class="mt-1 font-bold text-[#174E3F]" x-text="dipilih.length ? dipilih.join(', ') : '-'">
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#64756D]">Harga Tiket / Kursi</dt>
                        <dd class="mt-1 font-bold text-[#253C34]">
                            Rp{{ number_format($bus['harga'], 0, ',', '.') }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
                    <p class="text-sm font-bold text-[#253C34]">Total Pembayaran</p>
                    <p class="mt-1 text-2xl font-bold text-[#DF603F]" x-text="rupiah(dipilih.length * harga)"></p>
                </div>
            </aside>
        </div>

        {{-- Error kursi --}}
        @if ($errors->has('kursi'))
            <div class="mt-4 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first('kursi') }}
            </div>
        @endif

        <form action="{{ route('tiket.kursi.lanjut', ['id' => $bus['id']]) }}" method="POST" class="mt-6">
            @csrf

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
