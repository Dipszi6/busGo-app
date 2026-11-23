@php
    $menus = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'active' => request()->routeIs('admin.dashboard'),
            'icon' =>
                '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
        ],
        [
            'label' => 'Kelola Armada',
            'route' => 'admin.armada.index',
            'active' => request()->routeIs('admin.armada.*'),
            'icon' =>
                '<rect x="3" y="5" width="18" height="12" rx="2"/><circle cx="7.5" cy="17" r="1.5"/><circle cx="16.5" cy="17" r="1.5"/><path d="M3 11h18"/>',
        ],
        [
            'label' => 'Rute & Jadwal',
            'route' => 'admin.jadwal.index',
            'active' => request()->routeIs('admin.jadwal.*') || request()->routeIs('admin.rute.*'),
            'icon' => '<path d="M17 3l4 4-4 4"/><path d="M3 7h18"/><path d="M7 21l-4-4 4-4"/><path d="M21 17H3"/>',
        ],
        [
            'label' => 'Pemesanan',
            'route' => 'admin.pemesanan.index',
            'active' => request()->routeIs('admin.pemesanan.*'),
            'icon' => '<rect x="4" y="4" width="16" height="16" rx="2"/><path d="M8 9h8M8 13h8M8 17h5"/>',
        ],
        [
            'label' => 'Pembayaran',
            'route' => 'admin.pembayaran.index',
            'active' => request()->routeIs('admin.pembayaran.*'),
            'icon' => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>',
        ],
        [
            'label' => 'Pelanggan',
            'route' => 'admin.pelanggan.index',
            'active' => request()->routeIs('admin.pelanggan.*'),
            'icon' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>',
        ],
        [
            'label' => 'Laporan',
            'route' => 'admin.laporan.index',
            'active' => request()->routeIs('admin.laporan.*'),
            'icon' => '<path d="M18 20V10M12 20V4M6 20v-6"/>',
        ],
    ];
@endphp

<aside class="flex w-64 shrink-0 flex-col bg-[#174E3F] text-white min-h-screen">
    <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#F7F2E8] font-bold text-[#174E3F]">
            BG
        </span>
        <div>
            <p class="text-base font-bold tracking-tight text-white">BusGo</p>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-white/60">Control Panel</p>
        </div>
    </div>

    <div class="flex-1 px-4 py-6">
        <p class="px-3 mb-3 text-[11px] font-bold uppercase tracking-wider text-white/50">
            Administrator
        </p>

        <nav class="space-y-1.5">
            @foreach ($menus as $menu)
                <a href="{{ route($menu['route']) }}"
                    class="relative flex items-center gap-3.5 rounded-xl px-4 py-3 text-sm font-semibold transition {{ $menu['active'] ? 'bg-[#F7F2E8] text-[#174E3F] shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    @if ($menu['active'])
                        <span class="absolute left-0 top-1.5 bottom-1.5 w-1.5 rounded-r-full bg-[#DF603F]"></span>
                    @endif

                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $menu['icon'] !!}
                    </svg>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <div class="px-4 py-5 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex w-full items-center gap-3.5 rounded-xl px-4 py-3 text-sm font-semibold text-white/80 hover:bg-white/10 hover:text-white transition">
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
