<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIRCARE – @yield('title', 'Airlangga Library Care & Return Service')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="public-layout">
    <nav class="public-nav">
        <div class="public-nav-inner">
            <a href="{{ route('home') }}" class="public-brand">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <rect width="28" height="28" rx="8" fill="#00BFA5"/>
                    <path d="M7 10l7-4 7 4v8l-7 4-7-4V10z" stroke="white" stroke-width="1.5" fill="none"/>
                    <path d="M14 6v16M7 10l7 4 7-4" stroke="white" stroke-width="1.5"/>
                </svg>
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
