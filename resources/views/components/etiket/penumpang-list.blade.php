@props(['penumpang'])

<div class="py-6">
    <h2 class="text-xs font-bold uppercase tracking-wider text-[#64756D] mb-3">
        Daftar Penumpang ({{ $penumpang->count() }} Orang)
    </h2>

    <div class="overflow-hidden rounded-xl border border-[#174E3F]/10">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#F6F9F7] text-xs font-semibold text-[#64756D]">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Penumpang</th>
                    <th class="px-4 py-3">NIK</th>
                    <th class="px-4 py-3 text-right">Nomor Kursi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#174E3F]/10 bg-white">
                @foreach ($penumpang->sortBy('nomor_kursi')->values() as $index => $item)
                    <tr>
                        <td class="px-4 py-3 text-[#64756D]">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-[#253C34]">{{ $item->nama }}</p>
                            <p class="text-xs text-[#64756D]">
                                {{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull;
                                {{ $item->telepon }}
                            </p>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-[#253C34]">
                            {{ $item->nik }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <span
                                class="inline-flex items-center justify-center rounded-lg bg-[#174E3F] px-3 py-1 font-mono text-xs font-bold text-white">
                                Kursi {{ $item->nomor_kursi }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
