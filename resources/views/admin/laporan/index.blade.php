<x-layouts.admin title="Laporan Pendapatan">
    <style>
        @media print {

            aside,
            header,
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }
        }
    </style>

    <form method="GET" action="{{ route('admin.laporan.index') }}"
        class="no-print flex flex-wrap items-end justify-between gap-4 rounded-2xl bg-white p-5 border border-[#174E3F]/10 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-semibold text-[#64756D] mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ $dari }}"
                    class="rounded-xl border border-[#174E3F]/20 px-3.5 py-2 text-xs">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#64756D] mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ $sampai }}"
                    class="rounded-xl border border-[#174E3F]/20 px-3.5 py-2 text-xs">
            </div>
            <button type="submit"
                class="rounded-xl bg-[#174E3F] px-5 py-2.5 text-xs font-bold text-white hover:bg-[#123d32] transition">
                Tampilkan Laporan
            </button>
        </div>

        <button type="button" onclick="window.print()"
            class="rounded-xl border-2 border-[#174E3F] px-4 py-2 text-xs font-bold text-[#174E3F] hover:bg-[#174E3F] hover:text-white transition">
            Cetak / Simpan PDF
        </button>
    </form>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-admin.stat-card title="Pendapatan Periode Ini"
            value="Rp{{ number_format($totalPendapatan, 0, ',', '.') }}" />
        <x-admin.stat-card title="Total Transaksi Lunas" value="{{ $transaksiLunas->count() }} Pemesanan"
            accent="dark" />
        <x-admin.stat-card title="Total Penumpang Berangkat" value="{{ $totalKursi }} Orang" accent="orange" />
    </div>

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <h2 class="text-base font-bold text-[#253C34] mb-4">Rekapitulasi per Armada Bus</h2>
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                <tr>
                    <th class="py-3">Nama Armada</th>
                    <th class="py-3">Kelas</th>
                    <th class="py-3">Transaksi</th>
                    <th class="py-3">Kursi Terjual</th>
                    <th class="py-3 text-right">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#174E3F]/10">
                @forelse ($rekapArmada as $r)
                    <tr>
                        <td class="py-3 font-bold text-[#253C34]">{{ $r['nama'] }}</td>
                        <td class="py-3 text-xs">{{ $r['kelas'] }}</td>
                        <td class="py-3 text-xs">{{ $r['transaksi'] }}x</td>
                        <td class="py-3 text-xs">{{ $r['kursi'] }} Kursi</td>
                        <td class="py-3 text-right font-bold text-[#174E3F]">
                            Rp{{ number_format($r['pendapatan'], 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-xs text-[#64756D]">
                            Tidak ada transaksi lunas pada rentang tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
