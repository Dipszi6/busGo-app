@props([
    'action'    => '#',
    'asal'      => null,
    'tujuan'    => null,
    'tanggal'   => null,
    'penumpang' => 1,
])

<section id="cari" class="rounded-2xl bg-[#1B4D3E] p-6 text-white sm:p-8">
    <h2 class="text-xl font-bold">Cari Perjalanan Anda</h2>
    <p class="mt-1 text-xs text-white/70">Tentukan tujuan dan tanggal keberangkatan untuk memulai perjalanan.</p>

    <form action="{{ $action }}" method="GET" class="mt-5 grid gap-4 md:grid-cols-[1fr_1fr_1fr_0.8fr_auto] md:items-end">
        <div>
            <label for="asal" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">KOTA ASAL</label>
            <input id="asal" name="asal" type="text" required value="{{ $asal }}" placeholder="Pilih kota asal"
                   class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#1B4D3E] placeholder:text-[#1B4D3E]/50">
        </div>
        <div>
            <label for="tujuan" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">KOTA TUJUAN</label>
            <input id="tujuan" name="tujuan" type="text" required value="{{ $tujuan }}" placeholder="Pilih kota tujuan"
                   class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#1B4D3E] placeholder:text-[#1B4D3E]/50">
        </div>
        <div>
            <label for="tanggal" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">TANGGAL BERANGKAT</label>
            <input id="tanggal" name="tanggal" type="date" required value="{{ $tanggal }}"
                   class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#1B4D3E]">
        </div>
        <div>
            <label for="penumpang" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">PENUMPANG</label>
            <select id="penumpang" name="penumpang"
                    class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#1B4D3E]">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" @selected((int) $penumpang === $i)>{{ $i }} Penumpang</option>
                @endfor
            </select>
        </div>
        <button type="submit"
                class="rounded-lg bg-[#E2603F] px-6 py-3 text-sm font-bold text-white hover:bg-[#cf5434]">
            CARI TIKET
        </button>
    </form>
</section>