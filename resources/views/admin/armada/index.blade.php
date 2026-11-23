<x-layouts.admin title="Kelola Armada Bus">
    @php
        $opsiFasilitas = [
            'AC',
            'WiFi Gratis',
            'Reclining Seat',
            'Bed Seat',
            'USB Charger',
            'Bagasi',
            'Toilet',
            'Selimut & Bantal',
        ];
    @endphp

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm h-fit">
            <h2 class="text-base font-bold text-[#253C34] mb-4">Tambah Armada Baru</h2>

            <form method="POST" action="{{ route('admin.armada.store') }}" class="space-y-4 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Nama Armada</label>
                    <input type="text" name="nama" required placeholder="Contoh: Nusantara Executive 02"
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3.5 py-2.5 text-sm focus:border-[#174E3F] focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-[#64756D] mb-1">Kelas</label>
                        <select name="kelas" class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2.5 text-sm">
                            <option value="Executive">Executive</option>
                            <option value="Sleeper">Sleeper</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#64756D] mb-1">Denah Kursi</label>
                        <select name="denah" class="w-full rounded-xl border border-[#174E3F]/20 px-3 py-2.5 text-sm">
                            <option value="2-2">2-2 (Standard)</option>
                            <option value="1-1">1-1 (Sleeper)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Kapasitas Kursi</label>
                    <input type="number" name="kapasitas" value="28" min="10" max="60" required
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3.5 py-2.5 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1.5">Fasilitas</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($opsiFasilitas as $fas)
                            <label class="flex items-center gap-2 text-xs text-[#253C34]">
                                <input type="checkbox" name="fasilitas[]" value="{{ $fas }}"
                                    class="rounded border-[#174E3F]/30 text-[#174E3F] focus:ring-[#174E3F]">
                                <span>{{ $fas }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#64756D] mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="2" placeholder="Keterangan kenyamanan bus..."
                        class="w-full rounded-xl border border-[#174E3F]/20 px-3.5 py-2 text-sm"></textarea>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-[#174E3F] py-3 text-sm font-bold text-white hover:bg-[#123d32] transition">
                    Simpan Armada
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-4">
            @foreach ($armada as $bus)
                <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h3 class="text-base font-bold text-[#253C34]">{{ $bus->nama }}</h3>
                                <span
                                    class="rounded-full bg-[#DDEAE3] px-2.5 py-0.5 text-xs font-semibold text-[#174E3F]">
                                    {{ $bus->kelas }}
                                </span>
                                <span
                                    class="rounded-full bg-[#F6F9F7] px-2.5 py-0.5 text-xs font-semibold text-[#64756D]">
                                    Denah {{ $bus->denah }} &bull; {{ $bus->kapasitas }} Kursi
                                </span>
                            </div>
                            <p class="mt-1.5 text-xs text-[#64756D]">{{ $bus->deskripsi ?? '-' }}</p>

                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($bus->fasilitas ?? [] as $f)
                                    <span
                                        class="rounded-md bg-[#F7F2E8] px-2.5 py-1 text-[11px] font-medium text-[#253C34]">
                                        {{ $f }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.armada.destroy', $bus) }}"
                            onsubmit="return confirm('Yakin ingin menghapus armada {{ $bus->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-xl border border-red-200 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.admin>
