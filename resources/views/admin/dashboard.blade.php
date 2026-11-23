<x-layouts.admin title="Dashboard Ringkasan">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-admin.stat-card title="Total Pendapatan (Lunas)" value="Rp{{ number_format($totalPendapatan, 0, ',', '.') }}"
            subtitle="Dari seluruh transaksi terkonfirmasi" />

        <x-admin.stat-card title="Tiket Terjual" value="{{ $tiketTerjual }} Kursi"
            subtitle="{{ $menungguBayar }} pesanan menunggu bayar" accent="orange" />

        <x-admin.stat-card title="Armada & Jadwal Aktif" value="{{ $totalArmada }} Bus / {{ $jadwalAktif }} Jadwal"
            subtitle="Siap beroperasi melayani rute" accent="dark" />

        <x-admin.stat-card title="Total Pelanggan" value="{{ $totalPelanggan }} Akun"
            subtitle="Pengguna terdaftar role penumpang" />
    </div>

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-bold text-[#253C34]">Manifest Keberangkatan Hari Ini</h2>
                <p class="text-xs text-[#64756D]">{{ today()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>
            <span class="rounded-full bg-[#DDEAE3] px-3 py-1 text-xs font-bold text-[#174E3F]">
                {{ $keberangkatanHariIni->count() }} Pemesanan Lunas
            </span>
        </div>

        @if ($keberangkatanHariIni->isEmpty())
            <p class="py-6 text-center text-xs text-[#64756D]">Tidak ada keberangkatan lunas untuk hari ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                        <tr>
                            <th class="py-3 pr-4">Kode</th>
                            <th class="py-3 pr-4">Jam</th>
                            <th class="py-3 pr-4">Rute & Armada</th>
                            <th class="py-3 pr-4">Pemesan</th>
                            <th class="py-3 text-right">Kursi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#174E3F]/10">
                        @foreach ($keberangkatanHariIni as $item)
                            <tr>
                                <td class="py-3 pr-4 font-mono text-xs font-bold text-[#174E3F]">{{ $item->kode }}
                                </td>
                                <td class="py-3 pr-4 font-semibold">{{ $item->jadwal->jam_berangkat_tampil }} WIB</td>
                                <td class="py-3 pr-4">
                                    <p class="font-semibold text-[#253C34]">
                                        {{ $item->jadwal->rute->terminalAsal->kota->nama }} &rarr;
                                        {{ $item->jadwal->rute->terminalTujuan->kota->nama }}
                                    </p>
                                    <p class="text-xs text-[#64756D]">{{ $item->jadwal->bus->nama }}</p>
                                </td>
                                <td class="py-3 pr-4 text-xs">{{ $item->user->name }}</td>
                                <td class="py-3 text-right font-mono text-xs font-bold">
                                    {{ $item->penumpang->pluck('nomor_kursi')->sort()->implode(', ') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-[#253C34]">Transaksi Terbaru</h2>
            <a href="{{ route('admin.pemesanan.index') }}" class="text-xs font-bold text-[#174E3F] hover:underline">
                Kelola Semua Pemesanan &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                    <tr>
                        <th class="py-3 pr-4">Kode</th>
                        <th class="py-3 pr-4">Pemesan</th>
                        <th class="py-3 pr-4">Rute & Tanggal</th>
                        <th class="py-3 pr-4">Total</th>
                        <th class="py-3 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#174E3F]/10">
                    @foreach ($transaksiTerbaru as $trx)
                        <tr>
                            <td class="py-3 pr-4 font-mono text-xs font-bold text-[#174E3F]">{{ $trx->kode }}</td>
                            <td class="py-3 pr-4">
                                <p class="font-semibold text-[#253C34]">{{ $trx->user->name }}</p>
                                <p class="text-xs text-[#64756D]">{{ $trx->penumpang->count() }} Kursi</p>
                            </td>
                            <td class="py-3 pr-4 text-xs">
                                <p class="font-semibold text-[#253C34]">
                                    {{ $trx->jadwal->rute->terminalAsal->kota->nama }} &rarr;
                                    {{ $trx->jadwal->rute->terminalTujuan->kota->nama }}
                                </p>
                                <p class="text-[#64756D]">
                                    {{ $trx->tanggal_berangkat->locale('id')->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="py-3 pr-4 font-semibold text-[#253C34]">
                                Rp{{ number_format($trx->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-3 text-right">
                                <x-admin.status-badge :status="$trx->status" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
