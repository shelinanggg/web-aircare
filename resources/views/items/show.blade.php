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
                Serahkan Barang
            </button>

            <a href="{{ route('items.edit', $item) }}" class="btn btn-secondary">
                Edit
            </a>

            <button onclick="document.getElementById('modal-dispose').style.display='flex'" class="btn btn-danger">
                Ubah Status
            </button>
        @endif

        <a href="{{ route('items.index') }}" class="btn btn-ghost">
            ← Kembali
        </a>
    </div>
</div>

<div class="detail-grid">

    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- QR CODE & STICKER AREA --}}
        <div class="card" style="text-align:center;">
            
            <div id="qr-sticker" style="
                width: 260px;
                margin: 0 auto;
                border: 4px solid {{ $item->category_color ?? '#004e9a' }};
                border-radius: 16px;
                background: #ffffff;
                overflow: hidden;
                font-family: sans-serif;
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            ">
                <div style="
                    background: {{ $item->category_color ?? '#004e9a' }};
                    color: #ffffff;
                    padding: 10px;
                    font-weight: 800;
                    font-size: 14px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                ">
                    {{ $item->category_label }}
                </div>

                <div style="padding: 20px 20px 10px 20px; background: #ffffff;">
                    {!! QrCode::size(180)->margin(0)->generate($item->qr_code) !!}
                </div>

                <div style="
                    padding: 0 20px 16px 20px;
                    background: #ffffff;
                ">
                    <div style="font-weight: 800; font-size: 18px; color: #333; font-family: monospace; margin-bottom: 4px;">
                        {{ $item->qr_code }}
                    </div>
                    <div style="font-size: 12px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $item->name }}
                    </div>
                </div>
            </div>

            <div style="margin-top:24px;">
                <button type="button" onclick="printSticker()" class="btn btn-primary" style="width: 100%; max-width: 260px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Cetak Stiker
                </button>
                
                <div style="font-size:12px; color:#666; margin-top:12px;">
                    Gunakan tombol di atas untuk mencetak atau mendownload stiker fisik (PDF).
                </div>

                <div style="margin-top:16px; padding-top:16px; border-top:1px solid #eee;">
                    <span class="badge {{ $item->status_badge['class'] ?? 'badge-secondary' }}">
                        Status: {{ $item->status_badge['label'] ?? 'Ditemukan' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- FOTO --}}
        @if($item->image)
            <div class="card" style="padding:0; overflow:hidden;">
                <img
                    src="{{ Storage::url($item->image) }}"
                    alt="{{ $item->name }}"
                    style="width:100%; max-height:300px; object-fit:cover;"
                >
            </div>
        @endif

        {{-- LOG --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Riwayat Aktivitas</div>
            </div>

            <div class="activity-list">
                @forelse($logs as $log)
                    <div class="activity-item">
                        <div class="activity-dot"></div>

                        <div>
                            <div class="activity-text">
                                {{ $log->description }}
                            </div>

                            <div class="activity-time">
                                {{ $log->created_at->format('d M Y H:i') }}
                                @if($log->user)
                                    · {{ $log->user->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="color:#777;">Belum ada riwayat</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- KANAN --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Barang</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Nama</div>
                <div class="detail-value">{{ $item->name }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Kategori</div>
                <div class="detail-value">
                    {{ $item->category_label }}
                </div>
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
                <div class="card-title">Lokasi Penemuan</div>
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
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informasi Pengambilan</div>
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
                <div class="detail-label">Tanggal</div>
                <div class="detail-value">{{ $item->claimed_date?->format('d M Y') }}</div>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="detail-field">
                <div class="detail-label">Dibuat</div>
                <div class="detail-value">{{ $item->created_at->format('d M Y H:i') }}</div>
            </div>

            <div class="detail-field">
                <div class="detail-label">Diupdate</div>
                <div class="detail-value">{{ $item->updated_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        @auth
        <form action="{{ route('items.destroy', $item) }}" method="POST"
              onsubmit="return confirm('Hapus data barang ini?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger" style="width:100%;">
                Hapus dari Sistem
            </button>
        </form>
        @endauth

    </div>
</div>

@if($item->status === 'found')

{{-- MODAL CLAIM --}}
<div id="modal-claim" class="modal-backdrop" style="display:none;" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-title">Serahkan Barang</div>

        <form action="{{ route('items.claim', $item) }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Pengambil *</label>
                <input type="text" name="claimed_by" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">NIM / Identitas</label>
                <input type="text" name="claimer_nim" class="form-control">
            </div>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">
                    Konfirmasi
                </button>

                <button type="button"
                        onclick="document.getElementById('modal-claim').style.display='none'"
                        class="btn btn-secondary" style="flex:1;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL STATUS --}}
<div id="modal-dispose" class="modal-backdrop" style="display:none;" onclick="if(event.target===this)this.style.display='none'">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-title">Ubah Status Barang</div>

        <form action="{{ route('items.dispose', $item) }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Pilih Status</label>

                <select name="status" class="form-select" required>
                    <option value="disposed">Dimusnahkan</option>
                    <option value="donated">Dihibahkan</option>
                    <option value="handed_over">Diserahkan ke DITPILAR</option>
                </select>
            </div>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="submit" class="btn btn-danger" style="flex:1;">
                    Simpan
                </button>

                <button type="button"
                        onclick="document.getElementById('modal-dispose').style.display='none'"
                        class="btn btn-secondary" style="flex:1;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endif

{{-- JAVASCRIPT UNTUK FITUR PRINT STIKER --}}
<script>
function printSticker() {
    // Mengambil HTML dari stiker
    var stickerHTML = document.getElementById('qr-sticker').outerHTML;
    
    // Membuka jendela popup baru untuk print
    var printWindow = window.open('', '_blank', 'width=400,height=500');
    
    // Menulis struktur dokumen HTML untuk mencetak
    printWindow.document.write(`
        <html>
        <head>
            <title>Cetak Stiker QR - {{ $item->qr_code }}</title>
            <style>
                @page { 
                    margin: 0; 
                    size: auto; 
                }
                body { 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    height: 100vh; 
                    margin: 0; 
                    background: #fff;
                    -webkit-print-color-adjust: exact; 
                    print-color-adjust: exact;
                }
                /* Memastikan box shadow tidak tercetak (menghemat tinta) */
                #qr-sticker {
                    box-shadow: none !important;
                }
            </style>
        </head>
        <body>
            ${stickerHTML}
            <script>
                // Jalankan print ketika dokumen selesai dimuat
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                        window.close();
                    }, 300);
                }
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
@endsection