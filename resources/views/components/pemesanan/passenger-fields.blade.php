@props(['index', 'kursi', 'banyak' => false])

@php
    $p = "identitas.$index";
    $jk = old("$p.jenis_kelamin");
@endphp

<div class="{{ $index > 0 ? 'mt-8 border-t border-[#174E3F]/10 pt-6' : 'mt-6' }}">

    @if ($banyak)
        <h3 class="mb-4 text-sm font-bold text-[#174E3F]">
            Penumpang {{ $index + 1 }} &bull; Kursi {{ $kursi }}
        </h3>
    @endif

    <div class="space-y-5">
        <x-pemesanan.input :field="$p . '.nama'" label="Nama Lengkap" placeholder="Masukkan nama lengkap sesuai identitas" />

        <x-pemesanan.input :field="$p . '.nik'" label="Nomor Identitas (NIK)" placeholder="Masukkan nomor identitas"
            inputmode="numeric" maxlength="16" />

        <div class="grid gap-5 sm:grid-cols-2">
            <x-pemesanan.input :field="$p . '.telepon'" label="Nomor Telepon" type="tel" placeholder="Contoh: 081234567890"
                inputmode="tel" />
            <x-pemesanan.input :field="$p . '.email'" label="Alamat Email" type="email"
                placeholder="Masukkan alamat email" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2 sm:items-end">
            <div>
                <label for="identitas-{{ $index }}-jenis_kelamin"
                    class="block text-sm font-bold text-[#253C34]">Jenis Kelamin</label>
                <select id="identitas-{{ $index }}-jenis_kelamin"
                    name="identitas[{{ $index }}][jenis_kelamin]" required
                    class="mt-2 w-full rounded-xl border border-[#D7DFD9] bg-white px-5 py-3.5 text-sm text-[#253C34] focus:border-[#174E3F] focus:ring-[#174E3F]">
                    <option value="" disabled @selected(!$jk)>Pilih jenis kelamin</option>
                    <option value="L" @selected($jk === 'L')>Laki-laki</option>
                    <option value="P" @selected($jk === 'P')>Perempuan</option>
                </select>
                @error("$p.jenis_kelamin")
                    <p class="mt-1.5 text-xs text-[#DF603F]">{{ $message }}</p>
                @enderror
            </div>

            @if ($index === 0)
                <div class="rounded-xl bg-[#DDEAE3] p-4">
                    <p class="text-xs font-bold text-[#174E3F]">Informasi Penting</p>
                    <p class="mt-1 text-xs text-[#52645C]">Pastikan data penumpang sudah benar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
