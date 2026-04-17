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
            <a href="{{ route('home') }}" class="public-brand">
                <img src="https://arsip.unair.ac.id/wp-content/uploads/2019/01/cropped-logo-unair-1.png" alt="Logo UNAIR" style="height: 38px; width: auto; object-fit: contain;">
                <span>AIRCARE</span>
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
            <div class="footer-text">Universitas Airlangga · Kampus A, B & C</div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>