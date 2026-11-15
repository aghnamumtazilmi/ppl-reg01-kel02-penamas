<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas Penyaluran Bantuan - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Header Proyek -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md">
            <h1 class="text-2xl font-bold">Daftar Tugas Penyaluran Bantuan</h1>
            <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
        </div>

        <!-- Kontainer Utama -->
        <div class="bg-white rounded-b-2xl shadow-md p-6 border border-slate-200 border-t-0">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-emerald-800 text-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Info Petugas & Filter Simulasi (PBI-025 AC 1) -->
            <div class="mb-6 bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($currentPetugas->name ?? 'P', 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Petugas Lapangan Aktif</div>
                        <div class="text-sm font-bold text-slate-800">{{ $currentPetugas->name ?? 'Belum ada petugas' }}</div>
                        <div class="text-xs text-slate-500">{{ $currentPetugas->email ?? 'petugas@penamas.id' }}</div>
                    </div>
                </div>

                <!-- Dropdown Simulasi Petugas (Sangat Membantu saat Pengujian & Demo ke Dosen) -->
                @if($daftarPetugas->count() > 1)
                    <form method="GET" action="{{ route('penyaluran.index') }}" class="flex items-center space-x-2">
                        <label for="petugas_id" class="text-xs font-semibold text-slate-600 whitespace-nowrap">Ganti Petugas (Simulasi):</label>
                        <select name="petugas_id" id="petugas_id" onchange="this.form.submit()"
                            class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                            @foreach ($daftarPetugas as $p)
                                <option value="{{ $p->id }}" {{ ($currentPetugas->id ?? null) == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>

            <!-- Tab Filter Status Tugas (PBI-025 & PBI-026) -->
            <div class="flex items-center space-x-2 border-b border-slate-200 mb-5">
                <a href="{{ route('penyaluran.index', array_merge(request()->query(), ['status' => 'disetujui'])) }}"
                    class="pb-2.5 px-3 text-xs font-semibold border-b-2 transition flex items-center space-x-1.5 {{ $tabStatus === 'disetujui' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                    <span class="w-2 h-2 rounded-full {{ $tabStatus === 'disetujui' ? 'bg-emerald-600' : 'bg-slate-300' }}"></span>
                    <span>Tugas Aktif (Disetujui)</span>
                </a>
                <a href="{{ route('penyaluran.index', array_merge(request()->query(), ['status' => 'disalurkan'])) }}"
                    class="pb-2.5 px-3 text-xs font-semibold border-b-2 transition flex items-center space-x-1.5 {{ $tabStatus === 'disalurkan' ? 'border-emerald-600 text-emerald-700' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                    <span class="w-2 h-2 rounded-full {{ $tabStatus === 'disalurkan' ? 'bg-blue-600' : 'bg-slate-300' }}"></span>
                    <span>Riwayat Telah Disalurkan</span>
                </a>
            </div>

            <!-- Catatan Kriteria -->
            <div class="mb-4 text-xs text-slate-500 flex items-center space-x-1">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                @if($tabStatus === 'disetujui')
                    <span>Menampilkan rencana distribusi berstatus <strong>Disetujui</strong> yang menugaskan diri Anda sebagai petugas lapangan.</span>
                @else
                    <span>Menampilkan riwayat distribusi yang telah selesai dan statusnya otomatis berubah menjadi <strong>Disalurkan</strong>.</span>
                @endif
            </div>

            <!-- Tabel Daftar Tugas Pembagian Bantuan -->
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-semibold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3.5">Kode Distribusi</th>
                            <th scope="col" class="px-4 py-3.5">Wilayah Tugas</th>
                            <th scope="col" class="px-4 py-3.5">Periode</th>
                            <th scope="col" class="px-4 py-3.5">Paket Bantuan</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Jumlah KPM</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Status</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($daftarTugas as $tugas)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 font-mono font-semibold text-emerald-700">
                                    {{ $tugas->kode }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $tugas->wilayah }}</div>
                                    <div class="text-xs text-slate-500">Kabupaten Banyumas</div>
                                </td>
                                <td class="px-4 py-3 text-xs font-medium text-slate-700">
                                    {{ $tugas->periode }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-xs font-semibold text-slate-800">{{ $tugas->paketBantuan->nama ?? 'Paket Bantuan Pangan' }}</div>
                                    <div class="text-xs text-slate-500">{{ $tugas->paketBantuan->deskripsi ?? 'Bantuan Pangan Rutin' }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        <strong class="font-bold text-slate-900 mr-1">{{ $tugas->penerima_count ?? $tugas->jumlah_penerima }}</strong> Warga
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($tugas->status === 'disalurkan')
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            Disalurkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-300">
                                            Disetujui
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('penyaluran.show', $tugas->id) }}"
                                        class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>Buka Rincian Tugas</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <p class="font-semibold text-slate-600 text-base">Tidak ada tugas penyaluran bantuan yang aktif.</p>
                                    <p class="text-xs text-slate-400 mt-1">Saat ini belum ada rencana distribusi berstatus "Disetujui" yang ditugaskan kepada akun Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($daftarTugas->hasPages())
                <div class="mt-5">
                    {{ $daftarTugas->links() }}
                </div>
            @endif

        </div>

    </div>

</body>
</html>
