@props(['operator', 'asal', 'tujuan', 'tanggal', 'jam', 'kursi' => [], 'total'])

<aside class="h-fit rounded-2xl bg-white p-6">
    <h2 class="text-xl font-bold text-[#253C34]">Ringkasan Pemesanan</h2>

    <dl class="mt-4 space-y-4 border-t border-[#174E3F]/10 pt-4">
        @foreach ([
        'Operator Bus' => $operator,
        'Rute Perjalanan' => $asal . ' → ' . $tujuan,
        'Tanggal Keberangkatan' => $tanggal,
        'Jam Keberangkatan' => $jam . ' WIB',
        'Nomor Kursi' => implode(', ', $kursi),
    ] as $label => $nilai)
            <div>
                <dt class="text-xs text-[#64756D]">{{ $label }}</dt>
                <dd class="mt-1 font-bold text-[#253C34]">{{ $nilai }}</dd>
            </div>
        @endforeach
    </dl>

    <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
        <p class="text-sm font-bold text-[#253C34]">Total Pembayaran</p>
        <p class="mt-1 text-2xl font-bold text-[#DF603F]">
            Rp{{ number_format($total, 0, ',', '.') }}
        </p>
    </div>
</aside>
