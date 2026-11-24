<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PENAMAS - Sistem Pengendalian & Distribusi Bantuan Pangan Terpadu Kabupaten Banyumas">
    <title>@yield('page-title', 'Dashboard') — PENAMAS</title>

    <!-- Google Fonts: Plus Jakarta Sans & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

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
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Light Mode Tokens ── */
        :root {
            --bg:              #f4f4f5;
            --sidebar:         #ffffff;
            --sidebar-border:  #e4e4e7;
            --surface:         #ffffff;
            --surface-2:       #f9f9fb;
            --border:          #e4e4e7;
            --text-1:          #18181b;
            --text-2:          #52525b;
            --text-3:          #a1a1aa;
            --accent:          #18181b;
            --accent-fg:       #ffffff;
            --active-bg:       #f4f4f5;
            --active-border:   #e4e4e7;
            --tag-green-bg:    #f0fdf4;
            --tag-green-fg:    #15803d;
            --tag-green-border:#bbf7d0;
            --tag-amber-bg:    #fffbeb;
            --tag-amber-fg:    #b45309;
            --tag-amber-border:#fde68a;
            --tag-blue-bg:     #eff6ff;
            --tag-blue-fg:     #1d4ed8;
            --tag-blue-border: #bfdbfe;
            --tag-red-bg:      #fef2f2;
            --tag-red-fg:      #b91c1c;
            --tag-red-border:  #fecaca;
            --tag-gray-bg:     #f4f4f5;
            --tag-gray-fg:     #52525b;
            --tag-gray-border: #d4d4d8;
        }

        /* ── Dark Mode Tokens ── */
        .dark {
            --bg:              #1a1a1a;
            --sidebar:         #111111;
            --sidebar-border:  #2a2a2a;
            --surface:         #1f1f1f;
            --surface-2:       #262626;
            --border:          #2a2a2a;
            --text-1:          #fafafa;
            --text-2:          #a1a1aa;
            --text-3:          #52525b;
            --accent:          #ffffff;
            --accent-fg:       #000000;
            --active-bg:       #262626;
            --active-border:   #333333;
            --tag-green-bg:    #052e16;
            --tag-green-fg:    #4ade80;
            --tag-green-border:#166534;
            --tag-amber-bg:    #1c1400;
            --tag-amber-fg:    #fbbf24;
            --tag-amber-border:#78350f;
            --tag-blue-bg:     #0f1f3d;
            --tag-blue-fg:     #93c5fd;
            --tag-blue-border: #1e3a8a;
            --tag-red-bg:      #2d0a0a;
            --tag-red-fg:      #fca5a5;
            --tag-red-border:  #7f1d1d;
            --tag-gray-bg:     #27272a;
            --tag-gray-fg:     #a1a1aa;
            --tag-gray-border: #3f3f46;
        }

        html {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text-1);
            font-size: 13px;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transition: background .15s ease, color .15s ease;
            overflow-x: hidden;
        }

        /* ── Sidebar (220px) ── */
        .sidebar {
            width: 220px;
            min-width: 220px;
            min-height: 100vh;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
            overflow: hidden;
            transition: background .15s ease, border-color .15s ease;
        }

        .sidebar-top {
            height: 48px;
            padding: 0 14px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-sizing: border-box;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
        }
        .brand-icon {
            width: 26px;
            height: 26px;
            background: var(--text-1);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .brand-icon svg { width: 14px; height: 14px; color: var(--accent-fg); }
        .brand-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-1);
            letter-spacing: -0.01em;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 10px;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .nav-section {
            padding: 12px 8px 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-3);
        }

        /* ── Cekungkan sudut & tidak mentok kanan-kiri (Floating pill rounded) ── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            margin-bottom: 3px;
            border-radius: 8px;
            color: var(--text-2);
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all .15s ease;
            position: relative;
        }
        .nav-item:hover {
            background: var(--active-bg);
            color: var(--text-1);
        }
        .nav-item.active {
            background: var(--active-bg);
            color: var(--text-1);
            font-weight: 600;
            border-color: var(--active-border);
        }
        .nav-item svg { width: 15px; height: 15px; flex-shrink: 0; color: inherit; }

        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 999px;
            min-width: 16px;
            text-align: center;
        }

        .sidebar-bottom {
            padding: 10px 10px 12px;
            border-top: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 9px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface-2);
        }
        .user-ava {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--text-1);
            color: var(--accent-fg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-role-text {
            font-size: 10.5px;
            color: var(--text-3);
            text-transform: capitalize;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 6px 10px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-2);
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: all .12s;
            text-decoration: none;
            font-family: inherit;
        }
        .btn-logout:hover {
            background: var(--active-bg);
            color: var(--text-1);
            border-color: var(--text-2);
        }

        /* ── Main Layout ── */
        .main {
            flex: 1;
            margin-left: 220px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ── Topbar (48px Kravio minimal) ── */
        .topbar {
            height: 48px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            background: var(--sidebar);
            position: sticky;
            top: 0;
            z-index: 40;
            box-sizing: border-box;
            transition: background .15s ease, border-color .15s ease;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--text-3);
        }
        .breadcrumb .separator { color: var(--text-3); opacity: 0.6; }
        .breadcrumb .current { color: var(--text-1); font-weight: 600; }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text-2);
            padding: 4px 9px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--surface-2);
        }
        .date-chip svg { width: 13px; height: 13px; color: var(--text-3); }

        .theme-toggle-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-2);
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--surface);
            font-size: 13px;
            transition: background .12s, border-color .12s;
        }
        .theme-toggle-btn:hover {
            background: var(--active-bg);
            color: var(--text-1);
        }

        /* ── Content Canvas ── */
        .content {
            flex: 1;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: var(--bg);
        }

        /* ── Page Header ── */
        .page-hd {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-1);
            letter-spacing: -0.02em;
            line-height: 1.25;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .page-sub {
            font-family: 'Poppins', sans-serif;
            font-size: 12.5px;
            font-weight: 400;
            color: var(--text-3);
            margin-top: 3px;
            letter-spacing: 0.01em;
        }

        /* ── Clean Flat Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            transition: border-color .15s ease;
        }
        .card-header, .table-card-header {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }
        .card-title, .table-card-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-1);
        }
        .card-sub, .table-card-sub {
            font-family: 'Poppins', sans-serif;
            font-size: 11.5px;
            font-weight: 400;
            color: var(--text-3);
            margin-top: 1px;
        }
        .card-body { padding: 16px; }

        /* ── Kravio Stat Cards ── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            position: relative;
        }
        .stat-card::before { display: none !important; }
        .stat-label {
            font-size: 11.5px;
            color: var(--text-3);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 500;
            text-transform: none;
            letter-spacing: normal;
        }
        .stat-label svg { width: 14px; height: 14px; color: var(--text-3); }
        .stat-val, .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-1);
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 0;
        }
        .stat-footer {
            font-size: 11px;
            margin-top: 8px;
            color: var(--text-3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
        }
        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }
        .stat-chip-green { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }
        .stat-chip-blue  { background: var(--tag-blue-bg);  color: var(--tag-blue-fg);  border: 1px solid var(--tag-blue-border); }
        .stat-chip-amber { background: var(--tag-amber-bg); color: var(--tag-amber-fg); border: 1px solid var(--tag-amber-border); }
        .stat-chip-rose  { background: var(--tag-red-bg);   color: var(--tag-red-fg);   border: 1px solid var(--tag-red-border); }

        /* Action card */
        .action-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            transition: border-color .15s;
        }
        .action-card:hover {
            border-color: var(--text-2);
        }
        .action-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            color: var(--text-1);
        }
        .action-icon-wrap svg { width: 16px; height: 16px; color: var(--text-1); }

        /* ── Tables ── */
        .table-wrap, .tbl-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            text-align: left;
            padding: 9px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-3);
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
            white-space: nowrap;
        }
        tbody td {
            padding: 10px 14px;
            font-size: 12.5px;
            color: var(--text-1);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--active-bg); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 13px;
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            white-space: nowrap;
            line-height: 1;
            transition: all .12s;
        }
        .btn svg { width: 13px; height: 13px; flex-shrink: 0; }
        .btn-primary {
            background: var(--text-1);
            color: var(--accent-fg);
            border-color: var(--text-1);
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .btn-secondary {
            background: var(--surface);
            color: var(--text-1);
            border-color: var(--border);
        }
        .btn-secondary:hover {
            background: var(--active-bg);
        }
        .btn-ghost {
            background: transparent;
            color: var(--text-2);
            border-color: var(--border);
        }
        .btn-ghost:hover {
            background: var(--active-bg);
            color: var(--text-1);
        }
        .btn-danger {
            background: var(--tag-red-bg);
            color: var(--tag-red-fg);
            border-color: var(--tag-red-border);
        }
        .btn-danger:hover {
            background: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
        }
        .btn-warning {
            background: var(--tag-amber-bg);
            color: var(--tag-amber-fg);
            border-color: var(--tag-amber-border);
        }
        .btn-info {
            background: var(--tag-blue-bg);
            color: var(--tag-blue-fg);
            border-color: var(--tag-blue-border);
        }
        .btn-sm { padding: 5px 10px; font-size: 11.5px; border-radius: 5px; }
        .btn-xs { padding: 3px 8px; font-size: 11px; border-radius: 4px; }

        /* ── Forms ── */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 6px;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 8px 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-1);
            font-size: 12.5px;
            font-family: inherit;
            transition: border-color .15s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--text-1);
        }
        .form-textarea { min-height: 80px; resize: vertical; }
        .form-error { font-size: 11.5px; color: #ef4444; margin-top: 4px; }

        /* ── Badges / Tags ── */
        .badge, .role-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 4px;
            white-space: nowrap;
        }
        .badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .badge-draft      { background: var(--tag-gray-bg);  color: var(--tag-gray-fg);  border: 1px solid var(--tag-gray-border); }
        .badge-diajukan   { background: var(--tag-amber-bg); color: var(--tag-amber-fg); border: 1px solid var(--tag-amber-border); }
        .badge-disetujui  { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }
        .badge-ditolak    { background: var(--tag-red-bg);   color: var(--tag-red-fg);   border: 1px solid var(--tag-red-border); }
        .badge-disalurkan { background: var(--tag-blue-bg);  color: var(--tag-blue-fg);  border: 1px solid var(--tag-blue-border); }
        .badge-aktif      { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }
        .badge-nonaktif   { background: var(--tag-red-bg);   color: var(--tag-red-fg);   border: 1px solid var(--tag-red-border); }
        .badge-masuk      { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }
        .badge-keluar     { background: var(--tag-red-bg);   color: var(--tag-red-fg);   border: 1px solid var(--tag-red-border); }

        .role-pimpinan { background: var(--tag-amber-bg); color: var(--tag-amber-fg); border: 1px solid var(--tag-amber-border); }
        .role-admin    { background: var(--tag-blue-bg);  color: var(--tag-blue-fg);  border: 1px solid var(--tag-blue-border); }
        .role-petugas  { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }

        /* ── Alerts ── */
        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 12.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .alert-success { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }
        .alert-error   { background: var(--tag-red-bg);   color: var(--tag-red-fg);   border: 1px solid var(--tag-red-border); }
        .alert-warning { background: var(--tag-amber-bg); color: var(--tag-amber-fg); border: 1px solid var(--tag-amber-border); }

        /* ── Empty State ── */
        .empty-state { text-align: center; padding: 36px 16px; }
        .empty-state-icon {
            width: 44px; height: 44px; border-radius: 8px;
            background: var(--surface-2); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; color: var(--text-3);
        }
        .empty-state h3 { font-size: 13.5px; font-weight: 600; color: var(--text-1); margin-bottom: 3px; }
        .empty-state p { font-size: 12px; color: var(--text-3); }

        /* ── Grids & Utilities ── */
        .grid { display: grid; gap: 14px; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }
        @media (max-width: 1100px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 800px) {
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .main { margin-left: 0; }
        }

        .flex { display: flex; }
        .flex-wrap { flex-wrap: wrap; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 6px; }
        .gap-3 { gap: 10px; }
        .gap-4 { gap: 14px; }
        .mb-2 { margin-bottom: 6px; }
        .mb-4 { margin-bottom: 12px; }
        .mb-6 { margin-bottom: 18px; }
        .mt-4 { margin-top: 12px; }
        .p-4 { padding: 14px; }
        .p-6 { padding: 20px; }
        .text-right { text-align: right; }
        .w-full { width: 100%; }

        /* ── Pagination Styling ── */
        nav[role="navigation"] {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            font-size: 12px;
            color: var(--text-2);
            flex-wrap: wrap;
            gap: 10px;
        }
        nav[role="navigation"] svg { width: 14px; height: 14px; }
        nav[role="navigation"] a, nav[role="navigation"] span {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-1);
            text-decoration: none;
            font-size: 12px;
        }
        nav[role="navigation"] a:hover {
            background: var(--active-bg);
            border-color: var(--active-border);
        }
        nav[role="navigation"] span[aria-current="page"] {
            background: var(--text-1);
            color: var(--accent-fg);
            border-color: var(--text-1);
            font-weight: 700;
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $authUser = Auth::user() ?? new \App\Models\User(['name' => 'Riyan Saefuloh', 'role' => 'admin']);
    @endphp
    <!-- Sidebar (220px) -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <a href="{{ route('penamas.dashboard') }}" class="brand">
                <div class="brand-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="brand-name">PENAMAS</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Utama</div>
            <a href="{{ route('penamas.dashboard') }}" class="nav-item {{ request()->routeIs('penamas.dashboard') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>

            @if($authUser->canManage())
            <div class="nav-section">Pengelolaan</div>
            <a href="{{ route('penamas.pengguna.index') }}" class="nav-item {{ request()->routeIs('penamas.pengguna.*') || request()->routeIs('users.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('penamas.penerima.index') }}" class="nav-item {{ request()->routeIs('penamas.penerima.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Data Penerima</span>
            </a>
            <a href="{{ route('penamas.paket-bantuan.index') }}" class="nav-item {{ request()->routeIs('penamas.paket-bantuan.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Paket Bantuan</span>
            </a>
            <a href="{{ route('penamas.stok.index') }}" class="nav-item {{ request()->routeIs('penamas.stok.index') || request()->routeIs('penamas.stok.create') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>Stok Bantuan</span>
            </a>
            <a href="{{ route('penamas.stok.mutasi') }}" class="nav-item {{ request()->routeIs('penamas.stok.mutasi*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Riwayat Mutasi</span>
            </a>
            @endif

            <div class="nav-section">Penyaluran Bantuan</div>
            @if($authUser->canManage())
            <a href="{{ route('penamas.distribusi.index') }}" class="nav-item {{ request()->routeIs('penamas.distribusi.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Rencana Distribusi</span>
                @php $pendingCount = \Illuminate\Support\Facades\Schema::hasTable('distribusi') ? \App\Models\Distribusi::where('status', 'diajukan')->count() : 0; @endphp
                @if($pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            @endif

            <a href="{{ route('penamas.penyaluran.index') }}" class="nav-item {{ request()->routeIs('penamas.penyaluran.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                <span>{{ $authUser->isPetugas() ? 'Tugas Penyaluran' : 'Penyaluran Bantuan' }}</span>
                @php
                    $myTaskCount = 0;
                    if (\Illuminate\Support\Facades\Schema::hasTable('distribusi')) {
                        if ($authUser->isPetugas() && $authUser->exists) {
                            $myTaskCount = $authUser->distribusiDitugaskan()->where('status', 'disetujui')->count();
                        } else {
                            $myTaskCount = \App\Models\Distribusi::where('status', 'disetujui')->count();
                        }
                    }
                @endphp
                @if($myTaskCount > 0)
                    <span class="nav-badge" style="background: #15803d;">{{ $myTaskCount }}</span>
                @endif
            </a>

            @if($authUser->canManage())
            <div class="nav-section">Pelaporan</div>
            <a href="{{ route('penamas.laporan.index') }}" class="nav-item {{ request()->routeIs('penamas.laporan.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Laporan</span>
            </a>
            @endif
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="user-ava">{{ strtoupper(substr($authUser->name ?? 'U', 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ $authUser->name ?? 'Pengguna' }}</div>
                    <div class="user-role-text">{{ $authUser->role ?? 'Petugas' }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Keluar Sesi</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main">
        <header class="topbar">
            <div class="breadcrumb">
                <span>PENAMAS</span>
                <span class="separator">›</span>
                <span class="current">@yield('page-title', 'Dashboard')</span>
            </div>

            <!-- Topbar Actions: Hanya Tanggal & Tombol Mode Gelap/Terang -->
            <div class="topbar-actions">
                <div class="date-chip">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ date('d M Y') }}</span>
                </div>

                <!-- Dark / Light Theme Toggle -->
                <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Ganti Mode Gelap / Terang">
                    <span id="themeToggleIcon">🌙</span>
                </button>
            </div>
        </header>

        <main class="content">
            <div class="page-hd">
                <div class="page-hd-left">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-sub">@yield('page-subtitle', 'Sistem Pengendalian & Distribusi Bantuan Pangan Terpadu')</p>
                </div>
                @yield('page-actions')
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Theme toggle script -->
    <script>
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeToggleIcon');

        function updateIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            themeIcon.textContent = isDark ? '☀️' : '🌙';
        }

        updateIcon();

        themeBtn.addEventListener('click', function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('penamas_theme', isDark ? 'dark' : 'light');
            updateIcon();
        });
    </script>

    @stack('scripts')
</body>
</html>
