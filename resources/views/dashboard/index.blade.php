@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Ringkasan sistem pengelolaan barang tertinggal AIRCARE</p>
    </div>
    <a href="{{ route('items.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Catat Barang Baru
    </a>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            Total Barang
        </div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-sub">Semua kampus</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Belum Diambil
        </div>
        <div class="stat-value" style="color: var(--teal);">{{ $stats['found'] }}</div>
        <div class="stat-sub">Menunggu pemilik</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            Sudah Diambil
        </div>
        <div class="stat-value" style="color: var(--green);">{{ $stats['claimed'] }}</div>
        <div class="stat-sub">Dikembalikan ke pemilik</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></polyline></svg>
            Dimusnahkan
        </div>
        <div class="stat-value" style="color: var(--orange);">{{ $stats['disposed'] }}</div>
        <div class="stat-sub">Kadaluarsa / donasi</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">

    {{-- Campus Distribution --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Barang Per Kampus
            </div>
            <div class="card-desc">Distribusi barang yang belum diambil</div>
        </div>
        <div class="campus-grid">
            @foreach(['kampus-a' => 'Kampus A', 'kampus-b' => 'Kampus B', 'kampus-c' => 'Kampus C'] as $key => $label)
            <div class="campus-card">
                <div class="campus-card-count">{{ $byCampus[$key] ?? 0 }}</div>
                <div class="campus-card-name">{{ $label }}</div>
            </div>
            @endforeach
        </div>

        @if($stats['found'] > 0)
        <div style="margin-top: 16px;">
            @foreach(['kampus-a' => 'Kampus A', 'kampus-b' => 'Kampus B', 'kampus-c' => 'Kampus C'] as $key => $label)
            <div style="margin-bottom: 10px;">
                <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:4px;">
                    <span style="color:var(--text-muted)">{{ $label }}</span>
                    <span>{{ $byCampus[$key] ?? 0 }}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stats['found'] > 0 ? round((($byCampus[$key] ?? 0) / $stats['found']) * 100) : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Recent Activity --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Aktivitas Terbaru
            </div>
            <div class="card-desc">Log aktivitas sistem</div>
        </div>
        <div class="activity-list">
            @forelse($recentLogs as $log)
            <div class="activity-item">
                <div class="activity-dot"></div>
                <div>
                    <div class="activity-text">{{ $log->description }}</div>
                    <div class="activity-time">
                        {{ $log->created_at->diffForHumans() }}
                        @if($log->user) · {{ $log->user->name }} @endif
                    </div>
                </div>
            </div>
            @empty
            <p style="color: var(--text-muted); font-size: 0.8rem; text-align: center; padding: 20px 0;">
                Belum ada aktivitas
            </p>
            @endforelse
        </div>
    </div>
</div>

{{-- Recent Items --}}
<div class="card">
    <div class="card-header" style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div class="card-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                Barang Terbaru
            </div>
            <div class="card-desc">5 barang terakhir yang dicatat</div>
        </div>
        <a href="{{ route('items.index') }}" class="btn btn-ghost btn-sm">Lihat Semua →</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>QR Code</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Kampus</th>
                    <th>Tanggal Temuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentItems as $item)
                <tr style="cursor:pointer;" onclick="window.location='{{ route('items.show', $item) }}'">
                    <td><span class="qr-code">{{ $item->qr_code }}</span></td>
                    <td style="font-weight:500;">{{ $item->name }}</td>
                    <td>{{ $item->category_label }}</td>
                    <td>{{ $item->campus_label }}</td>
                    <td>{{ $item->found_date->format('d M Y') }}</td>
                    <td><span class="badge {{ $item->status_badge['class'] }}">{{ $item->status_badge['label'] }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--text-muted); padding:32px;">
                        Belum ada barang tercatat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
