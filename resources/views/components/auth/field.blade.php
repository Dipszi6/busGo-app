@props(['name', 'label', 'type' => 'text', 'placeholder' => null, 'autocomplete' => null])

<div x-data="{ lihat: false }">
    <label for="{{ $name }}" class="block text-sm font-bold text-[#253C34]">{{ $label }}</label>

    <div class="relative mt-2">
        <input id="{{ $name }}" name="{{ $name }}"
            @if ($type === 'password') :type="lihat ? 'text' : 'password'"
               @else
                   type="{{ $type }}" value="{{ old($name) }}" @endif
            placeholder="{{ $placeholder }}" @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            {{ $attributes->merge(['class' => 'w-full rounded-xl border border-[#D7DFD9] bg-white px-5 py-3.5 text-sm text-[#253C34] placeholder:text-[#9AA69F] focus:border-[#174E3F] focus:ring-[#174E3F] ' . ($type === 'password' ? 'pr-12' : '')]) }}>

        @if ($type === 'password')
            <button type="button" @click="lihat = !lihat"
                class="absolute inset-y-0 right-4 flex items-center text-[#64756D] hover:text-[#174E3F]"
                aria-label="Tampilkan atau sembunyikan kata sandi">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </button>
        @endif
    </div>

    @error($name)
        <p class="mt-1.5 text-xs text-[#DF603F]">{{ $message }}</p>
    @enderror
</div>
