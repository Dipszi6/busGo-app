@props(['berangkat', 'tiba', 'terminalAsal', 'terminalTujuan', 'durasi'])

<section class="rounded-2xl bg-white p-6">
    <h2 class="text-lg font-bold text-[#253C34]">Jadwal Perjalanan</h2>

    <div class="mt-5 grid items-start gap-4 sm:grid-cols-[1fr_auto_1fr] sm:gap-6">
        <div class="flex gap-3">
            <span class="mt-1.5 h-3.5 w-3.5 shrink-0 rounded-full bg-[#174E3F]"></span>
            <div>
                <p class="font-bold text-[#253C34]">{{ $berangkat }} WIB</p>
                <p class="mt-0.5 text-xs text-[#64756D]">{{ $terminalAsal }}</p>
            </div>
        </div>

        <div class="hidden w-32 pt-1 text-center text-xs text-[#64756D] sm:block">
            <span>{{ $durasi }}</span>
            <div class="mt-1 border-t border-[#64756D]/50"></div>
        </div>
        <p class="text-xs text-[#64756D] sm:hidden">Durasi perjalanan {{ $durasi }}</p>

        <div class="flex gap-3">
            <span class="mt-1.5 h-3.5 w-3.5 shrink-0 rounded-full bg-[#DF603F]"></span>
            <div>
                <p class="font-bold text-[#253C34]">{{ $tiba }} WIB</p>
                <p class="mt-0.5 text-xs text-[#64756D]">{{ $terminalTujuan }}</p>
            </div>
        </div>
    </div>
</section>
