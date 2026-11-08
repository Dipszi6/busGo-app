@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' - '.config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7F2E8] text-[#1B4D3E] font-sans antialiased">

    <x-landing.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-landing.footer />

</body>
</html>