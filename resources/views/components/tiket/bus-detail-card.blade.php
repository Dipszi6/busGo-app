@props(['nama', 'kelas', 'fasilitas' => [], 'deskripsi' => null])

<section class="rounded-2xl bg-white p-6">
    <div class="flex items-center justify-between gap-3">
        <h2 class="text-xl font-bold text-[#253C34]">{{ $nama }}</h2>
        <span class="shrink-0 rounded-full bg-[#DDEAE3] px-4 py-1.5 text-xs font-bold uppercase text-[#174E3F]">
            {{ $kelas }} Class
        </span>
    </div>

    <div class="mt-5 flex items-center justify-center rounded-xl bg-[#DDEAE3] p-6 sm:p-10">
        <svg class="h-auto w-full max-w-xl" viewBox="0 0 600 114" fill="none" role="img"
            aria-label="Ilustrasi {{ $nama }}">
            <path d="M22 0H578Q600 0 600 22V90H0V22Q0 0 22 0Z" fill="#174E3F" />
            @for ($i = 0; $i < 6; $i++)
                <rect x="{{ 24 + $i * 94 }}" y="14" width="82" height="38" rx="5" fill="#DDEAE3" />
            @endfor
            <rect x="0" y="64" width="600" height="26" fill="#DF603F" />
            <circle cx="95" cy="92" r="18" fill="#253C34" />
            <circle cx="95" cy="92" r="7" fill="#fff" />
            <circle cx="505" cy="92" r="18" fill="#253C34" />
            <circle cx="505" cy="92" r="7" fill="#fff" />
        </svg>
    </div>

    <h3 class="mt-6 text-sm font-bold text-[#253C34]">Fasilitas Bus</h3>
    <div class="mt-3 flex flex-wrap gap-3">
        @foreach ($fasilitas as $item)
            <span class="rounded-lg bg-[#F6F2E9] px-4 py-2 text-xs text-[#52645C]">{{ $item }}</span>
        @endforeach
    </div>

    @if ($deskripsi)
        <p class="mt-5 border-t border-[#174E3F]/10 pt-4 text-xs text-[#64756D]">{{ $deskripsi }}</p>
    @endif
</section>
