@props(['field', 'label', 'type' => 'text', 'placeholder' => null, 'inputmode' => null, 'maxlength' => null])

@php
    $nama = preg_replace('/\.([^.]+)/', '[$1]', $field);
    $id = str_replace('.', '-', $field);
@endphp

<div>
    <label for="{{ $id }}" class="block text-sm font-bold text-[#253C34]">{{ $label }}</label>
    <input id="{{ $id }}" name="{{ $nama }}" type="{{ $type }}" value="{{ old($field) }}"
        placeholder="{{ $placeholder }}" required
        @if ($inputmode) inputmode="{{ $inputmode }}" @endif
        @if ($maxlength) maxlength="{{ $maxlength }}" @endif
        class="mt-2 w-full rounded-xl border border-[#D7DFD9] bg-white px-5 py-3.5 text-sm text-[#253C34] placeholder:text-[#9AA69F] focus:border-[#174E3F] focus:ring-[#174E3F]">
    @error($field)
        <p class="mt-1.5 text-xs text-[#DF603F]">{{ $message }}</p>
    @enderror
</div>
