<x-layouts.public title="Riwayat Pemesanan">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-[#253C34]">Riwayat Pemesanan</h1>
            <p class="mt-1 text-sm text-[#64756D]">
                Semua transaksi tiket bus yang pernah kamu buat.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <x-dashboard.sidebar />
            </div>

            <div class="lg:col-span-3 space-y-6">
                <div
                    class="flex flex-col justify-between gap-4 rounded-2xl bg-white p-4 border border-[#174E3F]/10 sm:flex-row sm:items-center">
                    <div class="flex flex-wrap gap-2">
                        @foreach ([
        'semua' => 'Semua',
        'lunas' => 'Lunas',
        'menunggu_pembayaran' => 'Menunggu Bayar',
        'gagal' => 'Gagal',
    ] as $key => $label)
                            <a href="{{ route('riwayat.index', ['status' => $key, 'q' => $cari]) }}"
                                class="rounded-xl px-3.5 py-2 text-xs font-semibold transition {{ $status === $key ? 'bg-[#174E3F] text-white' : 'bg-[#F6F9F7] text-[#64756D] hover:text-[#253C34]' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('riwayat.index') }}" class="flex gap-2">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="text" name="q" value="{{ $cari }}" placeholder="Cari kode BG..."
                            class="w-full sm:w-48 rounded-xl border border-[#174E3F]/20 px-3.5 py-2 text-xs text-[#253C34] focus:border-[#174E3F] focus:outline-none">
                        <button type="submit"
                            class="rounded-xl bg-[#174E3F] px-4 py-2 text-xs font-bold text-white hover:bg-[#123d32] transition">
                            Cari
                        </button>
                    </form>
                </div>

                @if ($pemesanan->isEmpty())
                    <div class="rounded-2xl bg-white p-10 text-center border border-[#174E3F]/10">
                        <p class="font-bold text-[#253C34]">Tidak ada riwayat ditemukan</p>
                        <p class="mt-1 text-xs text-[#64756D]">Coba ubah filter status atau kata kunci pencarianmu.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($pemesanan as $item)
                            <x-dashboard.booking-card :item="$item" />
                        @endforeach
                    </div>

                    <div class="pt-2">
                        {{ $pemesanan->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.public>
