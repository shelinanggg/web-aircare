@extends('layouts.app')
@section('title', 'Data Barang')
@section('page-title', 'Data Barang / Kelola Barang Tertinggal')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Barang</h1>
        <p class="page-subtitle">Semua barang tertinggal yang tercatat di sistem</p>
    </div>
    <a href="{{ route('items.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Catat Barang Baru
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('items.index') }}">
    <div class="filters-bar">
        <div class="search-wrapper">
            <span class="search-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" name="search" placeholder="Cari nama, kode QR, deskripsi..." class="search-input" value="{{ request('search') }}">
        </div>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="found"    {{ request('status') == 'found'    ? 'selected' : '' }}>Ditemukan</option>
            <option value="claimed"  {{ request('status') == 'claimed'  ? 'selected' : '' }}>Diambil</option>
            <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Dimusnahkan</option>
        </select>
        <select name="campus" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Kampus</option>
            <option value="kampus-a" {{ request('campus') == 'kampus-a' ? 'selected' : '' }}>Kampus A</option>
            <option value="kampus-b" {{ request('campus') == 'kampus-b' ? 'selected' : '' }}>Kampus B</option>
            <option value="kampus-c" {{ request('campus') == 'kampus-c' ? 'selected' : '' }}>Kampus C</option>
        </select>
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <option value="electronics"  {{ request('category') == 'electronics'  ? 'selected' : '' }}>Elektronik</option>
            <option value="documents"    {{ request('category') == 'documents'    ? 'selected' : '' }}>Dokumen</option>
            <option value="accessories"  {{ request('category') == 'accessories'  ? 'selected' : '' }}>Aksesori</option>
            <option value="bags"         {{ request('category') == 'bags'         ? 'selected' : '' }}>Tas & Dompet</option>
            <option value="clothing"     {{ request('category') == 'clothing'     ? 'selected' : '' }}>Pakaian</option>
            <option value="other"        {{ request('category') == 'other'        ? 'selected' : '' }}>Lainnya</option>
        </select>
        @if(request()->anyFilled(['search','status','campus','category']))
            <a href="{{ route('items.index') }}" class="btn btn-ghost btn-sm">Reset</a>
        @endif
        <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
    </div>
</form>

<div class="card" style="padding: 0;">
    <div class="table-wrapper" style="border: none;">
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
                    <td><span class="qr-code">{{ $item->qr_code }}</span></td>
                    <td>
                        <a href="{{ route('items.show', $item) }}" style="color:var(--text-primary); text-decoration:none; font-weight:500;">
                            {{ $item->name }}
                        </a>
                        @if($item->description)
                        <div style="font-size:0.7rem; color:var(--text-muted); margin-top:2px;">{{ Str::limit($item->description, 40) }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-default">{{ $item->category_label }}</span>
                    </td>
                    <td style="font-size:0.8rem; color:var(--text-muted);">{{ $item->campus_label }}</td>
                    <td style="font-size:0.8rem; color:var(--text-muted);">{{ $item->location_detail ?: '—' }}</td>
                    <td style="font-size:0.8rem;">{{ $item->found_date->format('d M Y') }}</td>
                    <td><span class="badge {{ $item->status_badge['class'] }}">{{ $item->status_badge['label'] }}</span></td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-ghost btn-sm">Detail</a>
                            @if($item->status === 'found')
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-secondary btn-sm">Edit</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:48px; color:var(--text-muted);">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px; display:block; opacity:0.3;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Tidak ada barang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $items->links('vendor.pagination.custom') }}
@endsection
