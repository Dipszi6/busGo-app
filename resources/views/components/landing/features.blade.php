@props([
    'items' => [
        ['judul' => 'Aman & Terpercaya', 'ket' => 'Perjalanan lebih tenang'],
        ['judul' => 'Armada Berkualitas', 'ket' => 'Nyaman selama perjalanan'],
        ['judul' => 'Layanan Profesional', 'ket' => 'Siap menemani perjalanan'],
    ]
])

<section class="w-full border-b border-[#1B4D3E]/10 bg-white py-6">
    <div class="mx-auto max-w-6xl px-4 sm:px-8">
        <ul class="grid gap-4 sm:grid-cols-3 sm:gap-6">
            @foreach ($items as $item)
                <li class="flex items-center gap-3 sm:justify-center">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#1B4D3E] text-white">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12l5 5 9-10" />
                        </svg>
                    </span>
                    <div class="flex flex-col text-sm">
                        <span class="font-bold text-[#1B4D3E]">{{ $item['judul'] }}</span>
                        <span class="mt-0.5 text-[#1B4D3E]/70">{{ $item['ket'] }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>