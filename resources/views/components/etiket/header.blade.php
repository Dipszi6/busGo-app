@props(['pemesanan'])

<div
    class="flex flex-col justify-between gap-4 border-b border-dashed border-[#174E3F]/20 pb-6 sm:flex-row sm:items-center">
    <div>
        <div class="flex items-center gap-2">
            <span
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-[#174E3F] text-sm font-bold text-white">
                BG
            </span>
            <span class="text-lg font-bold tracking-tight text-[#253C34]">BusGo</span>
            <span class="rounded-md bg-[#DDEAE3] px-2 py-0.5 text-[11px] font-semibold text-[#174E3F]">
                E-TIKET RESMI
            </span>
        </div>
        <p class="mt-2 text-xs text-[#64756D]">
            Diterbitkan pada
            {{ ($pemesanan->dibayar_pada ?? $pemesanan->updated_at)->locale('id')->translatedFormat('d F Y, H:i') }} WIB
        </p>
    </div>

    <div class="sm:text-right">
        <p class="text-[11px] font-medium uppercase tracking-wider text-[#64756D]">Kode Pemesanan</p>
        <p class="mt-0.5 font-mono text-2xl font-bold tracking-widest text-[#174E3F]">
            {{ $pemesanan->kode }}
        </p>
        <span
            class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-[#DDEAE3] px-3 py-0.5 text-xs font-semibold text-[#174E3F]">
            <span class="h-1.5 w-1.5 rounded-full bg-[#174E3F]"></span>
            LUNAS
        </span>
    </div>
</div>
