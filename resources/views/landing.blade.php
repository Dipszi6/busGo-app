<x-layouts.public>

    <x-landing.hero />
    <x-landing.features />

    <div class="mx-auto max-w-6xl px-4 sm:px-8">

        <x-landing.search-form :action="route('tiket.cari')" :kota="$kota" />
        <section id="armada" class="py-10">
            <h2 class="text-xl font-bold">Kenali Armada Kami</h2>
            <p class="mt-1 text-xs text-[#1B4D3E]/60">Pilihan armada terbaik untuk menemani perjalanan Anda.</p>

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach ($armada as $item)
                    <x-landing.fleet-card
                        :nama="$item['nama']"
                        :deskripsi="$item['deskripsi']"
                        :warna="$item['warna']" />
                @endforeach
            </div>
        </section>

    </div>

</x-layouts.public>