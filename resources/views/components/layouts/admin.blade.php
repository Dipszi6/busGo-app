@props(['title' => 'Dashboard Admin'])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Admin BusGo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F7F2E8] text-[#253C34] font-sans antialiased">
    <div class="flex min-h-screen">
        <x-admin.sidebar />

        <div class="flex-1 flex flex-col min-w-0">
            <header
                class="bg-white/80 backdrop-blur border-b border-[#174E3F]/10 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-bold text-[#253C34]">{{ $title }}</h1>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank"
                        class="text-xs font-semibold text-[#174E3F] hover:underline">
                        Lihat Web Publik &nearr;
                    </a>
                    <div class="flex items-center gap-2.5 border-l border-[#174E3F]/10 pl-4">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#174E3F] text-xs font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                        <span class="text-xs font-bold text-[#253C34]">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
                @if (session('success'))
                    <div
                        class="rounded-xl bg-[#DDEAE3] border border-[#174E3F]/20 px-4 py-3 text-sm font-semibold text-[#174E3F]">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
