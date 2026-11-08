@props([
    'nama',
    'kelas',
    'fasilitas' => [],
    'berangkat',
    'tiba',
    'asal',
    'tujuan',
    'durasi',
    'harga',
    'href' => '#',
])

<article class="flex flex-col gap-5 rounded-2xl bg-white p-5 md:flex-row md:items-center md:gap-6">

    <div class="flex h-24 w-full shrink-0 items-center justify-center rounded-xl bg-[#DDEAE3] md:w-36">
        <svg class="h-14 w-24" viewBox="0 0 126 70" fill="none">
            <rect x="0" y="0" width="126" height="56" rx="10" fill="#174E3F" />
            <rect x="13" y="12" width="30" height="16" rx="3" fill="#DDEAE3" />
            <rect x="48" y="12" width="30" height="16" rx="3" fill="#DDEAE3" />
            <rect x="83" y="12" width="30" height="16" rx="3" fill="#DDEAE3" />
            <circle cx="24" cy="58" r="8" fill="#253C34" />
            <circle cx="102" cy="58" r="8" fill="#253C34" />
        </svg>
    </div>

    <div class="min-w-0 flex-1">
        <h3 class="text-lg font-bold text-[#253C34]">{{ $nama }}</h3>
        <p class="mt-1 text-xs text-[#64756D]">
            {{ $kelas }}@foreach ($fasilitas as $f)
                &bull; {{ $f }}
            @endforeach
        </p>

        <div class="mt-3 flex items-center gap-3">
            <div>
                <p class="text-lg font-bold text-[#253C34]">{{ $berangkat }}</p>
                <p class="text-xs text-[#64756D]">{{ $asal }}</p>
            </div>

            <div class="min-w-[4rem] max-w-[10rem] flex-1 text-center text-xs text-[#64756D]">
                <span>{{ $durasi }}</span>
                <div class="mt-1 border-t border-[#64756D]/50"></div>
            </div>

            <div>
                <p class="text-lg font-bold text-[#253C34]">{{ $tiba }}</p>
                <p class="text-xs text-[#64756D]">{{ $tujuan }}</p>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between gap-4 md:w-40 md:flex-col md:items-stretch md:justify-center">
        <div>
            <p class="text-xs text-[#64756D]">Mulai dari</p>
            <p class="text-xl font-bold text-[#DF603F]">Rp{{ number_format($harga, 0, ',', '.') }}</p>
        </div>
        <a href="{{ $href }}"
            class="rounded-lg bg-[#174E3F] px-5 py-2.5 text-center text-sm font-bold text-white hover:bg-[#123d32]">
            Pilih Bus
        </a>
    </div>
</article>
