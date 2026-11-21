@props([
    'action' => '#',
    'asal' => null,
    'tujuan' => null,
    'tanggal' => null,
    'penumpang' => 1,
    'kota' => [],
])

@php
    $nilaiAsal = old('asal', $asal);
    $nilaiTujuan = old('tujuan', $tujuan);
    $nilaiTanggal = old('tanggal', $tanggal);
    $nilaiPenumpang = (int) old('penumpang', $penumpang);
@endphp

<section id="cari" class="rounded-2xl bg-[#174E3F] p-6 text-white sm:p-8">
    <h2 class="text-xl font-bold">Cari Perjalanan Anda</h2>
    <p class="mt-1 text-xs text-white/70">Tentukan tujuan dan tanggal keberangkatan untuk memulai perjalanan.</p>

    @if ($errors->any())
        <div class="mt-4 rounded-lg bg-white/10 p-3 text-xs text-[#F0B94A]">
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="GET"
        class="mt-5 grid gap-4 md:grid-cols-[1fr_1fr_1fr_0.8fr_auto] md:items-end">
        <div>
            <label for="asal" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">KOTA ASAL</label>
            <select id="asal" name="asal" required
                class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#174E3F]">
                <option value="" disabled @selected(!$nilaiAsal)>Pilih kota asal</option>
                @foreach ($kota as $nama)
                    <option value="{{ $nama }}" @selected($nilaiAsal === $nama)>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tujuan" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">KOTA TUJUAN</label>
            <select id="tujuan" name="tujuan" required
                class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#174E3F]">
                <option value="" disabled @selected(!$nilaiTujuan)>Pilih kota tujuan</option>
                @foreach ($kota as $nama)
                    <option value="{{ $nama }}" @selected($nilaiTujuan === $nama)>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tanggal" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">TANGGAL BERANGKAT</label>
            <input id="tanggal" name="tanggal" type="date" required min="{{ now()->toDateString() }}"
                value="{{ $nilaiTanggal }}"
                class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#174E3F]">
        </div>
        <div>
            <label for="penumpang" class="mb-1 block text-[11px] font-bold text-[#F0B94A]">PENUMPANG</label>
            <select id="penumpang" name="penumpang"
                class="w-full rounded-lg border-0 bg-white px-3 py-3 text-sm text-[#174E3F]">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" @selected($nilaiPenumpang === $i)>{{ $i }} Penumpang
                    </option>
                @endfor
            </select>
        </div>
        <button type="submit"
            class="rounded-lg bg-[#DF603F] px-6 py-3 text-sm font-bold text-white hover:bg-[#cb5436]">
            CARI TIKET
        </button>
    </form>
</section>
