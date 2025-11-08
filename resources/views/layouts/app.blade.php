{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Lentara')</title>

    {{-- Tailwind via CDN (tanpa Vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS Navbar --}}
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    <div class="min-h-screen flex flex-col">

        {{-- HEADER BRAND --}}
        <header class="border-b border-slate-800 bg-slate-950/80 backdrop-blur">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="{{ route('landing') }}" class="font-semibold text-lg text-emerald-300">
                    Lentara
                </a>
                <span class="text-xs text-slate-400">Prototype</span>
            </div>
        </header>

        {{-- NAVBAR UTAMA --}}
        @include('partials.navbar')

        {{-- KONTEN HALAMAN --}}
        <main class="flex-1">
            @yield('hero')
            @yield('content')
        </main>

        <footer class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} Lentara.
        </footer>
    </div>

    {{-- scripts tambahan dari child view --}}
    @stack('scripts')

    {{-- JS Navbar (theme toggle, drawer, indikator) --}}
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
