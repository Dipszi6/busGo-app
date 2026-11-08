@props(['aktif' => 1])

@php
    $langkah = ['Pilih Kursi', 'Data Penumpang', 'Pembayaran', 'E-Tiket'];
@endphp

<nav aria-label="Langkah pemesanan" class="rounded-2xl bg-white px-4 py-4 sm:px-8">
    <ol class="flex items-center gap-3">
        @foreach ($langkah as $i => $nama)
            @php
                $no = $i + 1;
                $sudah = $no <= $aktif;
                $akhir = $no === count($langkah);
            @endphp
            <li class="flex items-center gap-2 {{ $akhir ? '' : 'flex-1' }}">
                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold {{ $sudah ? 'bg-[#174E3F] text-white' : 'bg-[#DDEAE3] text-[#52645C]' }}">
                    {{ $no }}
                </span>
                <span
                    class="text-sm {{ $no === $aktif ? 'font-bold text-[#174E3F]' : 'hidden text-[#64756D] sm:inline' }}">
                    {{ $nama }}
                </span>
                @unless ($akhir)
                    <span class="mx-2 hidden h-px flex-1 bg-[#174E3F]/30 sm:block"></span>
                @endunless
            </li>
        @endforeach
    </ol>
</nav>
