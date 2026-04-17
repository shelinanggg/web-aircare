@extends('layouts.app')
@section('title', $item->name)
@section('page-title', 'Data Barang / Detail')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $item->name }}</h1>
        <p class="page-subtitle">Detail barang tertinggal</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        @if($item->status === 'found')
            <button onclick="document.getElementById('modal-claim').style.display='flex'" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Serahkan Barang
            </button>
            <a href="{{ route('items.edit', $item) }}" class="btn btn-secondary">Edit</a>
            <button onclick="document.getElementById('modal-dispose').style.display='flex'" class="btn btn-danger">Musnahkan</button>
        @endif
        <a href="{{ route('items.index') }}" class="btn btn-ghost">← Kembali</a>
    </div>
</div>

<div class="detail-grid">
    {{-- Left: Info --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- QR Code Display --}}
        <div class="card" style="text-align:center;">
            <div class="qr-display" style="margin: 0 auto; background: var(--bg-card-dark); border: 2px dashed var(--border); border-radius: var(--radius); padding: 24px;">
                <div class="qr-hint" style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; font-weight:700; margin-bottom:8px;">Kode Barang</div>
                <div class="qr-label" style="font-size:1.25rem; font-weight:800; color:var(--unair-blue); letter-spacing:1.5px; margin-bottom:16px;">{{ $item->qr_code }}</div>
                
                {{-- SVG QR Code sudah dibuat solid 100% tanpa opacity dan menggunakan UNAIR Blue --}}
                <svg width="100" height="100" viewBox="0 0 80 80" fill="none" style="margin: 0 auto 16px; display:block;">
                    <rect x="5" y="5" width="30" height="30" rx="2" stroke="var(--unair-blue)" stroke-width="3" fill="none"/>
                    <rect x="12" y="12" width="16" height="16" fill="var(--unair-blue)" rx="1"/>
                    <rect x="45" y="5" width="30" height="30" rx="2" stroke="var(--unair-blue)" stroke-width="3" fill="none"/>
                    <rect x="52" y="12" width="16" height="16" fill="var(--unair-blue)" rx="1"/>
                    <rect x="5" y="45" width="30" height="30" rx="2" stroke="var(--unair-blue)" stroke-width="3" fill="none"/>
                    <rect x="12" y="52" width="16" height="16" fill="var(--unair-blue)" rx="1"/>
                    <rect x="47" y="47" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="57" y="47" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="67" y="47" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="47" y="57" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="67" y="57" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="47" y="67" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="57" y="67" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                    <rect x="67" y="67" width="6" height="6" fill="var(--unair-blue)" rx="1"/>
                </svg>

                <span class="badge {{ $item->status_badge['class'] }}">{{ $item->status_badge['label'] }}</span>
            </div>
        </div>

        {{-- Photo --}}
        @if($item->image)
        <div class="card" style="padding:0; overflow:hidden;">
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:100%; max-height:280px; object-fit:cover;">
        </div>
        @else
        <div class="card" style="text-align:center; padding:40px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px; display:block; opacity:0.2;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span style="font-size:0.875rem; color:var(--text-muted);">Tidak ada foto</span>
        </div>
        @endif

        {{-- Activity Log --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Riwayat Aktivitas</div>
            </div>
            <div class="activity-list">
                @forelse($logs as $log)
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <div class="activity-text" style="color:var(--text-primary);">{{ $log->description }}</div>
                        <div class="activity-time">
                            {{ $log->created_at->format('d M Y, H:i') }}
                            @if($log->user) · {{ $log->user->name }}@endif
                        </div>
                    </div>
                </div>
                @empty
                <p style="color:var(--text-muted); font-size:0.875rem;">Belum ada riwayat</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right: Details --}}
    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Barang</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Nama Barang</div>
                <div class="detail-value" style="font-weight:700; font-size:1.1rem; color:var(--text-primary);">{{ $item->name }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Kategori</div>
                <div class="detail-value"><span class="badge badge-default">{{ $item->category_label }}</span></div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Deskripsi</div>
                <div class="detail-value">{{ $item->description ?: '—' }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Catatan</div>
                <div class="detail-value">{{ $item->notes ?: '—' }}</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Lokasi & Penemuan</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Kampus</div>
                <div class="detail-value">{{ $item->campus_label }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Detail Lokasi</div>
                <div class="detail-value">{{ $item->location_detail ?: '—' }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Tanggal Ditemukan</div>
                <div class="detail-value">{{ $item->found_date->format('d M Y') }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Ditemukan Oleh</div>
                <div class="detail-value">{{ $item->found_by ?: '—' }}</div>
            </div>
        </div>

        @if($item->status === 'claimed')
        <div class="card" style="border:1px solid rgba(25,135,84,0.3); background:rgba(25,135,84,0.02);">
            <div class="card-header">
                <div class="card-title" style="color:var(--green);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Telah Diambil
                </div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Diambil Oleh</div>
                <div class="detail-value">{{ $item->claimed_by }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">NIM / Identitas</div>
                <div class="detail-value">{{ $item->claimer_nim ?: '—' }}</div>
            </div>
            <div class="detail-field">
                <div class="detail-label">Tanggal Pengambilan</div>
                <div class="detail-value">{{ $item->claimed_date?->format('d M Y') }}</div>
            </div>
        </div>
        @endif

        <div class="card" style="background:var(--bg-card-dark);">
            <div class="detail-field" style="margin-bottom:8px;">
                <div class="detail-label">Dicatat Pada</div>
                <div class="detail-value" style="font-size:0.875rem;">{{ $item->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div class="detail-field" style="margin-bottom:0;">
                <div class="detail-label">Terakhir Diperbarui</div>
                <div class="detail-value" style="font-size:0.875rem;">{{ $item->updated_at->format('d M Y, H:i') }}</div>
            </div>
        </div>

        @auth
        @if($item->status !== 'disposed')
        <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data barang ini dari sistem?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%; justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                Hapus dari Sistem
            </button>
        </form>
        @endif
        @endauth
    </div>
</div>

{{-- Claim Modal --}}
@if($item->status === 'found')
<div id="modal-claim" class="modal-backdrop" style="display:none;" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--unair-blue)" stroke-width="2" style="vertical-align:middle; margin-right:8px;"><polyline points="20 6 9 17 4 12"/></svg>
            Serahkan Barang ke Pemilik
        </div>
        <form action="{{ route('items.claim', $item) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Pengambil <span style="color:var(--red-accent);">*</span></label>
                <input type="text" name="claimed_by" class="form-control" placeholder="Nama lengkap..." required>
            </div>
            <div class="form-group">
                <label class="form-label">NIM / No. Identitas</label>
                <input type="text" name="claimer_nim" class="form-control" placeholder="NIM / NIK / No. KTM...">
            </div>
            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Konfirmasi Penyerahan</button>
                <button type="button" onclick="document.getElementById('modal-claim').style.display='none'" class="btn btn-secondary" style="flex:1; justify-content:center;">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Dispose Modal --}}
<div id="modal-dispose" class="modal-backdrop" style="display:none;" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-title">Musnahkan / Donasikan Barang</div>
        <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:24px; line-height:1.5;">Barang akan ditandai sebagai dimusnahkan/didonasikan. Tindakan ini tidak dapat dibatalkan.</p>
        <form action="{{ route('items.dispose', $item) }}" method="POST">
            @csrf
            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn btn-danger" style="flex:1; justify-content:center;">Ya, Lanjutkan</button>
                <button type="button" onclick="document.getElementById('modal-dispose').style.display='none'" class="btn btn-secondary" style="flex:1; justify-content:center;">Batal</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection