<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - PENAMAS Banyumas</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased">

    <!-- Header / Navbar Utama -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand & Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-emerald-500/20">
                        PN
                    </div>
                    <div>
                        <a href="{{ url('/') }}" class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                            PENAMAS
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Sprint 1</span>
                        </a>
                        <p class="text-xs text-slate-500 hidden sm:block">Dinsospermades Kab. Banyumas &bull; SDG 2</p>
                    </div>
                </div>

                <!-- Navigasi Menu -->
                <nav class="flex items-center space-x-1 sm:space-x-2">
                    <a href="{{ url('/') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition {{ request()->is('/') || request()->is('dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </span>
                    </a>

                    @if(Route::has('users.index'))
                    <a href="{{ route('users.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('users.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Pengguna
                    </a>
                    @endif

                    @if(Route::has('penerima.index'))
                    <a href="{{ route('penerima.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('penerima.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Penerima
                    </a>
                    @endif

                    <!-- User Profile Indicator -->
                    <div class="ml-3 pl-3 border-l border-slate-200 hidden md:flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-700">
                            ES
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-bold text-slate-800 leading-none">Edwin Salman Hakim</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Admin & Pimpinan</p>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Alert Success -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start justify-between shadow-xs">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            <p><strong>PENAMAS</strong> &bull; Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat Kabupaten Banyumas</p>
            <p class="mt-1 text-slate-400">Mendukung SDG 2: Tanpa Kelaparan (Zero Hunger) &bull; Dinsospermades Kab. Banyumas &bull; Kelompok 2 (REG 01)</p>
        </div>
    </footer>

</body>
</html>
