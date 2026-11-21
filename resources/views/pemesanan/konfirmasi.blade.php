<x-layouts.public title="Konfirmasi Pemesanan">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-8">

        <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-[#174E3F]/60">
            <a href="{{ route('home') }}" class="transition-colors hover:text-[#DF603F]">Beranda</a>
            <span>/</span>
            <span class="font-semibold text-[#174E3F]">Konfirmasi Pemesanan</span>
        </div>

        <h1 class="text-2xl font-bold text-[#253C34]">Konfirmasi Pemesanan</h1>
        <p class="mt-1 text-sm text-[#64756D]">Periksa kembali detail pemesanan sebelum melanjutkan ke pembayaran.</p>

        <div class="mt-6">
            <x-tiket.stepper :aktif="3" />
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem] lg:items-start">

            <div class="space-y-6">
                <section class="rounded-2xl bg-white p-6">
                    <h2 class="text-lg font-bold text-[#253C34]">Detail Perjalanan</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        @foreach ([
        'Bus' => $bus['nama'] . ' (' . $bus['kelas'] . ')',
        'Rute' => $bus['kota_asal'] . ' → ' . $bus['kota_tujuan'],
        'Tanggal' => $tanggalTampil,
        'Berangkat' => $bus['berangkat'] . ' WIB',
        'Kursi' => implode(', ', $pemesanan['kursi']),
    ] as $label => $nilai)
                            <div class="flex justify-between gap-4 border-b border-[#174E3F]/10 pb-3 last:border-0">
                                <dt class="text-[#64756D]">{{ $label }}</dt>
                                <dd class="font-semibold text-[#253C34] text-right">{{ $nilai }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <section class="rounded-2xl bg-white p-6">
                    <h2 class="text-lg font-bold text-[#253C34]">Data Penumpang</h2>
                    @foreach ($pemesanan['penumpang'] as $i => $p)
                        <div class="{{ $i > 0 ? 'mt-5 border-t border-[#174E3F]/10 pt-5' : 'mt-4' }}">
                            <p class="text-xs font-bold text-[#174E3F]">
                                Penumpang {{ $i + 1 }} &bull; Kursi {{ $pemesanan['kursi'][$i] }}
                            </p>
                            <dl class="mt-2 grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <dt class="text-xs text-[#64756D]">Nama</dt>
                                    <dd class="font-semibold text-[#253C34]">{{ $p['nama'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-[#64756D]">NIK</dt>
                                    <dd class="font-semibold text-[#253C34]">****{{ substr($p['nik'], -4) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-[#64756D]">Telepon</dt>
                                    <dd class="font-semibold text-[#253C34]">{{ $p['telepon'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-[#64756D]">Email</dt>
                                    <dd class="font-semibold text-[#253C34]">{{ $p['email'] }}</dd>
                                </div>
                            </dl>
                        </div>
                    @endforeach
                </section>
            </div>

            <div class="space-y-4">
                <x-pemesanan.order-summary :operator="$bus['nama']" :asal="$bus['kota_asal']" :tujuan="$bus['kota_tujuan']" :tanggal="$tanggalTampil"
                    :jam="$bus['berangkat']" :kursi="$pemesanan['kursi']" :total="$total" />

                <form method="POST" action="{{ route('pemesanan.simpan', ['id' => $bus['id']]) }}">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl bg-[#174E3F] py-4 text-sm font-bold text-white transition hover:bg-[#123d32]">
                        Konfirmasi & Lanjut ke Pembayaran
                    </button>
                </form>

                <a href="{{ route('pemesanan.penumpang', ['id' => $bus['id']] + $pemesanan['pencarian'] + ['kursi' => $pemesanan['kursi']]) }}"
                    class="block text-center text-xs text-[#64756D] hover:text-[#174E3F]">
                    Kembali ubah data penumpang
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
