<x-layouts.public title="Pemesanan Berhasil">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-8 text-center">

        <div class="flex justify-center">
            @if ($pemesanan->status === 'lunas')
                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-[#DDEAE3]">
                    <svg class="h-10 w-10 text-[#174E3F]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l5 5 9-10" />
                    </svg>
                </span>
            @else
                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-amber-100">
                    <svg class="h-10 w-10 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </span>
            @endif
        </div>

        @if ($pemesanan->status === 'lunas')
            <h1 class="mt-6 text-2xl font-bold text-[#253C34]">Pembayaran Berhasil!</h1>
            <p class="mt-2 text-sm text-[#64756D]">
                Pembayaran kamu telah kami terima. E-tiket sudah siap digunakan.
            </p>
        @else
            <h1 class="mt-6 text-2xl font-bold text-[#253C34]">Pemesanan Diterima!</h1>
            <p class="mt-2 text-sm text-[#64756D]">
                Pesananmu sudah tersimpan. Selesaikan pembayaran untuk mendapatkan e-tiket.
            </p>
        @endif

        <div class="mt-8 rounded-2xl bg-white p-6 text-left">
            <p class="text-xs text-[#64756D]">Kode Pemesanan</p>
            <p class="mt-1 text-2xl font-bold tracking-widest text-[#174E3F]">{{ $pemesanan->kode }}</p>

            <dl class="mt-6 space-y-3 text-sm">
                @foreach ([
        'Bus' => $pemesanan->jadwal->bus->nama,
        'Rute' => $pemesanan->jadwal->rute->terminalAsal->kota->nama . ' → ' . $pemesanan->jadwal->rute->terminalTujuan->kota->nama,
        'Tanggal' => $pemesanan->tanggal_berangkat->locale('id')->translatedFormat('d F Y'),
        'Berangkat' => $pemesanan->jadwal->jam_berangkat_tampil . ' WIB',
        'Kursi' => $pemesanan->penumpang->pluck('nomor_kursi')->sort()->implode(', '),
        'Total' => 'Rp' . number_format($pemesanan->total_harga, 0, ',', '.'),
    ] as $label => $nilai)
                    <div class="flex justify-between gap-4 border-b border-[#174E3F]/10 pb-3 last:border-0">
                        <dt class="text-[#64756D]">{{ $label }}</dt>
                        <dd class="font-semibold text-[#253C34] text-right">{{ $nilai }}</dd>
                    </div>
                @endforeach

                <div class="flex justify-between gap-4 pt-1">
                    <dt class="text-[#64756D]">Status</dt>
                    <dd
                        class="font-semibold text-right {{ $pemesanan->status === 'lunas' ? 'text-[#174E3F]' : 'text-amber-500' }}">
                        {{ $pemesanan->status === 'lunas' ? 'Lunas' : 'Menunggu Pembayaran' }}
                    </dd>
                </div>
            </dl>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('home') }}"
                class="rounded-xl border-2 border-[#174E3F] px-8 py-3 text-sm font-bold text-[#174E3F] hover:bg-[#174E3F] hover:text-white transition">
                Kembali ke Beranda
            </a>

            @if ($pemesanan->status === 'lunas')
                <a href="#"
                    class="rounded-xl bg-[#174E3F] px-8 py-3 text-sm font-bold text-white hover:bg-[#123d32] transition">
                    Lihat E-Tiket
                </a>
            @else
                <a href="{{ route('pembayaran.bayar', $pemesanan->kode) }}"
                    class="rounded-xl bg-[#DF603F] px-8 py-3 text-sm font-bold text-white hover:bg-[#cb5436] transition">
                    Bayar Sekarang
                </a>
            @endif
        </div>
    </div>
</x-layouts.public>
