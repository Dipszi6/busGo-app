@php
    $user = auth()->user();
    $menus = [
        [
            'label' => 'Ringkasan Akun',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard'),
        ],
        [
            'label' => 'Riwayat Pemesanan',
            'route' => 'riwayat.index',
            'active' => request()->routeIs('riwayat.*'),
        ],
        [
            'label' => 'Pengaturan Profil',
            'route' => 'profile.edit',
            'active' => request()->routeIs('profile.edit'),
        ],
    ];
@endphp

<aside class="space-y-4">
    <div class="rounded-2xl bg-white p-6 border border-[#174E3F]/10">
        <div class="flex items-center gap-3.5">
            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#174E3F] text-base font-bold text-white">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="min-w-0">
                <p class="truncate font-bold text-[#253C34]">{{ $user->name }}</p>
                <p class="truncate text-xs text-[#64756D]">{{ $user->email }}</p>
                <span
                    class="mt-1.5 inline-block rounded-full bg-[#DDEAE3] px-2.5 py-0.5 text-[11px] font-semibold capitalize text-[#174E3F]">
                    {{ $user->role ?? 'Penumpang' }}
                </span>
            </div>
        </div>
    </div>

    <nav class="rounded-2xl bg-white p-3 border border-[#174E3F]/10 space-y-1">
        @foreach ($menus as $menu)
            <a href="{{ route($menu['route']) }}"
                class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition {{ $menu['active'] ? 'bg-[#174E3F] text-white' : 'text-[#253C34] hover:bg-[#F6F9F7]' }}">
                <span>{{ $menu['label'] }}</span>
                <span class="{{ $menu['active'] ? 'text-white/80' : 'text-[#64756D]' }}">&rarr;</span>
            </a>
        @endforeach

        <a href="{{ route('home') }}"
            class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold text-[#174E3F] hover:bg-[#DDEAE3]/50 transition">
            <span>+ Pesan Tiket Baru</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-[#174E3F]/10">
            @csrf
            <button type="submit"
                class="w-full text-left rounded-xl px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition">
                Keluar Akun
            </button>
        </form>
    </nav>
</aside>
