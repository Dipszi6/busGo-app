<x-layouts.admin title="Rute & Jadwal Keberangkatan">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10 shadow-sm">
            <h2 class="text-sm font-bold text-[#253C34] mb-3">1. Tambah Kota & Terminal</h2>
            <form method="POST" action="{{ route('admin.jadwal.terminal.store') }}" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Nama Kota</label>
                    <input type="text" name="nama_kota" required placeholder="Contoh: Semarang"
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Nama Terminal</label>
                    <input type="text" name="nama_terminal" required placeholder="Contoh: Terminal Terboyo"
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                </div>
                <button type="submit"
                    class="w-full rounded-xl bg-[#174E3F] py-2.5 text-xs font-bold text-white hover:bg-[#123d32] transition">
                    + Simpan Terminal
                </button>
            </form>
        </div>

        <div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10 shadow-sm">
            <h2 class="text-sm font-bold text-[#253C34] mb-3">2. Buat Rute Perjalanan</h2>
            <form method="POST" action="{{ route('admin.jadwal.rute.store') }}" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Terminal Asal</label>
                    <select name="terminal_asal_id" required
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                        @foreach ($terminal as $t)
                            <option value="{{ $t->id }}">{{ $t->kota->nama }} - {{ $t->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Terminal Tujuan</label>
                    <select name="terminal_tujuan_id" required
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                        @foreach ($terminal as $t)
                            <option value="{{ $t->id }}">{{ $t->kota->nama }} - {{ $t->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Durasi Perjalanan (Menit)</label>
                    <input type="number" name="durasi_menit" value="360" min="30" required
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                </div>
                <button type="submit"
                    class="w-full rounded-xl bg-[#174E3F] py-2.5 text-xs font-bold text-white hover:bg-[#123d32] transition">
                    + Simpan Rute
                </button>
            </form>
        </div>

        <div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10 shadow-sm">
            <h2 class="text-sm font-bold text-[#174E3F] mb-3">3. Terbitkan Jadwal Bus</h2>
            <form method="POST" action="{{ route('admin.jadwal.store') }}" class="space-y-3 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Pilih Rute</label>
                    <select name="rute_id" required
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                        @foreach ($rute as $r)
                            <option value="{{ $r->id }}">
                                {{ $r->terminalAsal->kota->nama }} &rarr; {{ $r->terminalTujuan->kota->nama }}
                                ({{ $r->durasi_tampil }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-[#64756D] mb-1">Armada Bus</label>
                        <select name="bus_id" required
                            class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                            @foreach ($bus as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#64756D] mb-1">Jam Berangkat</label>
                        <input type="time" name="jam_berangkat" required
                            class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Harga Tiket (Rp)</label>
                    <input type="number" name="harga" value="250000" step="5000" min="10000" required
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2 text-xs">
                </div>
                <button type="submit"
                    class="w-full rounded-xl bg-[#174E3F] py-2.5 text-xs font-bold text-white hover:bg-[#123d32] transition">
                    + Terbitkan Jadwal
                </button>
            </form>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
        <h2 class="text-base font-bold text-[#253C34] mb-4">Daftar Jadwal Terdaftar ({{ $jadwal->count() }})</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#174E3F]/10 text-xs text-[#64756D]">
                    <tr>
                        <th class="py-3 pr-4">Rute</th>
                        <th class="py-3 pr-4">Armada</th>
                        <th class="py-3 pr-4">Jam & Durasi</th>
                        <th class="py-3 pr-4">Harga</th>
                        <th class="py-3 pr-4">Status</th>
                        <th class="py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#174E3F]/10">
                    @foreach ($jadwal as $j)
                        <tr>
                            <td class="py-3.5 pr-4">
                                <p class="font-bold text-[#253C34]">
                                    {{ $j->rute->terminalAsal->kota->nama }} &rarr;
                                    {{ $j->rute->terminalTujuan->kota->nama }}
                                </p>
                                <p class="text-xs text-[#64756D]">
                                    {{ $j->rute->terminalAsal->nama }} &rarr; {{ $j->rute->terminalTujuan->nama }}
                                </p>
                            </td>
                            <td class="py-3.5 pr-4">
                                <p class="font-semibold text-[#253C34]">{{ $j->bus->nama }}</p>
                                <p class="text-xs text-[#64756D]">{{ $j->bus->kelas }}</p>
                            </td>
                            <td class="py-3.5 pr-4">
                                <p class="font-bold text-[#174E3F]">{{ $j->jam_berangkat_tampil }} -
                                    {{ $j->jam_tiba }} WIB</p>
                                <p class="text-xs text-[#64756D]">{{ $j->rute->durasi_tampil }}</p>
                            </td>
                            <td class="py-3.5 pr-4 font-bold text-[#253C34]">
                                Rp{{ number_format($j->harga, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 pr-4">
                                <span
                                    class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $j->aktif ? 'bg-[#DDEAE3] text-[#174E3F]' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $j->aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-3.5 text-right space-x-2">
                                <form method="POST" action="{{ route('admin.jadwal.toggle', $j) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="rounded-lg border border-[#174E3F]/20 px-3 py-1.5 text-xs font-semibold text-[#174E3F] hover:bg-[#F6F9F7]">
                                        {{ $j->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.jadwal.destroy', $j) }}" class="inline"
                                    onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
