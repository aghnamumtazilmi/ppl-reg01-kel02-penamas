<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login PENAMAS - Penyaluran Bantuan Masyarakat Kabupaten Banyumas">
    <title>Masuk — PENAMAS</title>

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

        :root {
            --bg:              #ffffff; /* Background putih semua */
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
            --tag-green-bg:    #f0fdf4;
            --tag-green-fg:    #15803d;
            --tag-green-border:#bbf7d0;
            --tag-amber-bg:    #fffbeb;
            --tag-amber-fg:    #b45309;
            --tag-amber-border:#fde68a;
            --tag-blue-bg:     #eff6ff;
            --tag-blue-fg:     #1d4ed8;
            --tag-blue-border: #bfdbfe;
        }

        .dark {
            --bg:              #121212;
            --sidebar:         #1a1a1a;
            --sidebar-border:  #262626;
            --surface:         #1e1e1e;
            --surface-2:       #262626;
            --border:          #2e2e2e;
            --text-1:          #fafafa;
            --text-2:          #a1a1aa;
            --text-3:          #52525b;
            --accent:          #ffffff;
            --accent-fg:       #000000;
            --active-bg:       #2a2a2a;
            --tag-green-bg:    #052e16;
            --tag-green-fg:    #4ade80;
            --tag-green-border:#166534;
            --tag-amber-bg:    #1c1400;
            --tag-amber-fg:    #fbbf24;
            --tag-amber-border:#78350f;
            --tag-blue-bg:     #0f1f3d;
            --tag-blue-fg:     #93c5fd;
            --tag-blue-border: #1e3a8a;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text-1);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            transition: background .15s ease, color .15s ease;
            position: relative;
        }

        /* ── Tombol Mode Gelap/Terang Floating di Pojok Kanan Atas ── */
        .theme-toggle-fixed {
            position: fixed;
            top: 24px;
            right: 28px;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-2);
            font-size: 13px;
            z-index: 50;
            transition: all .15s ease;
        }
        .theme-toggle-fixed:hover {
            background: var(--active-bg);
            color: var(--text-1);
        }

        /* ── Wrapper & Container: Mepet Tengah ── */
        .login-wrapper {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
        }

        .login-container {
            width: 100%;
            max-width: 960px; /* Lebar terpusat di tengah */
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            gap: 60px; /* Jarak pas antar kolom di tengah */
            align-items: center;
        }

        /* ── Left: Informasi Sistem & Branding ── */
        .login-left {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 420px;
            padding: 8px 0;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--text-1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-fg);
            flex-shrink: 0;
        }
        .brand-icon svg { width: 17px; height: 17px; }
        .brand-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-1);
            letter-spacing: -0.01em;
        }

        .left-center {
            padding: 36px 0;
        }

        .left-headline {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-1);
            letter-spacing: -0.03em;
            line-height: 1.3;
            margin-bottom: 14px;
        }
        .left-desc {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: var(--text-2);
            line-height: 1.65;
            font-weight: 400;
        }

        .left-footer {
            padding-top: 18px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-3);
        }
        .footer-name {
            font-weight: 600;
            color: var(--text-2);
        }

        /* ── Right: Card Login ── */
        .login-right {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        /* Kotak Card Form dengan Sudut Melengkung */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 34px 30px;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
            transition: border-color .15s ease, background .15s ease;
        }

        .form-header {
            margin-bottom: 22px;
        }
        .form-title {
            font-size: 21px;
            font-weight: 700;
            color: var(--text-1);
            letter-spacing: -0.02em;
        }
        .form-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: 12.5px;
            color: var(--text-3);
            margin-top: 4px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 6px;
        }
        .input-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 8px 12px;
            transition: all .15s ease;
        }
        .input-wrap:focus-within {
            border-color: var(--text-1);
            background: var(--surface);
        }
        .input-wrap svg {
            width: 14px;
            height: 14px;
            color: var(--text-3);
            flex-shrink: 0;
        }
        .input-field {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--text-1);
        }
        .input-field::placeholder {
            color: var(--text-3);
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            font-size: 12px;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-2);
            cursor: pointer;
            user-select: none;
        }
        .checkbox-label input {
            accent-color: var(--text-1);
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            background: var(--text-1);
            color: var(--accent-fg);
            border: 1px solid var(--text-1);
            cursor: pointer;
            transition: opacity .12s, transform .12s;
        }
        .btn-submit:hover {
            opacity: 0.92;
        }
        .btn-submit:active {
            transform: scale(0.99);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 9px 12px;
            border-radius: 7px;
            font-size: 12px;
            margin-bottom: 16px;
        }
        .dark .alert-error {
            background: #2d0a0a;
            border-color: #7f1d1d;
            color: #fca5a5;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 9px 12px;
            border-radius: 7px;
            font-size: 12px;
            margin-bottom: 16px;
        }

        /* ── Box Akun Demo ── */
        .demo-box {
            margin-top: 22px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }
        .demo-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .demo-title {
            font-size: 10.5px;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 700;
        }
        .demo-hint {
            font-size: 10.5px;
            color: var(--text-3);
        }
        .demo-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .demo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--surface-2);
            font-size: 11.5px;
            cursor: pointer;
            user-select: none;
            transition: all .12s ease;
        }
        .demo-item:hover {
            background: var(--active-bg);
            border-color: var(--text-3);
        }
        .role-tag {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .role-pimpinan { background: var(--tag-amber-bg); color: var(--tag-amber-fg); border: 1px solid var(--tag-amber-border); }
        .role-admin    { background: var(--tag-blue-bg);  color: var(--tag-blue-fg);  border: 1px solid var(--tag-blue-border); }
        .role-petugas  { background: var(--tag-green-bg); color: var(--tag-green-fg); border: 1px solid var(--tag-green-border); }

        @media (max-width: 860px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 420px;
                gap: 32px;
            }
            .login-left {
                min-height: auto;
                text-align: center;
                align-items: center;
            }
            .brand-header {
                justify-content: center;
            }
            .left-footer {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button type="button" class="theme-toggle-fixed" id="themeToggleBtn" title="Ganti Mode Gelap / Terang">
        <span id="themeToggleIcon">🌙</span>
    </button>

    <div class="login-wrapper">
        <div class="login-container">
            <!-- Panel Kiri: Informasi Sistem & Branding -->
            <div class="login-left">
                <div class="brand-header">
                    <div class="brand-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="brand-title">PENAMAS</span>
                </div>

                <div class="left-center">
                    <div class="left-headline">
                        Sistem Pengendalian<br>& Distribusi Bantuan
                    </div>
                    <p class="left-desc">
                        Platform administrasi terpadu untuk pendataan penerima manfaat, verifikasi rencana distribusi, dan pelaporan realisasi bantuan pangan masyarakat Kabupaten Banyumas.
                    </p>
                </div>

                <div class="left-footer">
                    <span class="footer-name">PENAMAS</span>
                    <span>Penyaluran Bantuan Masyarakat</span>
                </div>
            </div>

            <!-- Panel Kanan: Kotak Form Login -->
            <div class="login-right">
                <div class="login-card">
                    <div class="form-header">
                        <h1 class="form-title">Masuk ke Sistem</h1>
                        <p class="form-subtitle">Masukkan akun Anda untuk melanjutkan ke dashboard.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" id="loginForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="email">Alamat Email *</label>
                            <div class="input-wrap">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <input type="email" id="email" name="email" class="input-field" placeholder="nama@instansi.go.id" value="{{ old('email', 'admin@penamas.test') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">Kata Sandi *</label>
                            <div class="input-wrap">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" value="password" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Tetap masuk</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-submit">
                            Masuk
                        </button>
                    </form>

                    <!-- Akun Demo Pengujian -->
                    <div class="demo-box">
                        <div class="demo-title-row">
                            <span class="demo-title">Akun Demo Pengujian</span>
                            <span class="demo-hint">Klik untuk isi cepat</span>
                        </div>
                        <div class="demo-list">
                            <div class="demo-item" onclick="fillAccount('pimpinan@penamas.test', 'password')" title="Klik untuk gunakan akun Pimpinan">
                                <span style="color: var(--text-2);">pimpinan@penamas.test</span>
                                <span class="role-tag role-pimpinan">Pimpinan</span>
                            </div>
                            <div class="demo-item" onclick="fillAccount('admin@penamas.test', 'password')" title="Klik untuk gunakan akun Admin">
                                <span style="color: var(--text-2);">admin@penamas.test</span>
                                <span class="role-tag role-admin">Admin</span>
                            </div>
                            <div class="demo-item" onclick="fillAccount('petugas@penamas.test', 'password')" title="Klik untuk gunakan akun Petugas">
                                <span style="color: var(--text-2);">petugas@penamas.test</span>
                                <span class="role-tag role-petugas">Petugas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillAccount(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

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
</body>
</html>
