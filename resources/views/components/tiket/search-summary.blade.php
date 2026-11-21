@props(['asal', 'tujuan', 'tanggal', 'tanggalRaw', 'penumpang', 'kota' => []])

<div x-data="{ ubah: @js($errors->any()) }">

    {{-- Ringkasan --}}
    <section x-show="!ubah" class="rounded-2xl bg-[#174E3F] p-5 text-white sm:p-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1fr_1fr_auto] lg:items-center">
            <div>
                <p class="text-xs text-white/70">Kota Asal</p>
                <p class="mt-1 text-lg font-bold">{{ $asal }}</p>
            </div>
            <div>
                <p class="text-xs text-white/70">Kota Tujuan</p>
                <p class="mt-1 text-lg font-bold">{{ $tujuan }}</p>
            </div>
            <div>
                <p class="text-xs text-white/70">Tanggal Berangkat</p>
                <p class="mt-1 text-lg font-bold">{{ $tanggal }}</p>
            </div>
            <div>
                <p class="text-xs text-white/70">Penumpang</p>
                <p class="mt-1 text-lg font-bold">{{ $penumpang }} Orang</p>
            </div>
            <button type="button" @click="ubah = true"
                    class="rounded-lg bg-[#DF603F] px-6 py-3 text-center text-sm font-bold text-white hover:bg-[#cb5436]">
                Ubah Pencarian
            </button>
        </div>
    </section>

    {{-- Form ubah pencarian --}}
    <div x-show="ubah" style="display: none;">
        <x-landing.search-form
            :action="route('tiket.cari')"
            :asal="$asal"
            :tujuan="$tujuan"
            :tanggal="$tanggalRaw"
            :penumpang="$penumpang" />

        <button type="button" @click="ubah = false"
                class="mt-3 text-xs font-semibold text-[#174E3F] hover:underline">
            Batal
        </button>
    </div>
</div>