<x-layouts.admin title="Detail Pemesanan {{ $pemesanan->kode }}">
    <div>
        <a href="{{ route('admin.pemesanan.index') }}" class="text-xs font-bold text-[#174E3F] hover:underline">
            &larr; Kembali ke Daftar Pemesanan
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-[#174E3F]/10 pb-4">
                    <div>
                        <p class="text-xs text-[#64756D]">Kode Pemesanan</p>
                        <p class="font-mono text-xl font-bold text-[#174E3F]">{{ $pemesanan->kode }}</p>
                    </div>
                    <x-admin.status-badge :status="$pemesanan->status" />
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-[#64756D]">Rute Perjalanan</p>
                        <p class="font-bold text-[#253C34]">
                            {{ $pemesanan->jadwal->rute->terminalAsal->kota->nama }} &rarr;
                            {{ $pemesanan->jadwal->rute->terminalTujuan->kota->nama }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-[#64756D]">Armada</p>
                        <p class="font-bold text-[#253C34]">{{ $pemesanan->jadwal->bus->nama }}
                            ({{ $pemesanan->jadwal->bus->kelas }})</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#64756D]">Tanggal & Jam Berangkat</p>
                        <p class="font-bold text-[#253C34]">
                            {{ $pemesanan->tanggal_berangkat->locale('id')->translatedFormat('d F Y') }},
                            {{ $pemesanan->jadwal->jam_berangkat_tampil }} WIB
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-[#64756D]">Total Harga</p>
                        <p class="font-bold text-[#174E3F]">Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
                <h2 class="text-sm font-bold text-[#253C34] mb-4">Daftar Penumpang
                    ({{ $pemesanan->penumpang->count() }})</h2>
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                        <tr>
                            <th class="py-2.5">Kursi</th>
                            <th class="py-2.5">Nama</th>
                            <th class="py-2.5">NIK</th>
                            <th class="py-2.5">Kontak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#174E3F]/10">
                        @foreach ($pemesanan->penumpang->sortBy('nomor_kursi') as $p)
                            <tr>
                                <td class="py-3 font-mono font-bold text-[#174E3F]">{{ $p->nomor_kursi }}</td>
                                <td class="py-3 font-semibold">{{ $p->nama }} ({{ $p->jenis_kelamin }})</td>
                                <td class="py-3 font-mono text-xs">{{ $p->nik }}</td>
                                <td class="py-3 text-xs text-[#64756D]">{{ $p->telepon }} &bull; {{ $p->email }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm h-fit space-y-4">
            <h2 class="text-sm font-bold text-[#253C34]">Kontrol Status Pemesanan</h2>
            <p class="text-xs text-[#64756D]">
                Gunakan panel ini jika perlu melakukan konfirmasi pembayaran manual atau pembatalan pesanan.
            </p>

            <form method="POST" action="{{ route('admin.pemesanan.status', $pemesanan) }}" class="space-y-3">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full rounded-xl border border-[#174E3F]/20 px-3.5 py-2.5 text-sm">
                    <option value="menunggu_pembayaran" @selected($pemesanan->status === 'menunggu_pembayaran')>Menunggu Pembayaran</option>
                    <option value="lunas" @selected($pemesanan->status === 'lunas')>Lunas</option>
                    <option value="gagal" @selected($pemesanan->status === 'gagal')>Gagal / Dibatalkan</option>
                </select>
                <button type="submit"
                    class="w-full rounded-xl bg-[#174E3F] py-2.5 text-xs font-bold text-white hover:bg-[#123d32] transition">
                    Simpan Perubahan Status
                </button>
            </form>
        </div>
    </div>
</x-layouts.admin>
