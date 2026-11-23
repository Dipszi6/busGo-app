@props(['item'])

@php
    $jadwal = $item->jadwal;
    $rute = $jadwal->rute;
    $bus = $jadwal->bus;
    $isExpired = $item->sudahKedaluwarsa();

    $badgeClass = match (true) {
        $item->status === 'lunas' => 'bg-[#DDEAE3] text-[#174E3F]',
        $item->status === 'menunggu_pembayaran' && !$isExpired => 'bg-amber-100 text-amber-700',
        default => 'bg-red-100 text-red-700',
    };

    $labelStatus = match (true) {
        $item->status === 'lunas' => 'Lunas',
        $item->status === 'menunggu_pembayaran' && !$isExpired => 'Menunggu Pembayaran',
        default => 'Kedaluwarsa / Gagal',
    };
@endphp

<div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10 transition hover:border-[#174E3F]/30">
    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-[#174E3F]/10 pb-3.5">
        <div class="flex items-center gap-3">
            <span class="font-mono text-sm font-bold tracking-wider text-[#174E3F]">
                {{ $item->kode }}
            </span>
            <span class="text-xs text-[#64756D]">
                &bull; {{ $item->tanggal_berangkat->locale('id')->translatedFormat('d M Y') }}
            </span>
        </div>

        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
            {{ $labelStatus }}
        </span>
    </div>

    <div class="py-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-base font-bold text-[#253C34]">
                {{ $rute->terminalAsal->kota->nama }}
                <span class="mx-1.5 text-[#174E3F]">&rarr;</span>
                {{ $rute->terminalTujuan->kota->nama }}
            </p>
            <p class="mt-1 text-xs text-[#64756D]">
                {{ $bus->nama }} ({{ $bus->kelas }}) &bull; Berangkat {{ $jadwal->jam_berangkat_tampil }} WIB
            </p>
            <p class="mt-1 text-xs text-[#64756D]">
                Kursi: <strong
                    class="text-[#253C34]">{{ $item->penumpang->pluck('nomor_kursi')->sort()->implode(', ') }}</strong>
                ({{ $item->penumpang->count() }} Penumpang)
            </p>
        </div>

        <div class="sm:text-right">
            <p class="text-xs text-[#64756D]">Total Pembayaran</p>
            <p class="text-lg font-bold text-[#174E3F]">
                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-2.5 border-t border-[#174E3F]/10 pt-3.5">
        <a href="{{ route('pemesanan.sukses', $item->kode) }}"
            class="rounded-xl border border-[#174E3F]/20 px-4 py-2 text-xs font-semibold text-[#253C34] hover:bg-[#F6F9F7] transition">
            Detail
        </a>

        @if ($item->status === 'lunas')
            <a href="{{ route('pemesanan.etiket.pdf', $item->kode) }}"
                class="rounded-xl border border-[#174E3F] px-4 py-2 text-xs font-semibold text-[#174E3F] hover:bg-[#DDEAE3]/50 transition">
                Unduh PDF
            </a>
            <a href="{{ route('pemesanan.etiket', $item->kode) }}"
                class="rounded-xl bg-[#174E3F] px-4 py-2 text-xs font-bold text-white hover:bg-[#123d32] transition">
                Lihat E-Tiket
            </a>
        @elseif ($item->status === 'menunggu_pembayaran' && !$isExpired)
            <a href="{{ route('pembayaran.bayar', $item->kode) }}"
                class="rounded-xl bg-[#DF603F] px-4 py-2 text-xs font-bold text-white hover:bg-[#cb5436] transition">
                Bayar Sekarang
            </a>
        @else
            <a href="{{ route('home') }}"
                class="rounded-xl bg-[#174E3F] px-4 py-2 text-xs font-bold text-white hover:bg-[#123d32] transition">
                Pesan Ulang
            </a>
        @endif
    </div>
</div>
