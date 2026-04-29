@extends('layouts.public')
@section('title', 'Cari Barang Hilang')

@section('content')
<div style="background: radial-gradient(ellipse 60% 40% at 50% -10%, rgba(0,78,154,0.08) 0%, transparent 60%), var(--bg-primary); padding: 60px 24px 40px;">
    <div style="max-width: 720px; margin: 0 auto; text-align: center;">
        <div style="display:inline-block; background:var(--unair-blue-dim); border:1px solid rgba(0,78,154,0.2); color:var(--unair-blue); font-size:0.75rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:6px 16px; border-radius:99px; margin-bottom:16px;">
            Barang Tertinggal
        </div>
        <h1 style="font-size:2.5rem; font-weight:800; margin-bottom:12px; color:var(--text-primary);">
            Cari Barang Kamu
        </h1>
        <p style="color:var(--text-secondary); font-size:1rem; margin-bottom:32px; line-height:1.7;">
            Kehilangan barang di perpustakaan Universitas Airlangga? Cari di sini dan hubungi petugas kampus yang sesuai.
        </p>

        <form method="GET" action="{{ route('items.public') }}">
            <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:16px;">
                <div style="position:relative; flex:1; min-width:260px; max-width:440px;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" name="search" placeholder="Nama barang, kategori, deskripsi..." 
                        class="form-control" style="padding-left:42px; border-radius:var(--radius-sm);"
                        value="{{ request('search') }}">
                </div>
                <select name="campus" class="filter-select">
                    <option value="">Semua Kampus</option>
                    <option value="kampus-a" {{ request('campus') == 'kampus-a' ? 'selected' : '' }}>Kampus A</option>
                    <option value="kampus-b" {{ request('campus') == 'kampus-b' ? 'selected' : '' }}>Kampus B</option>
                    <option value="kampus-c" {{ request('campus') == 'kampus-c' ? 'selected' : '' }}>Kampus C</option>
                </select>
                <select name="category" class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="electronics"  {{ request('category') == 'electronics'  ? 'selected' : '' }}>Elektronik</option>
                    <option value="documents"    {{ request('category') == 'documents'    ? 'selected' : '' }}>Dokumen</option>
                    <option value="accessories"  {{ request('category') == 'accessories'  ? 'selected' : '' }}>Aksesori</option>
                    <option value="bags"         {{ request('category') == 'bags'         ? 'selected' : '' }}>Tas & Dompet</option>
                    <option value="clothing"     {{ request('category') == 'clothing'     ? 'selected' : '' }}>Pakaian</option>
                    <option value="other"        {{ request('category') == 'other'        ? 'selected' : '' }}>Lainnya</option>
                </select>
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>
</div>

<div style="max-width:1200px; margin:0 auto; padding:40px 24px;">
    {{-- Result count --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:10px;">
        <div style="font-size:0.875rem; color:var(--text-muted);">
            Menampilkan <strong style="color:var(--text-primary);">{{ $items->total() }}</strong> barang ditemukan
            @if(request()->anyFilled(['search','campus','category']))
                — hasil filter aktif
                <a href="{{ route('items.public') }}" style="color:var(--unair-blue); text-decoration:none; margin-left:8px; font-size:0.8rem; font-weight:600;">Reset</a>
            @endif
        </div>
        <div style="font-size:0.8rem; color:var(--text-muted);">
            Halaman {{ $items->currentPage() }} dari {{ $items->lastPage() }}
        </div>
    </div>

    @if($items->count() > 0)
    <div class="items-grid">
        @foreach($items as $item)
        <div class="item-card" style="cursor:default;">
            {{-- Image --}}
            @if($item->image)
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="item-card-img" style="display:block;">
            @else
                <div class="item-card-img">
                    <div style="text-align:center;">
                        @switch($item->category)
                            @case('electronics')
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                @break
                            @case('documents')
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                @break
                            @case('bags')
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                                @break
                            @default
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                        @endswitch
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:6px;">Tidak ada foto</div>
                    </div>
                </div>
            @endif

            <div class="item-card-body">
                <div class="item-card-title">{{ $item->name }}</div>

                @if($item->description)
                <div style="font-size:0.85rem; color:var(--text-muted); margin-bottom:10px; line-height:1.5;">
                    {{ Str::limit($item->description, 80) }}
                </div>
                @endif

                <div class="item-card-meta">
                    <span class="badge badge-default">{{ $item->category_label }}</span>
                    <span class="badge badge-secondary">{{ $item->found_date->format('d M Y') }}</span>
                </div>

                <div style="margin-top:14px; padding-top:14px; border-top:1px solid var(--border);">
                    <div style="font-size:0.8rem; color:var(--text-muted); display:flex; align-items:center; gap:6px; margin-bottom:8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $item->campus_label }}
                        @if($item->location_detail)
                            · {{ $item->location_detail }}
                        @endif
                    </div>
                    <div style="font-size:0.8rem; color:var(--unair-blue); font-weight:700; font-family:monospace; letter-spacing:1px;">
                        {{ $item->qr_code }}
                    </div>
                </div>

                <div style="margin-top:14px; background:var(--bg-card-dark); border-radius:var(--radius-sm); padding:12px; font-size:0.8rem; color:var(--text-muted); line-height:1.5;">
                    <strong style="color:var(--text-primary);">Cara Mengambil:</strong>
                    Tunjukkan bukti kepemilikan ke petugas perpustakaan
                    {{ $item->campus_label }}. Bawa identitas (KTM/KTP).
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    {{ $items->links('vendor.pagination.custom') }}

    @else
    <div style="text-align:center; padding:80px 20px;">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin:0 auto 16px; display:block; opacity:0.15;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <h3 style="font-size:1.25rem; font-weight:700; margin-bottom:8px; color:var(--text-primary);">Tidak ada barang ditemukan</h3>
        <p style="color:var(--text-muted); font-size:0.95rem; max-width:400px; margin:0 auto 20px;">
            Coba ubah kata kunci pencarian atau filter kampus/kategori. Jika barang kamu belum terdaftar, hubungi langsung petugas perpustakaan.
        </p>
        @if(request()->anyFilled(['search','campus','category']))
            <a href="{{ route('items.public') }}" class="btn btn-secondary">Reset Pencarian</a>
        @endif
    </div>
    @endif

    {{-- Contact info --}}
    <div style="margin-top:60px; padding:32px; background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius-lg); box-shadow:var(--shadow);">
        <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:20px; text-align:center; color:var(--text-primary);">
            Hubungi Petugas Perpustakaan
        </h3>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px;">
            @foreach(['Kampus A' => 'Jl. Prof. DR. Moestopo No.47, Pacar Kembang, Kec. Tambaksari, Surabaya, Jawa Timur 60132', 'Kampus B' => 'Airlangga, Kec. Gubeng, Surabaya, Jawa Timur 60286', 'Kampus C' => 'Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60115'] as $campus => $addr)
            <div style="background:var(--bg-card-dark); border:1px solid var(--border); border-radius:var(--radius-sm); padding:16px; text-align:center;">
                <div style="font-weight:700; font-size:0.9rem; margin-bottom:6px; color:var(--unair-blue);">{{ $campus }}</div>
                <div style="font-size:0.8rem; color:var(--text-muted); line-height:1.5;">{{ $addr }}</div>
                <div style="font-size:0.75rem; color:var(--text-secondary); font-weight:500; margin-top:6px;">Bawa identitas diri</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection