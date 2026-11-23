@props(['statistik'])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10">
        <p class="text-xs font-medium text-[#64756D]">Tiket Aktif (Lunas)</p>
        <p class="mt-2 text-2xl font-bold text-[#174E3F]">{{ $statistik['aktif'] }}</p>
        <p class="mt-1 text-[11px] text-[#64756D]">Siap digunakan berangkat</p>
    </div>

    <div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10">
        <p class="text-xs font-medium text-[#64756D]">Menunggu Pembayaran</p>
        <p class="mt-2 text-2xl font-bold text-[#DF603F]">{{ $statistik['menunggu'] }}</p>
        <p class="mt-1 text-[11px] text-[#64756D]">Segera selesaikan transaksi</p>
    </div>

    <div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10">
        <p class="text-xs font-medium text-[#64756D]">Total Perjalanan</p>
        <p class="mt-2 text-2xl font-bold text-[#253C34]">{{ $statistik['total'] }}</p>
        <p class="mt-1 text-[11px] text-[#64756D]">Semua riwayat pemesanan</p>
    </div>
</div>
