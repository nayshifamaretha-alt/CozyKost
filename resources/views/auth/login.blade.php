<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CozyKost.id') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Poppins', sans-serif; }

        body {
            background: #0a0e1a;
            overflow-x: hidden;
        }

        .mesh-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.25) 0%, transparent 40%),
                radial-gradient(circle at 80% 30%, rgba(236, 72, 153, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 50% 80%, rgba(56, 189, 248, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 10% 90%, rgba(100, 116, 139, 0.3) 0%, transparent 45%);
            background-size: 200% 200%;
            animation: meshMove 15s ease-in-out infinite;
        }

        @keyframes meshMove {
            0%, 100% { background-position: 0% 0%, 100% 0%, 50% 100%, 0% 100%; }
            50% { background-position: 50% 50%, 50% 50%, 0% 50%, 100% 0%; }
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, black, transparent);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .delay-1 { animation-delay: 0.08s; }
        .delay-2 { animation-delay: 0.16s; }
        .delay-3 { animation-delay: 0.24s; }

        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.06),
                0 20px 50px -12px rgba(0,0,0,0.6),
                0 0 100px -20px rgba(99, 102, 241, 0.25);
        }

        .input-field {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .input-field:focus-within {
            transform: translateY(-1px);
        }

        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        .btn-primary:hover::before { transform: translateX(100%); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.5); }
        .btn-primary:active { transform: translateY(0); }

        .logo-glow {
            box-shadow: 0 0 0 1px rgba(255,255,255,0.1), 0 8px 24px -4px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>
<body class="antialiased min-h-screen relative">

<div class="mesh-bg"></div>
<div class="grid-overlay"></div>

<div class="min-h-screen flex items-center justify-center px-4 py-12 relative z-10">
    <div class="w-full max-w-[400px]">

        {{-- Logo & Heading --}}
        <div class="text-center mb-8 fade-up">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 logo-glow mb-5">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            </div>
            <h1 class="text-[22px] font-bold text-white tracking-tight">Selamat datang kembali</h1>
            <p class="text-slate-400 text-sm mt-1.5">Masuk ke akun CozyKost.id kamu untuk lanjut</p>
        </div>

        {{-- Card --}}
        <div class="glass-card rounded-[28px] p-7 fade-up delay-1">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div class="input-field">
                    <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            placeholder="nama@email.com"
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-gray-200 bg-gray-50/80 text-[15px] placeholder:text-gray-400 focus:bg-white focus:border-slate-400 focus:ring-4 focus:ring-slate-100 transition-all">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                {{-- Password --}}
                <div class="input-field">
                    <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-gray-200 bg-gray-50/80 text-[15px] placeholder:text-gray-400 focus:bg-white focus:border-slate-400 focus:ring-4 focus:ring-slate-100 transition-all">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded-md border-gray-300 text-slate-800 shadow-sm focus:ring-slate-400 w-4 h-4">
                        <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-slate-600 hover:text-slate-900 font-medium transition-colors" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="btn-primary w-full bg-gradient-to-r from-slate-800 to-slate-950 text-white font-semibold py-3.5 rounded-2xl text-[15px] mt-2">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

        {{-- Footer --}}
        @if (Route::has('register'))
            <p class="text-center text-sm text-slate-400 mt-7 fade-up delay-2">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-white font-semibold hover:underline underline-offset-4">Daftar sekarang</a>
            </p>
        @endif

        <p class="text-center text-xs text-slate-600 mt-10 fade-up delay-3">
            © {{ date('Y') }} CozyKost.id — Kelola kos lebih mudah
        </p>

    </div>
</div>

</body>
</html>