<x-layouts.admin title="Data Pemesanan Tiket">
    <x-admin.filter-bar :action="route('admin.pemesanan.index')" placeholder="Cari kode BG atau nama..." :statuses="[
        'semua' => 'Semua',
        'lunas' => 'Lunas',
        'menunggu_pembayaran' => 'Menunggu Bayar',
        'gagal' => 'Gagal',
    ]" />

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                    <tr>
                        <th class="py-3 pr-4">Kode</th>
                        <th class="py-3 pr-4">Pemesan</th>
                        <th class="py-3 pr-4">Rute & Jadwal</th>
                        <th class="py-3 pr-4">Kursi</th>
                        <th class="py-3 pr-4">Total</th>
                        <th class="py-3 pr-4">Status</th>
                        <th class="py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#174E3F]/10">
                    @forelse ($pemesanan as $item)
                        <tr>
                            <td class="py-3.5 pr-4 font-mono text-xs font-bold text-[#174E3F]">{{ $item->kode }}</td>
                            <td class="py-3.5 pr-4">
                                <p class="font-semibold text-[#253C34]">{{ $item->user->name }}</p>
                                <p class="text-xs text-[#64756D]">{{ $item->user->email }}</p>
                            </td>
                            <td class="py-3.5 pr-4 text-xs">
                                <p class="font-bold text-[#253C34]">
                                    {{ $item->jadwal->rute->terminalAsal->kota->nama }} &rarr;
                                    {{ $item->jadwal->rute->terminalTujuan->kota->nama }}
                                </p>
                                <p class="text-[#64756D]">
                                    {{ $item->tanggal_berangkat->locale('id')->translatedFormat('d M Y') }} &bull;
                                    {{ $item->jadwal->jam_berangkat_tampil }} WIB
                                </p>
                            </td>
                            <td class="py-3.5 pr-4 font-mono text-xs font-semibold">
                                {{ $item->penumpang->pluck('nomor_kursi')->sort()->implode(', ') }}
                            </td>
                            <td class="py-3.5 pr-4 font-bold text-[#253C34]">
                                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 pr-4">
                                <x-admin.status-badge :status="$item->status" />
                            </td>
                            <td class="py-3.5 text-right">
                                <a href="{{ route('admin.pemesanan.show', $item) }}"
                                    class="rounded-lg border border-[#174E3F]/20 px-3 py-1.5 text-xs font-semibold text-[#174E3F] hover:bg-[#F6F9F7]">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-xs text-[#64756D]">
                                Belum ada data pemesanan yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $pemesanan->links() }}</div>
    </div>
</x-layouts.admin>
