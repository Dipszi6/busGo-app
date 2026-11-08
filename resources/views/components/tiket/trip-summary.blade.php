@props(['asal', 'tujuan', 'tanggal', 'penumpang', 'harga', 'href' => '#'])

<aside class="h-fit rounded-2xl bg-white p-6">
    <h2 class="text-lg font-bold text-[#253C34]">Ringkasan Perjalanan</h2>

    <dl class="mt-4 space-y-4 border-t border-[#174E3F]/10 pt-4">
        @foreach ([
        'Kota Keberangkatan' => $asal,
        'Kota Tujuan' => $tujuan,
        'Tanggal Keberangkatan' => $tanggal,
        'Jumlah Penumpang' => $penumpang . ' Orang',
    ] as $label => $nilai)
            <div>
                <dt class="text-xs text-[#64756D]">{{ $label }}</dt>
                <dd class="mt-1 font-bold text-[#253C34]">{{ $nilai }}</dd>
            </div>
        @endforeach
    </dl>

    <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
        <p class="text-xs text-[#64756D]">Harga Tiket / Orang</p>
        <p class="mt-1 text-2xl font-bold text-[#253C34]">Rp{{ number_format($harga, 0, ',', '.') }}</p>
    </div>

    <a href="{{ $href }}"
        class="mt-6 block rounded-lg bg-[#174E3F] py-3.5 text-center text-sm font-bold text-white hover:bg-[#123d32]">
        Lanjut Pilih Kursi
    </a>
</aside>
