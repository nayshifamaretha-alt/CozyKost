<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CozyKost.id') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">

<div class="min-h-screen flex">

    <!-- Overlay untuk HP -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"
         onclick="closeSidebar()">
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white flex flex-col shrink-0 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:min-h-screen">

        <div class="px-6 py-6 flex items-center justify-between">
            <span class="text-2xl font-bold">CozyKost.id</span>

            <button type="button"
                    onclick="closeSidebar()"
                    class="lg:hidden text-white text-2xl"
                    aria-label="Tutup menu">
                &times;
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto pb-4">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') || request()->routeIs('portal.dashboard') || request()->routeIs('adminportal.dashboard') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}"
               onclick="closeSidebar()">
                Dashboard
            </a>

            @if (auth()->user()->role == 'pemilik')

                <a href="{{ route('properti.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('properti.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Properti</a>

                <a href="{{ route('kamar.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('kamar.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Kamar</a>

                <a href="{{ route('penghuni.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('penghuni.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Penghuni</a>

                <a href="{{ route('monitoring.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('monitoring.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Monitoring</a>

                <a href="{{ route('keuangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('keuangan.*') || request()->routeIs('tagihan.*') || request()->routeIs('pembayaran.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Keuangan</a>

                <a href="{{ route('komplain.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('komplain.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Komplain</a>

                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('laporan.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Laporan</a>

                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Kelola Admin</a>

            @endif

            @if (auth()->user()->role == 'admin')

                <a href="{{ route('adminportal.kamar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.kamar') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Kamar</a>

                <a href="{{ route('adminportal.penghuni') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.penghuni') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Penghuni</a>

                <a href="{{ route('adminportal.pembayaran') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.pembayaran') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Pembayaran</a>

                <a href="{{ route('adminportal.komplain') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.komplain') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Komplain</a>

            @endif

            @if (auth()->user()->role == 'penghuni')

                <a href="{{ route('portal.tagihan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('portal.tagihan') || request()->routeIs('portal.bayar') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Tagihan</a>

                <a href="{{ route('portal.komplain') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('portal.komplain*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}" onclick="closeSidebar()">Komplain</a>

            @endif

        </nav>

        <div class="px-4 py-6 border-t border-white/20">
            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 rounded-xl hover:bg-white/10 text-sm"
               onclick="closeSidebar()">
                Profil
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-xl hover:bg-white/10 text-sm">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten utama -->
    <div class="flex-1 min-w-0 flex flex-col">

        <!-- Header HP -->
        <header class="bg-white shadow-sm px-4 py-3 flex items-center gap-3 lg:hidden">
            <button type="button"
                    onclick="openSidebar()"
                    class="text-slate-800 text-2xl px-2"
                    aria-label="Buka menu">
                ☰
            </button>

            <span class="font-bold text-lg text-slate-800">
                CozyKost.id
            </span>
        </header>

        @isset($header)
            <header class="bg-white shadow-sm">
                <div class="px-4 py-4 sm:px-6 lg:px-8 lg:py-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1 min-w-0 w-full">
            {{ $slot }}
        </main>

    </div>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.remove('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>

@stack('scripts')

</body>
</html>
