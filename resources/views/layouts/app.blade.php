<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PENAMAS') - Bantuan Pangan Banyumas</title>
    <!-- Tailwind CSS via CDN untuk kemudahan preview langsung di browser -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        P
                    </div>
                    <div>
                        <span class="font-bold text-lg text-slate-900 tracking-tight">PENAMAS</span>
                        <span class="hidden sm:inline-block text-xs text-slate-500 ml-2 px-2 py-0.5 bg-slate-100 rounded-full border border-slate-200">Kabupaten Banyumas</span>
                    </div>
                </div>

                <nav class="flex items-center space-x-1 sm:space-x-4 text-sm font-medium">
                    <a href="{{ route('stok.index') }}" class="px-3 py-2 rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition">
                        Daftar Stok
                    </a>
                    <a href="{{ route('stok.create') }}" class="px-3 py-2 rounded-lg text-slate-600 hover:text-emerald-700 hover:bg-slate-50 transition">
                        + Tambah Barang
                    </a>
                    <span class="text-xs text-slate-400 px-2 py-1 bg-slate-100 rounded">Role: Admin</span>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        <!-- Flash Message Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start space-x-3 text-emerald-800 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 1118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-semibold text-sm">Berhasil!</h4>
                    <p class="text-xs mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} PENAMAS - Proyek Perangkat Lunak REG01 Kelompok 02
    </footer>

</body>
</html>
