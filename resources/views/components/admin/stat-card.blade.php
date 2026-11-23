@props(['title', 'value', 'subtitle' => null, 'accent' => 'green'])

@php
    $valueColor = match ($accent) {
        'orange' => 'text-[#DF603F]',
        'dark' => 'text-[#253C34]',
        default => 'text-[#174E3F]',
    };
@endphp

<div class="rounded-2xl bg-white p-5 border border-[#174E3F]/10 shadow-sm">
    <p class="text-xs font-semibold text-[#64756D]">{{ $title }}</p>
    <p class="mt-2 text-2xl font-bold {{ $valueColor }}">{{ $value }}</p>
    @if ($subtitle)
        <p class="mt-1 text-[11px] text-[#64756D]">{{ $subtitle }}</p>
    @endif
</div>
