{{-- Left Sidebar Navigasi Profesional - PENAMAS --}}
@php
    $currentRoute = Route::currentRouteName();
    $activeMenu = $active ?? '';
@endphp

<!-- Mobile Backdrop Overlay -->
<div id="sidebar-backdrop" 
     onclick="toggleSidebar()" 
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity duration-300">
</div>

<!-- Sticky / Fixed Left Sidebar -->
<aside id="main-sidebar" 
       class="fixed inset-y-0 left-0 w-64 lg:w-72 bg-slate-900 text-slate-300 flex flex-col z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800 shadow-2xl">
    
    <!-- Sidebar Header / Logo Branding -->
    <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
        <a href="{{ route('stok.index') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-emerald-500 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform duration-200">
                P
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <span class="font-extrabold text-lg text-white tracking-tight">PENAMAS</span>
                    <span class="text-[10px] uppercase font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                        Banyumas
                    </span>
                </div>
                <p class="text-[11px] text-slate-400 font-medium">Bantuan Pangan Daerah</p>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button type="button" 
                onclick="toggleSidebar()" 
                class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Quick Status Badge -->
    <div class="px-6 py-3 bg-slate-900/80 border-b border-slate-800/60 flex items-center justify-between text-xs">
        <span class="text-slate-400 font-medium flex items-center space-x-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Gudang Dinsos Aktif</span>
        </span>
        <span class="text-[10px] font-semibold text-slate-400 bg-slate-800 px-2 py-0.5 rounded border border-slate-700">
            Reg. Banyumas
        </span>
    </div>

    <!-- Navigation Menu Items -->
    <nav class="flex-1 px-4 py-5 space-y-6 overflow-y-auto">

        <!-- KELOMPOK 1: GUDANG & LOGISTIK PANGAN -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                Manajemen Logistik Gudang
            </div>
            <div class="space-y-1">
                
                <!-- Master Stok Barang -->
                <a href="{{ route('stok.index') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition group
                   {{ $activeMenu === 'stok' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 {{ $activeMenu === 'stok' ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Master Stok Barang</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded {{ $activeMenu === 'stok' ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700' }}">
                        F-04
                    </span>
                </a>

                <!-- Mutasi Stok Keluar-Masuk (Active Root) -->
                <div class="space-y-1 pt-1">
                    <a href="{{ route('stok-mutasi.index') }}" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition group
                       {{ in_array($activeMenu, ['mutasi', 'mutasi-masuk', 'mutasi-keluar']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/25 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-4 h-4 {{ in_array($activeMenu, ['mutasi', 'mutasi-masuk', 'mutasi-keluar']) ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Buku Mutasi Keluar-Masuk</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded {{ in_array($activeMenu, ['mutasi', 'mutasi-masuk', 'mutasi-keluar']) ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                            F-06
                        </span>
                    </a>

                    <!-- Sub-menu Mutasi -->
                    <div class="pl-7 pr-1 space-y-1 pt-1">
                        <a href="{{ route('stok-mutasi.create') }}" 
                           class="flex items-center space-x-2.5 px-3 py-1.5 rounded-lg text-[11px] font-medium transition
                           {{ $activeMenu === 'mutasi-masuk' ? 'bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $activeMenu === 'mutasi-masuk' ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
                            <span>+ Catat Barang Masuk (Restok)</span>
                        </a>

                        <a href="{{ route('stok-mutasi.create-keluar') }}" 
                           class="flex items-center space-x-2.5 px-3 py-1.5 rounded-lg text-[11px] font-medium transition
                           {{ $activeMenu === 'mutasi-keluar' ? 'bg-rose-500/20 text-rose-300 font-bold border border-rose-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $activeMenu === 'mutasi-keluar' ? 'bg-rose-400' : 'bg-slate-500' }}"></span>
                            <span>&minus; Catat Keluar Manual (Rusak/Darurat)</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- KELOMPOK 2: DISTRIBUSI & PENERIMA BANSOS -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                Penyaluran & Penerima
            </div>
            <div class="space-y-1">
                
                <!-- Penyaluran Bansos -->
                <a href="{{ route('penyaluran.index') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition group
                   {{ $activeMenu === 'penyaluran' ? 'bg-blue-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 {{ $activeMenu === 'penyaluran' ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                        <span>Penyaluran & Bukti Serah</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-400 group-hover:bg-slate-700">
                        F-09
                    </span>
                </a>

                <!-- Data Penerima (KPM) -->
                <a href="{{ route('penerima.index') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition group
                   {{ $activeMenu === 'penerima' ? 'bg-blue-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 {{ $activeMenu === 'penerima' ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Data Penerima (KPM)</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-400 group-hover:bg-slate-700">
                        F-02
                    </span>
                </a>

            </div>
        </div>

    </nav>

    <!-- Sidebar Footer / Petugas Profile Card -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/60">
        <div class="flex items-center space-x-3 p-2 rounded-xl bg-slate-800/50 border border-slate-700/60">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-extrabold text-xs shadow-sm flex-shrink-0">
                HZ
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-1.5">
                    <span class="text-xs font-bold text-white truncate">Helmi Arif Zulfikar</span>
                </div>
                <div class="flex items-center space-x-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span class="text-[10px] text-slate-400 truncate">Petugas Gudang Logistik</span>
                </div>
            </div>
        </div>
    </div>

</aside>

<!-- Script Toggle Sidebar untuk Layar Mobile / Tablet -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('main-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    }
</script>
