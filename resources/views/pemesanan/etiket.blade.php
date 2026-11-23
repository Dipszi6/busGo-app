<x-layouts.public title="E-Tiket {{ $pemesanan->kode }}">
    <style>
        @media print {

            nav,
            footer,
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }

            .print-area {
                box-shadow: none !important;
                border: 1px solid #d1d5db !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>

    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        <div class="no-print mb-6 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('pemesanan.sukses', $pemesanan->kode) }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#174E3F] hover:underline">
                &larr; Kembali ke Detail Pemesanan
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('pemesanan.etiket.pdf', $pemesanan->kode) }}"
                    class="rounded-xl border-2 border-[#174E3F] px-4 py-2.5 text-sm font-bold text-[#174E3F] hover:bg-[#174E3F] hover:text-white transition">
                    Unduh PDF
                </a>
                <button type="button" onclick="window.print()"
                    class="rounded-xl bg-[#174E3F] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#123d32] transition">
                    Cetak E-Tiket
                </button>
            </div>
        </div>

        <div class="print-area rounded-2xl bg-white p-6 shadow-sm border border-[#174E3F]/10 sm:p-8">
            <x-etiket.header :pemesanan="$pemesanan" />

            <x-etiket.rute-info :pemesanan="$pemesanan" />

            <x-etiket.penumpang-list :penumpang="$pemesanan->penumpang" />

            <div
                class="mt-2 flex flex-col justify-between gap-4 rounded-xl bg-[#DDEAE3]/50 p-4 sm:flex-row sm:items-center">
                <div class="text-xs text-[#253C34] space-y-1">
                    <p class="font-bold text-[#174E3F]">Ketentuan Check-in:</p>
                    <p>1. Harap tiba di terminal keberangkatan minimal 30 menit sebelum jadwal.</p>
                    <p>2. Tunjukkan E-Tiket ini beserta kartu identitas (KTP/SIM) asli kepada petugas.</p>
                </div>

                <div class="sm:text-right shrink-0">
                    <p class="text-xs text-[#64756D]">Total Dibayar</p>
                    <p class="text-xl font-bold text-[#174E3F]">
                        Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
