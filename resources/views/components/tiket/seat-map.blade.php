@props(['nama', 'denah' => '2-2', 'kapasitas' => 28, 'terisi' => []])

@php
    $grup = array_map('intval', explode('-', $denah));
    $perBaris = array_sum($grup);
    $baris = (int) ceil($kapasitas / $perBaris);
    $no = 0;
@endphp

<section class="rounded-2xl bg-white p-6">
    <h2 class="text-xl font-bold text-[#253C34]">Denah Kursi Bus</h2>
    <p class="mt-1 text-xs text-[#64756D]">{{ $nama }} &bull; Kapasitas {{ $kapasitas }} Kursi</p>

    <div class="mt-4 flex flex-wrap gap-5 text-xs text-[#52645C]">
        <span class="flex items-center gap-2"><span class="h-4 w-4 rounded bg-[#DDEAE3]"></span>Tersedia</span>
        <span class="flex items-center gap-2"><span class="h-4 w-4 rounded bg-[#DF603F]"></span>Dipilih</span>
        <span class="flex items-center gap-2"><span class="h-4 w-4 rounded bg-[#AEB8B2]"></span>Terisi</span>
    </div>

    <div class="mx-auto mt-6 max-w-md rounded-[2rem] border-2 border-[#AABBB1] bg-[#F8FAF7] p-4 sm:p-6">

        <div class="flex justify-between">
            <div
                class="flex h-12 w-20 items-center justify-center rounded-lg border-2 border-dashed border-[#174E3F]/40 text-xs text-[#174E3F]/70 sm:w-24">
                Pintu</div>
            <div class="flex h-12 w-20 items-center justify-center rounded-lg bg-[#AEB8B2] text-xs text-white sm:w-24">
                Sopir</div>
        </div>

        <div class="mt-6 space-y-3">
            @for ($r = 0; $r < $baris; $r++)
                <div class="flex justify-center gap-6 sm:gap-12">
                    @foreach ($grup as $jumlah)
                        <div class="flex gap-2">
                            @for ($i = 0; $i < $jumlah; $i++)
                                @php $no++; @endphp

                                @if ($no > $kapasitas)
                                    <div class="h-10 w-12 sm:h-11 sm:w-16"></div>
                                @else
                                    @php $label = sprintf('%02d', $no); @endphp

                                    @if (in_array($label, $terisi))
                                        <div aria-label="Kursi {{ $label }} terisi"
                                            class="flex h-10 w-12 items-center justify-center rounded-lg bg-[#AEB8B2] text-xs font-bold text-white sm:h-11 sm:w-16">
                                            {{ $label }}
                                        </div>
                                    @else
                                        <button type="button" @click="toggle('{{ $label }}')"
                                            :class="dipilih.includes('{{ $label }}') ? 'bg-[#DF603F] text-white' :
                                                'bg-[#DDEAE3] text-[#174E3F] hover:bg-[#c9ddd2]'"
                                            :aria-pressed="dipilih.includes('{{ $label }}')"
                                            aria-label="Kursi {{ $label }}"
                                            class="h-10 w-12 rounded-lg text-xs font-bold transition sm:h-11 sm:w-16">
                                            {{ $label }}
                                        </button>
                                    @endif
                                @endif
                            @endfor
                        </div>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>
</section>
