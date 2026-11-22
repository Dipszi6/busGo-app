<x-layouts.public title="Pembayaran">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-8 text-center">

        <div class="flex justify-center">
            <span class="flex h-20 w-20 items-center justify-center rounded-full bg-[#DDEAE3]">
                <svg class="h-10 w-10 text-[#174E3F]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                    <line x1="1" y1="10" x2="23" y2="10" />
                </svg>
            </span>
        </div>

        <h1 class="mt-6 text-2xl font-bold text-[#253C34]">Selesaikan Pembayaran</h1>
        <p class="mt-2 text-sm text-[#64756D]">
            Klik tombol di bawah untuk membuka halaman pembayaran Midtrans.
        </p>

        <div class="mt-8 rounded-2xl bg-white p-6 text-left">
            <p class="text-xs text-[#64756D]">Kode Pemesanan</p>
            <p class="mt-1 text-2xl font-bold tracking-widest text-[#174E3F]">{{ $pemesanan->kode }}</p>

            <dl class="mt-6 space-y-3 text-sm">
                @foreach ([
        'Bus' => $pemesanan->jadwal->bus->nama,
        'Rute' => $pemesanan->jadwal->rute->terminalAsal->kota->nama . ' → ' . $pemesanan->jadwal->rute->terminalTujuan->kota->nama,
        'Tanggal' => $pemesanan->tanggal_berangkat->locale('id')->translatedFormat('d F Y'),
        'Kursi' => $pemesanan->penumpang->pluck('nomor_kursi')->sort()->implode(', '),
        'Total' => 'Rp' . number_format($pemesanan->total_harga, 0, ',', '.'),
    ] as $label => $nilai)
                    <div class="flex justify-between gap-4 border-b border-[#174E3F]/10 pb-3 last:border-0">
                        <dt class="text-[#64756D]">{{ $label }}</dt>
                        <dd class="font-semibold text-[#253C34] text-right">{{ $nilai }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <button id="pay-button"
            class="mt-6 w-full rounded-xl bg-[#DF603F] py-4 text-sm font-bold text-white transition hover:bg-[#cb5436]">
            Bayar Sekarang — Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}
        </button>

        <p class="mt-3 text-xs text-[#64756D]">
            Pembayaran diproses oleh Midtrans. Data kamu aman dan terenkripsi.
        </p>
    </div>

    {{-- Midtrans Snap --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $pemesanan->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route('pembayaran.selesai', $pemesanan->kode) }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route('pemesanan.sukses', $pemesanan->kode) }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                }
            });
        });
    </script>
</x-layouts.public>
