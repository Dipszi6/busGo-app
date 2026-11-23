<x-layouts.admin title="Monitoring Pembayaran Midtrans">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-admin.stat-card title="Dana Terkonfirmasi (Lunas)"
            value="Rp{{ number_format($ringkasan['lunas'], 0, ',', '.') }}" />
        <x-admin.stat-card title="Menunggu Pembayaran" value="Rp{{ number_format($ringkasan['pending'], 0, ',', '.') }}"
            accent="orange" />
        <x-admin.stat-card title="Transaksi Gagal / Kedaluwarsa" value="{{ $ringkasan['gagal'] }} Transaksi"
            accent="dark" />
    </div>

    <x-admin.filter-bar :action="route('admin.pembayaran.index')" placeholder="Cari Order ID / Kode BG..." :statuses="[
        'semua' => 'Semua',
        'lunas' => 'Lunas',
        'menunggu_pembayaran' => 'Pending',
        'gagal' => 'Gagal',
    ]" />

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                    <tr>
                        <th class="py-3 pr-4">Order ID (Kode)</th>
                        <th class="py-3 pr-4">Pemesan</th>
                        <th class="py-3 pr-4">Nominal</th>
                        <th class="py-3 pr-4">Snap Token</th>
                        <th class="py-3 pr-4">Waktu Lunas</th>
                        <th class="py-3 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#174E3F]/10">
                    @foreach ($transaksi as $t)
                        <tr>
                            <td class="py-3.5 pr-4 font-mono text-xs font-bold text-[#174E3F]">{{ $t->kode }}</td>
                            <td class="py-3.5 pr-4 text-xs font-semibold text-[#253C34]">{{ $t->user->name }}</td>
                            <td class="py-3.5 pr-4 font-bold">Rp{{ number_format($t->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3.5 pr-4 font-mono text-[11px] text-[#64756D]">
                                {{ $t->snap_token ? \Illuminate\Support\Str::limit($t->snap_token, 18) : '-' }}
                            </td>
                            <td class="py-3.5 pr-4 text-xs text-[#64756D]">
                                {{ $t->dibayar_pada ? $t->dibayar_pada->locale('id')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                            </td>
                            <td class="py-3.5 text-right">
                                <x-admin.status-badge :status="$t->status" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transaksi->links() }}</div>
    </div>
</x-layouts.admin>
