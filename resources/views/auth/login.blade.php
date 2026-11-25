<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun - Penamas Kabupaten Banyumas</title>
    <!-- Tailwind CSS v3 via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Anti-flicker dark mode script -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('penamas_theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        /* Custom subtle scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }
    </style>
</head>
<body class="min-h-screen bg-white dark:bg-zinc-950 text-slate-800 dark:text-zinc-200 flex flex-col lg:grid lg:grid-cols-12 transition-colors duration-200">

    <!-- LEFT PANEL: LOGIN FORM (5 cols on lg) -->
    <div class="lg:col-span-5 xl:col-span-5 p-8 sm:p-12 xl:p-16 flex flex-col justify-between bg-white dark:bg-zinc-950 min-h-screen transition-colors duration-200">
        
        <!-- Top Bar: Logo Penamas & Dark Mode Toggle -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-zinc-800 dark:border dark:border-zinc-700 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    P
                </div>
                <div>
                    <span class="font-bold text-lg text-slate-900 dark:text-white tracking-tight">Penamas</span>
                    <span class="block text-[11px] text-slate-400 dark:text-zinc-500 font-medium">Kabupaten Banyumas</span>
                </div>
            </div>

            <!-- Dark / Light Mode Toggle Button -->
            <button 
                type="button" 
                id="themeToggleBtn" 
                class="w-9 h-9 rounded-xl border border-slate-200 dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 text-slate-700 dark:text-zinc-200 flex items-center justify-center shadow-sm hover:bg-slate-100 dark:hover:bg-zinc-800 transition active:scale-95" 
                title="Ganti Mode Gelap / Terang"
            >
                <span id="themeToggleIcon" class="text-sm">🌙</span>
            </button>
        </div>

        <!-- Form Content -->
        <div class="w-full max-w-[390px] mx-auto my-auto py-6">
            
            <!-- Title & Subtitle (Centered) -->
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-[28px] font-bold text-slate-900 dark:text-white tracking-tight">Masuk ke Akun</h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-zinc-400 mt-2 leading-relaxed">
                    Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat Kabupaten Banyumas.
                </p>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-4 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-xs text-emerald-800 dark:text-emerald-300 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-xs text-rose-700 dark:text-rose-300 flex items-start space-x-2">
                    <svg class="w-4 h-4 text-rose-500 dark:text-rose-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <!-- Email / NIP Field -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">
                        Alamat Email / Akun Petugas <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect width="20" height="16" x="2" y="4" rx="3"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            value="{{ old('email', 'petugas@penamas.test') }}" 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-zinc-800 text-slate-800 dark:text-zinc-100 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 dark:focus:ring-white/10 focus:border-slate-900 dark:focus:border-zinc-500 transition placeholder-slate-400 dark:placeholder-zinc-600 bg-white dark:bg-zinc-900"
                            placeholder="nama@penamas.test"
                            required
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-zinc-300 mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-zinc-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            value="password" 
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-300 dark:border-zinc-800 text-slate-800 dark:text-zinc-100 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 dark:focus:ring-white/10 focus:border-slate-900 dark:focus:border-zinc-500 transition tracking-widest placeholder-slate-400 dark:placeholder-zinc-600 bg-white dark:bg-zinc-900"
                            placeholder="••••••••"
                            required
                        >
                        <button 
                            type="button" 
                            id="togglePassword" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-zinc-500 hover:text-slate-600 dark:hover:text-zinc-300 transition"
                            title="Tampilkan / sembunyikan kata sandi"
                        >
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer text-slate-600 dark:text-zinc-400 hover:text-slate-900 dark:hover:text-zinc-200">
                        <input 
                            type="checkbox" 
                            name="remember"
                            id="remember"
                            value="1"
                            checked 
                            class="w-3.5 h-3.5 rounded border-slate-300 dark:border-zinc-700 text-slate-900 dark:text-white focus:ring-slate-800 dark:focus:ring-zinc-400 accent-slate-900 dark:accent-zinc-100 cursor-pointer"
                        >
                        <span class="font-medium">Ingat sesi saya</span>
                    </label>
                    <a href="#" class="font-semibold text-slate-700 dark:text-zinc-300 hover:text-slate-950 dark:hover:text-white hover:underline">Lupa Kata Sandi?</a>
                </div>

                <!-- Main Sign In Button -->
                <div class="pt-3">
                    <button 
                        type="submit" 
                        class="w-full py-2.5 px-4 rounded-xl text-white font-semibold text-xs sm:text-sm bg-gradient-to-b from-slate-800 to-slate-950 hover:from-slate-900 hover:to-black dark:from-zinc-100 dark:to-zinc-200 dark:text-zinc-950 dark:hover:from-white dark:hover:to-zinc-100 shadow-md shadow-slate-900/15 dark:shadow-none active:scale-[0.99] transition flex items-center justify-center space-x-2"
                    >
                        <span>Masuk ke Sistem</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>

                <!-- Security Notice -->
                <div class="pt-4 text-center">
                    <p class="text-[11px] text-slate-400 dark:text-zinc-500 flex items-center justify-center space-x-1">
                        <svg class="w-3.5 h-3.5 text-slate-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Akses terbatas untuk Petugas & Administrator Resmi</span>
                    </p>
                </div>

            </form>
        </div>

        <!-- Footer: Copyright & Support -->
        <div class="flex items-center justify-between text-[11px] text-slate-400 dark:text-zinc-500 pt-6 border-t border-slate-100 dark:border-zinc-850 mt-6">
            <span>&copy; 2026 Penamas Kab. Banyumas</span>
            <span>Butuh bantuan? <a href="#" class="text-slate-800 dark:text-zinc-300 hover:text-black dark:hover:text-white font-semibold hover:underline">Kontak Dinsospermades</a></span>
        </div>

    </div>

    <!-- RIGHT PANEL: DASHBOARD PREVIEW & TESTIMONIAL (7 cols on lg) -->
    <div class="lg:col-span-7 xl:col-span-7 bg-[#f8fafc] dark:bg-[#121214] p-6 sm:p-10 xl:p-14 flex flex-col justify-between border-t lg:border-t-0 lg:border-l border-slate-200/80 dark:border-zinc-800 min-h-screen transition-colors duration-200">
        
        <!-- Floating Interactive Dashboard Mockup Card -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xl shadow-slate-200/80 dark:shadow-2xl dark:shadow-black/60 border border-slate-200/60 dark:border-zinc-800 p-5 md:p-6 mb-8 transform hover:scale-[1.01] transition duration-300">
            
            <div class="grid grid-cols-12 gap-4">
                
                <!-- Inner Sidebar Mockup (4 cols) -->
                <div class="col-span-4 border-r border-slate-100 dark:border-zinc-800 pr-3 hidden sm:block">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-5 h-5 rounded-md bg-slate-900 dark:bg-zinc-800 text-white flex items-center justify-center text-[10px] font-bold">P</div>
                        <span class="font-bold text-xs text-slate-900 dark:text-white tracking-tight">Penamas</span>
                    </div>

                    <!-- Mini Search -->
                    <div class="bg-slate-50 dark:bg-zinc-800/60 rounded-lg px-2 py-1 flex items-center space-x-1 text-[10px] text-slate-400 dark:text-zinc-500 mb-4 border border-slate-100 dark:border-zinc-750">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="truncate">Cari data penerima...</span>
                        <span class="ml-auto text-[8px] bg-white dark:bg-zinc-700 text-slate-500 dark:text-zinc-300 px-1 py-0.5 rounded border border-slate-200 dark:border-zinc-600">⌘K</span>
                    </div>

                    <!-- Nav List -->
                    <div class="space-y-3">
                        <div>
                            <span class="text-[9px] font-bold tracking-wider text-slate-400 dark:text-zinc-500 uppercase">MENU UTAMA</span>
                            <div class="mt-1.5 space-y-0.5">
                                <div class="flex items-center space-x-2 px-2 py-1 rounded-md bg-slate-100 dark:bg-zinc-800 text-slate-900 dark:text-white text-[11px] font-semibold">
                                    <svg class="w-3.5 h-3.5 text-slate-700 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect></svg>
                                    <span>Dashboard Ringkasan</span>
                                </div>
                                <div class="flex items-center space-x-2 px-2 py-1 rounded-md text-slate-600 dark:text-zinc-400 text-[11px]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span>Data Penerima (KPM)</span>
                                </div>
                                <div class="pl-6 space-y-1 text-[10px] text-slate-400 dark:text-zinc-500">
                                    <p class="text-slate-700 dark:text-zinc-300 font-medium">Semua Kecamatan</p>
                                    <p>Purwokerto Selatan</p>
                                    <p>Sokaraja & Banyumas</p>
                                </div>
                                <div class="flex items-center space-x-2 px-2 py-1 rounded-md text-slate-600 dark:text-zinc-400 text-[11px]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <span>Kelola Stok Gudang</span>
                                </div>
                                <div class="flex items-center space-x-2 px-2 py-1 rounded-md text-slate-600 dark:text-zinc-400 text-[11px]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <span>Paket Bantuan Pangan</span>
                                </div>
                                <div class="flex items-center space-x-2 px-2 py-1 rounded-md text-slate-600 dark:text-zinc-400 text-[11px]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Rencana Distribusi</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <span class="text-[9px] font-bold tracking-wider text-slate-400 dark:text-zinc-500 uppercase">AUDIT & PELAPORAN</span>
                            <div class="mt-1 space-y-0.5 text-[11px] text-slate-500 dark:text-zinc-400">
                                <p class="px-2 py-0.5">Bukti Foto Penyaluran</p>
                                <p class="px-2 py-0.5">Riwayat Mutasi Stok</p>
                                <p class="px-2 py-0.5">Laporan Evaluasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inner Main Content Mockup (8 cols on sm) -->
                <div class="col-span-12 sm:col-span-8 space-y-4">
                    
                    <!-- Breadcrumb & Header Greeting -->
                    <div>
                        <div class="text-[10px] text-slate-400 dark:text-zinc-500 flex items-center space-x-1 mb-1">
                            <span>Overview</span>
                            <span>/</span>
                            <span class="text-slate-700 dark:text-zinc-300 font-medium">Dashboard</span>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center">
                            Halo, Petugas Bantuan <span class="ml-1.5 text-base">👋</span>
                        </h2>
                        <p class="text-[10px] text-slate-400 dark:text-zinc-500">Ringkasan status bantuan pangan masyarakat Kabupaten Banyumas hari ini.</p>
                    </div>

                    <!-- 2 Stat Mini Cards -->
                    <div class="grid grid-cols-2 gap-2.5">
                        <div class="p-2.5 rounded-xl border border-slate-100 dark:border-zinc-800 bg-slate-50/50 dark:bg-zinc-800/40">
                            <div class="flex items-center justify-between text-[10px] text-slate-500 dark:text-zinc-400 mb-1">
                                <span>Penerima (KPM)</span>
                                <svg class="w-3 h-3 text-slate-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857"></path></svg>
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div class="text-base font-bold text-slate-900 dark:text-white">3,484</div>
                                    <span class="text-[9px] text-slate-700 dark:text-zinc-300 font-semibold">+71% <span class="text-slate-400 dark:text-zinc-500 font-normal">terverifikasi</span></span>
                                </div>
                                <!-- Sparkline visual -->
                                <svg class="w-12 h-6 text-slate-500 dark:text-zinc-400 stroke-current fill-none stroke-[2]" viewBox="0 0 50 20">
                                    <path d="M0 16 Q 10 18, 20 10 T 35 12 T 50 4" />
                                </svg>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl border border-slate-100 dark:border-zinc-800 bg-slate-50/50 dark:bg-zinc-800/40">
                            <div class="flex items-center justify-between text-[10px] text-slate-500 dark:text-zinc-400 mb-1">
                                <span>Stok Paket Gudang</span>
                                <svg class="w-3 h-3 text-slate-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div class="text-base font-bold text-slate-900 dark:text-white">486</div>
                                    <span class="text-[9px] text-slate-700 dark:text-zinc-300 font-semibold">Tersedia <span class="text-slate-400 dark:text-zinc-500 font-normal">di gudang</span></span>
                                </div>
                                <!-- Sparkline visual -->
                                <svg class="w-12 h-6 text-slate-500 dark:text-zinc-400 stroke-current fill-none stroke-[2]" viewBox="0 0 50 20">
                                    <path d="M0 14 Q 15 16, 25 8 T 40 10 T 50 5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Volume Trend Chart Mockup -->
                    <div class="p-3 rounded-xl border border-slate-100 dark:border-zinc-800 bg-white dark:bg-zinc-850">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-1.5 text-[11px] text-slate-700 dark:text-zinc-300 font-semibold">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M9 21V9"></path></svg>
                                <span>Tren Penyaluran Paket Bantuan</span>
                            </div>
                        </div>

                        <div class="flex items-baseline space-x-1.5 mb-3">
                            <span class="text-lg font-bold text-slate-900 dark:text-white">4,790</span>
                            <span class="text-[10px] text-slate-700 dark:text-zinc-300 font-semibold">Paket <span class="text-slate-400 dark:text-zinc-500 font-normal">tersalurkan</span></span>
                        </div>

                        <!-- Bar Chart Visual matching the highlighted Tuesday bar -->
                        <div class="relative pt-6">
                            <!-- Floating Tooltip on Tuesday Bar -->
                            <div class="absolute top-0 left-[48%] -translate-x-1/2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-[9px] font-semibold px-2 py-0.5 rounded shadow">
                                Banyumas : 584 Paket
                            </div>

                            <div class="flex items-end justify-between h-24 gap-2 px-1">
                                <!-- Purwokerto S. -->
                                <div class="w-full flex flex-col items-center gap-1.5">
                                    <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-t-md h-12"></div>
                                    <span class="text-[9px] text-slate-400 dark:text-zinc-500 truncate">Pwt.S</span>
                                </div>
                                <!-- Purwokerto T. -->
                                <div class="w-full flex flex-col items-center gap-1.5">
                                    <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-t-md h-16"></div>
                                    <span class="text-[9px] text-slate-400 dark:text-zinc-500 truncate">Pwt.T</span>
                                </div>
                                <!-- Banyumas (Highlighted Active Bar) -->
                                <div class="w-full flex flex-col items-center gap-1.5">
                                    <div class="w-full bg-gradient-to-b from-slate-700 to-slate-950 dark:from-zinc-100 dark:to-zinc-300 rounded-t-md h-20 shadow-sm"></div>
                                    <span class="text-[9px] font-semibold text-slate-800 dark:text-zinc-200 truncate">Banyumas</span>
                                </div>
                                <!-- Sokaraja -->
                                <div class="w-full flex flex-col items-center gap-1.5">
                                    <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-t-md h-14"></div>
                                    <span class="text-[9px] text-slate-400 dark:text-zinc-500 truncate">Sokaraja</span>
                                </div>
                                <!-- Ajibarang -->
                                <div class="w-full flex flex-col items-center gap-1.5">
                                    <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-t-md h-10"></div>
                                    <span class="text-[9px] text-slate-400 dark:text-zinc-500 truncate">Ajibarang</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Bottom Testimonial Section -->
        <div class="mt-auto pt-2">
            <blockquote class="text-base sm:text-lg lg:text-[19px] font-medium text-slate-800 dark:text-zinc-200 leading-snug tracking-tight">
                &ldquo;<span class="font-bold text-slate-900 dark:text-white">Penamas</span> mentransformasi pengelolaan logistik bantuan pangan secara terintegrasi. Cepat, transparan, dan memastikan <span class="font-bold text-slate-900 dark:text-white">bantuan tepat sasaran</span> bagi warga Banyumas.&rdquo;
            </blockquote>

            <!-- User Profile Info -->
            <div class="flex items-center space-x-3.5 mt-5">
                <div class="w-10 h-10 rounded-full bg-slate-900 dark:bg-zinc-800 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white dark:ring-zinc-800">
                    DP
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white leading-tight">Dinas Sosial & Pemberdayaan Masyarakat (Dinsospermades)</h4>
                    <p class="text-[11px] text-slate-500 dark:text-zinc-400 mt-0.5">Bidang Perlindungan dan Jaminan Sosial &mdash; Pemerintah Kab. Banyumas</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Interactive Script for Password Toggle & Theme Toggle -->
    <script>
        // Password Toggle Logic
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            // Toggle eye icon
            if (isPassword) {
                eyeIcon.innerHTML = `
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                    <line x1="2" x2="22" y1="2" y2="22"></line>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            }
        });

        // Theme Toggle Logic (Synchronized with Kravio localStorage 'penamas_theme')
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeToggleIcon');

        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            themeIcon.textContent = isDark ? '☀️' : '🌙';
            themeBtn.title = isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap';
        }

        updateThemeIcon();

        themeBtn.addEventListener('click', function () {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('penamas_theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
        });
    </script>

</body>
</html>
