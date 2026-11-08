
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CozyKost.id') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; }
        body { background: #0a0e1a; }

        .mesh-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.25) 0%, transparent 40%),
                radial-gradient(circle at 80% 30%, rgba(56, 189, 248, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 50% 80%, rgba(100, 116, 139, 0.25) 0%, transparent 45%);
            background-size: 200% 200%;
            animation: meshMove 15s ease-in-out infinite;
        }

        @keyframes meshMove {
            0%, 100% { background-position: 0% 0%, 100% 0%, 50% 100%; }
            50% { background-position: 50% 50%, 50% 50%, 0% 50%; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-up { animation: fadeUp 0.7s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        .reveal-hidden { opacity: 0; transform: translateY(24px); }

        .reveal-show {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .card-hover { transition: all 0.3s ease; }

        .card-hover:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="antialiased min-h-screen text-white">

<div class="mesh-bg"></div>

<div class="relative z-10 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="w-full max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <span class="text-xl font-bold">CozyKost.id</span>

        <nav class="flex items-center gap-3">
            <a href="#fitur" class="hidden md:inline px-3 py-2 text-sm font-medium text-slate-300 hover:text-white transition">Fitur</a>
            <a href="#cara-kerja" class="hidden md:inline px-3 py-2 text-sm font-medium text-slate-300 hover:text-white transition">Cara Kerja</a>

            {{-- Tombol Masuk selalu terlihat --}}
            <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-slate-300 hover:text-white transition">
                Masuk
            </a>

            @auth
                <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-full bg-white text-slate-900 text-sm font-semibold hover:bg-slate-100 transition">
                    Ke Dashboard
                </a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-white text-slate-900 text-sm font-semibold hover:bg-slate-100 transition">
                        Daftar
                    </a>
                @endif
            @endauth
        </nav>
    </header>

    {{-- Hero --}}
    <main class="flex-1">
        <section class="w-full max-w-6xl mx-auto px-6 pt-16 pb-12 text-center">

            <span class="fade-up inline-block px-4 py-1.5 rounded-full bg-white/10 text-xs font-medium text-slate-300 mb-6">
                Sistem Manajemen Kost Terpadu
            </span>

            <h1 class="fade-up delay-1 text-4xl md:text-6xl font-extrabold leading-tight">
                Kelola kost jadi lebih<br>
                <span class="text-slate-300">cozy</span> dan tertata
            </h1>

            <p class="fade-up delay-2 text-slate-400 mt-6 max-w-xl mx-auto">
                Satu platform untuk pemilik, admin, dan penghuni. Kamar, tagihan, pembayaran, dan komplain semua dalam satu tempat.
            </p>

            <div class="fade-up delay-2 mt-8 flex items-center justify-center gap-3 flex-wrap">

                {{-- Tombol Masuk selalu terlihat --}}
                <a href="{{ route('login') }}" class="px-7 py-3 rounded-2xl bg-white text-slate-900 font-semibold hover:bg-slate-100 transition">
                    Masuk Sekarang
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-7 py-3 rounded-2xl bg-white/10 text-white font-semibold hover:bg-white/20 transition">
                        Ke Dashboard
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-7 py-3 rounded-2xl bg-white/10 text-white font-semibold hover:bg-white/20 transition">
                            Buat Akun
                        </a>
                    @endif
                @endauth
            </div>

            {{-- 3 Role --}}
            <div class="fade-up delay-3 grid grid-cols-1 md:grid-cols-3 gap-4 mt-16 text-left">
                <div class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <p class="font-semibold">Pemilik</p>
                    <p class="text-sm text-slate-400 mt-2">Kelola properti, kamar, penghuni, keuangan, dan pantau laporan pendapatan.</p>
                </div>

                <div class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <p class="font-semibold">Admin</p>
                    <p class="text-sm text-slate-400 mt-2">Bantu operasional harian: verifikasi pembayaran dan tindak lanjut komplain.</p>
                </div>

                <div class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <p class="font-semibold">Penghuni</p>
                    <p class="text-sm text-slate-400 mt-2">Lihat tagihan, bayar langsung, dan ajukan komplain dari satu portal.</p>
                </div>
            </div>
        </section>

        {{-- Fitur --}}
        <section id="fitur" class="w-full max-w-6xl mx-auto px-6 py-20">
            <div class="text-center mb-12" data-reveal>
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-xs font-medium text-slate-300 mb-4">Fitur Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold">Semua yang kamu butuhkan,<br>dalam satu tempat</h2>
                <p class="text-slate-400 mt-4 max-w-xl mx-auto">Dari pencatatan kamar sampai laporan pendapatan, semuanya tersambung dan terupdate otomatis.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m4-14h6m-6 4h6m-6 4h6" /></svg>
                    </div>
                    <p class="font-semibold">Properti &amp; Kamar</p>
                    <p class="text-sm text-slate-400 mt-2">Kelola banyak gedung kost sekaligus, lengkap dengan foto, harga sewa, dan fasilitas tiap kamar.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
                    </div>
                    <p class="font-semibold">Monitoring Hunian</p>
                    <p class="text-sm text-slate-400 mt-2">Pantau siapa yang mengisi tiap kamar, lengkap dengan filter per gedung dan status terisi atau kosong.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a1 1 0 011 1v16l-3-2-3 2-3-2-3 2-3-2-3 2V4a1 1 0 011-1z" /></svg>
                    </div>
                    <p class="font-semibold">Tagihan Bulanan</p>
                    <p class="text-sm text-slate-400 mt-2">Buat dan pantau tagihan tiap penghuni, status lunas atau belum langsung terlihat.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="font-semibold">Pembayaran &amp; Verifikasi</p>
                    <p class="text-sm text-slate-400 mt-2">Penghuni bayar dan unggah bukti dari portalnya, admin tinggal verifikasi dengan satu klik.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </div>
                    <p class="font-semibold">Komplain Terpantau</p>
                    <p class="text-sm text-slate-400 mt-2">Keluhan penghuni tercatat lengkap dengan prioritas dan status, jadi tidak ada yang terlewat.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <p class="font-semibold">Laporan Pendapatan</p>
                    <p class="text-sm text-slate-400 mt-2">Grafik pendapatan 6 bulan terakhir dan bisa langsung diekspor ke PDF.</p>
                </div>

            </div>
        </section>

        {{-- Cara Kerja --}}
        <section id="cara-kerja" class="w-full max-w-6xl mx-auto px-6 py-20">
            <div class="text-center mb-12" data-reveal>
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-xs font-medium text-slate-300 mb-4">Cara Kerja</span>
                <h2 class="text-3xl md:text-4xl font-bold">Mulai dalam tiga langkah</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-10 h-10 rounded-full bg-white text-slate-900 font-bold flex items-center justify-center mb-4">1</div>
                    <p class="font-semibold">Pemilik menyiapkan data</p>
                    <p class="text-sm text-slate-400 mt-2">Tambahkan properti, kamar, dan penghuni. Akun login penghuni dibuat otomatis, dan admin bisa ditugaskan per gedung.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-10 h-10 rounded-full bg-white text-slate-900 font-bold flex items-center justify-center mb-4">2</div>
                    <p class="font-semibold">Penghuni bayar &amp; lapor</p>
                    <p class="text-sm text-slate-400 mt-2">Penghuni login ke portalnya, melihat tagihan, membayar, dan mengajukan komplain kapan saja.</p>
                </div>

                <div data-reveal class="card-hover rounded-3xl bg-white/5 border border-white/10 p-6">
                    <div class="w-10 h-10 rounded-full bg-white text-slate-900 font-bold flex items-center justify-center mb-4">3</div>
                    <p class="font-semibold">Admin memproses, pemilik memantau</p>
                    <p class="text-sm text-slate-400 mt-2">Admin memverifikasi pembayaran dan menyelesaikan komplain, pemilik melihat semuanya lewat dashboard dan laporan.</p>
                </div>

            </div>
        </section>

        {{-- Ajakan akhir --}}
        <section class="w-full max-w-4xl mx-auto px-6 py-20">
            <div data-reveal class="rounded-[32px] bg-white/5 border border-white/10 px-8 py-14 text-center">
                <h2 class="text-3xl md:text-4xl font-bold">Siap kelola kost lebih rapi?</h2>
                <p class="text-slate-400 mt-4 max-w-lg mx-auto">Masuk dan lihat semua data kostmu dalam satu dashboard.</p>

                <div class="mt-8 flex items-center justify-center gap-3 flex-wrap">

                    {{-- Tombol Masuk selalu terlihat --}}
                    <a href="{{ route('login') }}" class="px-7 py-3 rounded-2xl bg-white text-slate-900 font-semibold hover:bg-slate-100 transition">
                        Masuk Sekarang
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="px-7 py-3 rounded-2xl bg-white/10 text-white font-semibold hover:bg-white/20 transition">
                            Ke Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-7 py-3 rounded-2xl bg-white/10 text-white font-semibold hover:bg-white/20 transition">
                                Buat Akun
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="w-full max-w-6xl mx-auto px-6 py-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-2 text-xs text-slate-500">
        <span class="font-semibold text-slate-400">CozyKost.id</span>
        <span>Sistem Manajemen Kost Terpadu</span>
        <span>© {{ date('Y') }} CozyKost.id</span>
    </footer>

</div>

<script>
    // Kartu muncul pelan saat di-scroll
    const items = document.querySelectorAll('[data-reveal]');
    items.forEach(el => el.classList.add('reveal-hidden'));

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('reveal-hidden');
                entry.target.classList.add('reveal-show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    items.forEach(el => observer.observe(el));
</script>

</body>
</html>
