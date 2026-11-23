@props(['action', 'placeholder' => 'Cari data...', 'statuses' => []])

<form method="GET" action="{{ $action }}"
    class="flex flex-col justify-between gap-3 rounded-2xl bg-white p-4 border border-[#174E3F]/10 shadow-sm sm:flex-row sm:items-center">
    @if (!empty($statuses))
        <div class="flex flex-wrap gap-2">
            @foreach ($statuses as $key => $label)
                <a href="{{ $action . '?' . http_build_query(array_merge(request()->except('page', 'status'), ['status' => $key])) }}"
                    class="rounded-xl px-3.5 py-2 text-xs font-semibold transition {{ request('status', 'semua') === $key ? 'bg-[#174E3F] text-white' : 'bg-[#F6F9F7] text-[#64756D] hover:text-[#253C34]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    @else
        <div>{{ $slot }}</div>
    @endif

    <div class="flex gap-2">
        @if (request()->filled('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}"
            class="w-full sm:w-56 rounded-xl border border-[#174E3F]/20 px-3.5 py-2 text-xs text-[#253C34] focus:border-[#174E3F] focus:outline-none">
        <button type="submit"
            class="rounded-xl bg-[#174E3F] px-4 py-2 text-xs font-bold text-white hover:bg-[#123d32] transition">
            Cari
        </button>
    </div>
</form>
