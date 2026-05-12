<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        AIRCARE - @yield('title', 'Airlangga Library Care & Return Service')
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>

<body>

<div class="layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        {{-- BRAND --}}
        <div class="sidebar-brand">

            <div class="brand-icon">
                <img
                    src="https://arsip.unair.ac.id/wp-content/uploads/2019/01/cropped-logo-unair-1.png"
                    alt="Logo UNAIR"
                    style="width:36px; height:auto; object-fit:contain; border-radius:4px;"
                >
            </div>

            <div>
                <div class="brand-name">AIRCARE</div>

                <div class="brand-sub">
                    Airlangga Library Care & Return Service
                </div>
            </div>

        </div>

        {{-- NAVIGATION --}}
        <nav class="sidebar-nav">

            {{-- MENU UTAMA --}}
            <div class="nav-section-label">
                Menu Utama
            </div>

            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <svg width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     style="flex-shrink:0; min-width:18px;">

                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>

                </svg>

                <span>Dashboard</span>
            </a>

            {{-- DATA BARANG --}}
            <a href="{{ route('items.index') }}"
               class="nav-item {{ request()->routeIs('items.*') && !request()->routeIs('items.public') ? 'active' : '' }}">

                <svg width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     style="flex-shrink:0; min-width:18px;">

                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>

                </svg>

                <span>Data Barang</span>
            </a>

            {{-- CATAT BARANG --}}
            <a href="{{ route('items.create') }}"
               class="nav-item {{ request()->routeIs('items.create') ? 'active' : '' }}">

                <svg width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     style="flex-shrink:0; min-width:18px;">

                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>

                </svg>

                <span>Catat Barang</span>
            </a>

            {{-- ADMIN ONLY --}}
            @if(auth()->user()->isAdmin())

                <div class="nav-section-label" style="margin-top:1.5rem;">
                    Master Data
                </div>

                {{-- MASTER KATEGORI --}}
                <a href="{{ route('categories.index') }}"
                   class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">

                    <svg width="18"
                         height="18"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         style="flex-shrink:0; min-width:18px;">

                        <circle cx="12" cy="12" r="3"/>

                        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09A1.65 1.65 0 0015 4.6a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9c.2.49.76.83 1.51.83H21a2 2 0 110 4h-.09c-.75 0-1.31.34-1.51 1z"/>

                    </svg>

                    <span>Master Kategori</span>
                </a>

                {{-- MASTER USER --}}
                <a href="{{ route('users.index') }}"
                   class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">

                    <svg width="18"
                         height="18"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         style="flex-shrink:0; min-width:18px;">

                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>

                        <circle cx="9" cy="7" r="4"/>

                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>

                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                    </svg>

                    <span>Master User</span>
                </a>

            @endif

            {{-- PUBLIK --}}
            <div class="nav-section-label" style="margin-top:1.5rem;">
                Publik
            </div>

            {{-- CARI BARANG --}}
            <a href="{{ route('items.public') }}"
               class="nav-item {{ request()->routeIs('items.public') ? 'active' : '' }}">

                <svg width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     style="flex-shrink:0; min-width:18px;">

                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>

                </svg>

                <span>Cari Barang</span>
            </a>

            {{-- BERANDA --}}
            <a href="{{ route('home') }}"
               class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">

                <svg width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     style="flex-shrink:0; min-width:18px;">

                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>

                </svg>

                <span>Beranda</span>
            </a>

        </nav>

        {{-- USER --}}
        <div class="sidebar-user">

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <div class="user-info">

                <div class="user-name">
                    {{ auth()->user()->name }}
                </div>

                <div class="user-role">
                    {{ auth()->user()->role_label }}
                </div>

            </div>

            <form action="{{ route('logout') }}"
                  method="POST"
                  style="margin:0;">

                @csrf

                <button type="submit"
                        class="logout-btn"
                        title="Keluar">

                    <svg width="16"
                         height="16"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>

                    </svg>

                </button>

            </form>

        </div>

    </aside>

    {{-- MAIN --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <header class="topbar">

            <button class="menu-toggle"
                    id="menuToggle"
                    onclick="toggleSidebar()">

                <svg width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>

                </svg>

            </button>

            <div class="topbar-title">
                @yield('page-title', 'AIRCARE')
            </div>

            <div class="topbar-right">

                <div class="campus-badge">

                    <svg width="14"
                         height="14"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>

                    </svg>

                    {{ auth()->user()->campus_label }}

                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <main class="content">

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif

            @if(session('error'))

                <div class="alert alert-error">
                    {{ session('error') }}
                </div>

            @endif

            @yield('content')

        </main>

    </div>

</div>

<script>

function toggleSidebar()
{
    document
        .getElementById('sidebar')
        .classList
        .toggle('open');
}

</script>

@stack('scripts')

</body>
</html>