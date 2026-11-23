@props(['status'])

@php
    [$class, $label] = match ($status) {
        'lunas' => ['bg-[#DDEAE3] text-[#174E3F]', 'Lunas'],
        'menunggu_pembayaran' => ['bg-amber-100 text-amber-700', 'Menunggu Bayar'],
        'gagal' => ['bg-red-100 text-red-700', 'Gagal'],
        default => ['bg-gray-100 text-gray-700', ucfirst($status)],
    };
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $class }}">
    {{ $label }}
</span>
