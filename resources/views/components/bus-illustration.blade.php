@props(['body' => '#174E3F', 'roda' => '#253C34'])

<svg {{ $attributes->merge(['class' => 'h-auto w-full']) }} viewBox="0 0 600 114" fill="none" aria-hidden="true">
    <path d="M22 0H578Q600 0 600 22V90H0V22Q0 0 22 0Z" fill="{{ $body }}" />
    @for ($i = 0; $i < 6; $i++)
        <rect x="{{ 24 + $i * 94 }}" y="14" width="82" height="38" rx="5" fill="#DDEAE3" />
    @endfor
    <rect x="0" y="64" width="600" height="26" fill="#DF603F" />
    <circle cx="95" cy="92" r="18" fill="{{ $roda }}" />
    <circle cx="95" cy="92" r="7" fill="#fff" />
    <circle cx="505" cy="92" r="18" fill="{{ $roda }}" />
    <circle cx="505" cy="92" r="7" fill="#fff" />
</svg>
