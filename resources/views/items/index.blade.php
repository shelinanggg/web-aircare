@extends('layouts.app')
@section('title', 'Data Barang')
@section('page-title', 'Data Barang / Kelola Barang Tertinggal')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Barang</h1>
        <p class="page-subtitle">Semua barang tertinggal yang tercatat di sistem</p>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <button type="button" class="btn btn-secondary" onclick="openScanner()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                <path d="M21 7V5a2 2 0 0 0-2-2h-2"/>
                <path d="M3 17v2a2 2 0 0 0 2 2h2"/>
                <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                <line x1="7" y1="12" x2="17" y2="12"/>
            </svg>
            Scan QR
        </button>

        <a href="{{ route('items.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Catat Barang Baru
        </a>
    </div>
</div>

<form method="GET" action="{{ route('items.index') }}">
    <div class="filters-bar">
        <div class="search-wrapper">
            <span class="search-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </span>
            <input
                type="text"
                name="search"
                placeholder="Cari nama, kode QR, deskripsi..."
                class="search-input"
                value="{{ request('search') }}"
            >
        </div>

        {{-- Filter Tanggal --}}
        <input 
            type="date" 
            name="date" 
            class="filter-select" 
            onchange="this.form.submit()"
            value="{{ request('date') }}" 
            title="Tanggal Ditemukan"
            style="color: var(--text-secondary);"
        >

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="found" {{ request('status') == 'found' ? 'selected' : '' }}>Ditemukan</option>
            <option value="claimed" {{ request('status') == 'claimed' ? 'selected' : '' }}>Diambil</option>
            <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Dimusnahkan</option>
            <option value="donated" {{ request('status') == 'donated' ? 'selected' : '' }}>Dihibahkan</option>
            <option value="handed_over" {{ request('status') == 'handed_over' ? 'selected' : '' }}>Diserahkan ke DITPILAR</option>
        </select>

        <select name="campus" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Kampus</option>
            <option value="kampus-a" {{ request('campus') == 'kampus-a' ? 'selected' : '' }}>Kampus A</option>
            <option value="kampus-b" {{ request('campus') == 'kampus-b' ? 'selected' : '' }}>Kampus B</option>
            <option value="kampus-c" {{ request('campus') == 'kampus-c' ? 'selected' : '' }}>Kampus C</option>
        </select>

        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <option value="valuable" {{ request('category') == 'valuable' ? 'selected' : '' }}>Barang Berharga</option>
            <option value="documents" {{ request('category') == 'documents' ? 'selected' : '' }}>Dokumen Berharga</option>
            <option value="electronics" {{ request('category') == 'electronics' ? 'selected' : '' }}>Barang Elektronik</option>
            <option value="personal" {{ request('category') == 'personal' ? 'selected' : '' }}>Barang Pribadi Umum</option>
            <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
        </select>

        {{-- Update array anyFilled agar mencakup 'date' --}}
        @if(request()->anyFilled(['search','status','campus','category','date']))
            <a href="{{ route('items.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif

        <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
    </div>
</form>

<div class="card" style="padding:0;">
    <div class="table-wrapper" style="border:none;">
        <table>
            <thead>
                <tr>
                    <th>QR Code</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Kampus</th>
                    <th>Lokasi</th>
                    <th>Tanggal Temuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        <span class="qr-code">{{ $item->qr_code }}</span>
                    </td>

                    <td>
                        <a href="{{ route('items.show', $item) }}"
                           style="color:var(--text-primary); text-decoration:none; font-weight:500;">
                            {{ $item->name }}
                        </a>

                        @if($item->description)
                            <div style="font-size:0.7rem; color:var(--text-muted); margin-top:2px;">
                                {{ Str::limit($item->description, 40) }}
                            </div>
                        @endif
                    </td>

                    <td>
                        <span class="badge badge-default">
                            {{ $item->category_label }}
                        </span>
                    </td>

                    <td style="font-size:0.8rem; color:var(--text-muted);">
                        {{ $item->campus_label }}
                    </td>

                    <td style="font-size:0.8rem; color:var(--text-muted);">
                        {{ $item->location_detail ?: '—' }}
                    </td>

                    <td style="font-size:0.8rem;">
                        {{ $item->found_date->format('d M Y') }}
                    </td>

                    <td>
                        <span class="badge {{ $item->status_badge['class'] }}">
                            {{ $item->status_badge['label'] }}
                        </span>
                    </td>

                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-ghost btn-sm">
                                Detail
                            </a>

                            @if($item->status === 'found')
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-secondary btn-sm">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:48px; color:var(--text-muted);">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                             style="margin:0 auto 12px; display:block; opacity:0.3;">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Tidak ada barang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $items->links('vendor.pagination.custom') }}

<div id="scannerModal" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.65);
    z-index:9999;
    align-items:center;
    justify-content:center;
    padding:20px;
">
    <div style="
        background:#fff;
        width:100%;
        max-width:520px;
        border-radius:16px;
        padding:20px;
        position:relative;
    ">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h3 style="margin:0;">Scan QR Code</h3>
            <button onclick="closeScanner()" class="btn btn-ghost btn-sm">Tutup</button>
        </div>

        <div id="reader" style="width:100%;"></div>

        <p style="font-size:13px; color:#666; margin-top:12px;">
            Arahkan kamera ke QR Code barang.
        </p>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let html5QrCode = null;

function openScanner() {
    const modal = document.getElementById('scannerModal');
    modal.style.display = 'flex';

    html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess
            );
        }
    }).catch(err => {
        alert('Kamera tidak tersedia.');
    });
}

function closeScanner() {
    const modal = document.getElementById('scannerModal');
    modal.style.display = 'none';

    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            html5QrCode.clear();
        }).catch(() => {});
    }
}

function onScanSuccess(decodedText) {
    window.location.href = "{{ url('/scan') }}/" + encodeURIComponent(decodedText);
}
</script>
@endsection