<x-layouts.admin title="Data Pelanggan">
    <x-admin.filter-bar :action="route('admin.pelanggan.index')" placeholder="Cari nama atau email pelanggan...">
        <p class="text-xs font-semibold text-[#64756D]">Total {{ $pelanggan->total() }} pelanggan terdaftar</p>
    </x-admin.filter-bar>

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                    <tr>
                        <th class="py-3 pr-4">Nama Pelanggan</th>
                        <th class="py-3 pr-4">Email</th>
                        <th class="py-3 pr-4">Bergabung Sejak</th>
                        <th class="py-3 pr-4">Total Pesanan</th>
                        <th class="py-3 text-right">Total Belanja (Lunas)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#174E3F]/10">
                    @foreach ($pelanggan as $p)
                        <tr>
                            <td class="py-3.5 pr-4 font-bold text-[#253C34]">{{ $p->name }}</td>
                            <td class="py-3.5 pr-4 text-xs text-[#64756D]">{{ $p->email }}</td>
                            <td class="py-3.5 pr-4 text-xs text-[#64756D]">
                                {{ $p->created_at->locale('id')->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-3.5 pr-4 text-xs font-semibold">{{ $p->pemesanan_count }}x Transaksi</td>
                            <td class="py-3.5 text-right font-bold text-[#174E3F]">
                                Rp{{ number_format($p->total_belanja ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pelanggan->links() }}</div>
    </div>
</x-layouts.admin>
