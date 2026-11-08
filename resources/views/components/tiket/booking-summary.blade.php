@props(['asal', 'tujuan', 'tanggal', 'jam', 'harga'])

<aside class="h-fit rounded-2xl bg-white p-6">
    <h2 class="text-xl font-bold text-[#253C34]">Ringkasan Pemesanan</h2>

    <dl class="mt-4 space-y-4 border-t border-[#174E3F]/10 pt-4">
        <div>
            <dt class="text-xs text-[#64756D]">Rute Perjalanan</dt>
            <dd class="mt-1 font-bold text-[#253C34]">{{ $asal }} &rarr; {{ $tujuan }}</dd>
        </div>
        <div>
            <dt class="text-xs text-[#64756D]">Tanggal Keberangkatan</dt>
            <dd class="mt-1 font-bold text-[#253C34]">{{ $tanggal }}</dd>
        </div>
        <div>
            <dt class="text-xs text-[#64756D]">Jam Keberangkatan</dt>
            <dd class="mt-1 font-bold text-[#253C34]">{{ $jam }} WIB</dd>
        </div>
    </dl>

    <dl class="mt-4 space-y-4 border-t border-[#174E3F]/10 pt-4">
        <div>
            <dt class="text-xs text-[#64756D]">Kursi Dipilih</dt>
            <dd class="mt-1 font-bold text-[#174E3F]" x-text="dipilih.length ? dipilih.join(', ') : '-'"></dd>
        </div>
        <div>
            <dt class="text-xs text-[#64756D]">Harga Tiket / Kursi</dt>
            <dd class="mt-1 font-bold text-[#253C34]">Rp{{ number_format($harga, 0, ',', '.') }}</dd>
        </div>
    </dl>

    <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
        <p class="text-sm font-bold text-[#253C34]">Total Pembayaran</p>
        <p class="mt-1 text-2xl font-bold text-[#DF603F]" x-text="rupiah(dipilih.length * harga)"></p>
    </div>
</aside>
