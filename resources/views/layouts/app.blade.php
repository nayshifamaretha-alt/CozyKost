<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CozyKost.id') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Poppins', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex bg-gray-50">

            <!-- Sidebar -->
            <aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white flex flex-col shrink-0">
                <div class="px-6 py-6 flex items-center gap-2">
                    <span class="text-2xl font-bold">CozyKost.id</span>
                </div>
                <nav class="flex-1 px-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') || request()->routeIs('portal.dashboard') || request()->routeIs('adminportal.dashboard') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Dashboard
                    </a>

                    @if (auth()->user()->role == 'pemilik')
                        <a href="{{ route('properti.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('properti.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m4-14h6m-6 4h6m-6 4h6" /></svg>
                            Properti
                        </a>
                        <a href="{{ route('kamar.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('kamar.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            Kamar
                        </a>
                        <a href="{{ route('penghuni.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('penghuni.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0" /></svg>
                            Penghuni
                        </a>
                        <a href="{{ route('monitoring.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('monitoring.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
                            Monitoring
                        </a>
                        <a href="{{ route('keuangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('keuangan.*') || request()->routeIs('tagihan.*') || request()->routeIs('pembayaran.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" /></svg>
                            Keuangan
                        </a>
                        <a href="{{ route('komplain.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('komplain.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            Komplain
                        </a>
                        <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('laporan.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            Laporan
                        </a>
                        <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            Kelola Admin
                        </a>
                    @endif

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('adminportal.kamar') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.kamar') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            Kamar
                        </a>
                        <a href="{{ route('adminportal.penghuni') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.penghuni') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0" /></svg>
                            Penghuni
                        </a>
                        <a href="{{ route('adminportal.pembayaran') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.pembayaran') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Pembayaran
                        </a>
                        <a href="{{ route('adminportal.komplain') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('adminportal.komplain') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            Komplain
                        </a>
                    @endif

                    @if (auth()->user()->role == 'penghuni')
                        <a href="{{ route('portal.tagihan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('portal.tagihan') || request()->routeIs('portal.bayar') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" /></svg>
                            Tagihan
                        </a>
                        <a href="{{ route('portal.komplain') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('portal.komplain*') ? 'bg-white text-slate-800 font-semibold shadow-sm' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            Komplain
                        </a>
                    @endif
                </nav>
                <div class="px-4 py-6 border-t border-white/20">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-xl hover:bg-white/10 text-sm">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded-xl hover:bg-white/10 text-sm">Keluar</button>
                    </form>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 flex flex-col min-w-0">
                @isset($header)
                    <header class="bg-white shadow-sm">
                        <div class="px-8 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>

        </div>
        @stack('scripts')
    </body>
</html>