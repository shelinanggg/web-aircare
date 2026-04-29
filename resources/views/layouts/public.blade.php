<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIRCARE – @yield('title', 'Airlangga Library Care & Return Service')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="public-layout">
    <nav class="public-nav">
        <div class="public-nav-inner">
            
            {{-- Modifikasi Bagian Brand (Logo & Teks) --}}
            <a href="{{ route('home') }}" class="public-brand" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <img src="https://arsip.unair.ac.id/wp-content/uploads/2019/01/cropped-logo-unair-1.png" alt="Logo UNAIR" style="height: 38px; width: auto; object-fit: contain;">
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-weight: 800; font-size: 1.15rem; color: var(--unair-blue, #004e9a); line-height: 1.1;">AIRCARE</span>
                    <span style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted, #64748b); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">Airlangga Library Care & Return Service</span>
                </div>
            </a>

            <div class="public-nav-links">
                <a href="{{ route('items.public') }}">Cari Barang</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-primary">Login Staff</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="public-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <strong>AIRCARE</strong> — Airlangga Library Care & Return Service
            </div>
            <div class="footer-text">Perpustakaan Universitas Airlangga</div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>