@props(['pencarian' => [], 'filter' => []])

@php
    $waktuDipilih = $filter['waktu'] ?? [];
    $kelasDipilih = $filter['kelas'] ?? [];
    $urutDipilih = $filter['urut'] ?? null;

    $opsiWaktu = [
        'pagi'  => 'Pagi (06.00 - 11.00)',
        'siang' => 'Siang (11.00 - 15.00)',
        'sore'  => 'Sore (15.00 - 18.00)',
        'malam' => 'Malam (18.00 - 06.00)',
    ];
@endphp

<aside class="h-fit rounded-2xl bg-white p-5 shadow-sm border border-[#174E3F]/10">
    <form action="{{ route('tiket.cari') }}" method="GET" onchange="this.submit()">

        @foreach ($pencarian as $nama => $nilai)
            <input type="hidden" name="{{ $nama }}" value="{{ $nilai }}">
        @endforeach

        <h2 class="text-lg font-bold text-[#253C34]">Filter Pencarian</h2>

        <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
            <h3 class="text-sm font-bold text-[#253C34]">Waktu Keberangkatan</h3>
            <div class="mt-3 space-y-2 text-sm text-[#52645C]">
                @foreach ($opsiWaktu as $nilai => $label)
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="waktu[]" value="{{ $nilai }}" @checked(in_array($nilai, $waktuDipilih))
                            class="rounded border-[#174E3F]/40 text-[#174E3F] focus:ring-[#174E3F]">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
            <h3 class="text-sm font-bold text-[#253C34]">Kelas Bus</h3>
            <div class="mt-3 space-y-2 text-sm text-[#52645C]">
                @foreach (['Executive', 'Sleeper'] as $kelas)
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="kelas[]" value="{{ $kelas }}" @checked(in_array($kelas, $kelasDipilih))
                            class="rounded border-[#174E3F]/40 text-[#174E3F] focus:ring-[#174E3F]">
                        {{ $kelas }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mt-4 border-t border-[#174E3F]/10 pt-4">
            <h3 class="text-sm font-bold text-[#253C34]">Urutkan Harga</h3>
            <div class="mt-3 space-y-2 text-sm text-[#52645C]">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="radio" name="urut" value="termurah" @checked($urutDipilih === 'termurah')
                        class="border-[#174E3F]/40 text-[#174E3F] focus:ring-[#174E3F]">
                    Harga terendah
                </label>
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="radio" name="urut" value="termahal" @checked($urutDipilih === 'termahal')
                        class="border-[#174E3F]/40 text-[#174E3F] focus:ring-[#174E3F]">
                    Harga tertinggi
                </label>
            </div>
        </div>
    </form>
</aside>