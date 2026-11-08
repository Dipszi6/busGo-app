@props(['nama', 'deskripsi', 'warna' => 'hijau', 'label' => null, 'url' => '#'])

@php
    $bg = $warna === 'oranye' ? 'bg-[#F6E1D8]' : 'bg-[#DCE8E0]';
@endphp

<article
    class="flex flex-col overflow-hidden rounded-2xl border border-[#1B4D3E]/10 bg-white shadow-sm transition-shadow hover:shadow-md">
    <div class="flex h-44 w-full items-center justify-center {{ $bg }}">
        <svg class="h-16 w-24 text-[#1B4D3E]" viewBox="0 0 48 28" fill="none">
            <rect x="2" y="3" width="44" height="18" rx="5" fill="#fff" stroke="#1B4D3E"
                stroke-width="2" />
            <rect x="6" y="7" width="7" height="6" rx="1.5" fill="#1B4D3E" />
            <rect x="16" y="7" width="7" height="6" rx="1.5" fill="#1B4D3E" />
            <rect x="26" y="7" width="7" height="6" rx="1.5" fill="#1B4D3E" />
            <rect x="36" y="7" width="7" height="6" rx="1.5" fill="#1B4D3E" />
            <rect x="2" y="15" width="44" height="2" fill="#E2603F" />
            <circle cx="12" cy="22" r="3.5" fill="#1B4D3E" />
            <circle cx="36" cy="22" r="3.5" fill="#1B4D3E" />
        </svg>
    </div>

    <div class="flex flex-1 flex-col justify-between p-5">
        <div>
            @if ($label)
                <span
                    class="mb-3 inline-block rounded-full bg-gray-200/80 px-3 py-1 text-xs font-semibold text-[#1B4D3E]">
                    {{ $label }}
                </span>
            @endif

            <h3 class="text-xl font-bold tracking-tight text-gray-900">{{ $nama }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-[#1B4D3E]/70">{{ $deskripsi }}</p>
        </div>

        <a href="{{ $url }}"
            class="mt-6 flex w-full items-center justify-center rounded-xl bg-[#E2603F] py-3 text-center text-sm font-semibold text-white transition-colors hover:bg-[#d05232]">
            Lihat detail &rarr;
        </a>
    </div>
</article>
