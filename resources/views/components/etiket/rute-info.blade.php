@props(['pemesanan'])

@php
    $jadwal = $pemesanan->jadwal;
    $rute = $jadwal->rute;
    $bus = $jadwal->bus;
@endphp

<div class="py-6 border-b border-dashed border-[#174E3F]/20">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl bg-[#F6F9F7] px-4 py-3">
        <div>
            <p class="text-xs text-[#64756D]">Armada & Kelas</p>
            <p class="text-sm font-bold text-[#253C34]">
                {{ $bus->nama }}
                <span
                    class="ml-1.5 rounded-md bg-white px-2 py-0.5 text-xs font-semibold text-[#174E3F] border border-[#174E3F]/15">
                    {{ $bus->kelas }}
                </span>
            </p>
        </div>
        <div class="sm:text-right">
            <p class="text-xs text-[#64756D]">Tanggal Keberangkatan</p>
            <p class="text-sm font-bold text-[#253C34]">
                {{ $pemesanan->tanggal_berangkat->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 items-center gap-4 sm:grid-cols-3">
        <div>
            <p class="text-2xl font-bold text-[#253C34]">{{ $jadwal->jam_berangkat_tampil }} <span
                    class="text-xs font-normal text-[#64756D]">WIB</span></p>
            <p class="mt-1 text-sm font-bold text-[#174E3F]">{{ $rute->terminalAsal->kota->nama }}</p>
            <p class="text-xs text-[#64756D]">{{ $rute->terminalAsal->nama }}</p>
        </div>

        <div class="flex flex-col items-center justify-center text-center">
            <span class="rounded-full bg-[#DDEAE3] px-3 py-1 text-xs font-semibold text-[#174E3F]">
                {{ $rute->durasi_tampil }}
            </span>
            <div class="my-2 flex w-full items-center gap-2">
                <span class="h-2 w-2 rounded-full border-2 border-[#174E3F]"></span>
                <div class="h-[1.5px] flex-1 border-t border-dashed border-[#174E3F]/40"></div>
                <span class="h-2 w-2 rounded-full bg-[#174E3F]"></span>
            </div>
            <p class="text-[11px] text-[#64756D]">Estimasi Perjalanan</p>
        </div>

        <div class="sm:text-right">
            <p class="text-2xl font-bold text-[#253C34]">{{ $jadwal->jam_tiba }} <span
                    class="text-xs font-normal text-[#64756D]">WIB</span></p>
            <p class="mt-1 text-sm font-bold text-[#174E3F]">{{ $rute->terminalTujuan->kota->nama }}</p>
            <p class="text-xs text-[#64756D]">{{ $rute->terminalTujuan->nama }}</p>
        </div>
    </div>
</div>
