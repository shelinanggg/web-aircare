@extends('layouts.app')
@section('title', 'Catat Barang Baru')
@section('page-title', 'Data Barang / Catat Barang Baru')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Catat Barang Baru</h1>
        <p class="page-subtitle">Isi formulir untuk mendaftarkan barang tertinggal ke sistem</p>
    </div>
    <a href="{{ route('items.index') }}" class="btn btn-ghost">← Kembali</a>
</div>

<div style="max-width: 800px;">
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <div class="card-title">Informasi Barang</div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Barang *</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Laptop Asus, Dompet Hitam..." value="{{ old('name') }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="category" class="form-select" required>
                        <option value="">Pilih kategori...</option>
                        <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Elektronik</option>
                        <option value="documents"   {{ old('category') == 'documents'   ? 'selected' : '' }}>Dokumen / Kartu</option>
                        <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>Aksesori</option>
                        <option value="bags"        {{ old('category') == 'bags'        ? 'selected' : '' }}>Tas & Dompet</option>
                        <option value="clothing"    {{ old('category') == 'clothing'    ? 'selected' : '' }}>Pakaian</option>
                        <option value="other"       {{ old('category') == 'other'       ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Barang</label>
                <textarea name="description" class="form-control" placeholder="Warna, merek, ciri khas, kondisi barang...">{{ old('description') }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Foto Barang</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <div style="font-size:0.7rem; color:var(--text-muted); margin-top:4px;">Format: JPG, PNG. Maks 2MB. Sangat dianjurkan untuk mempermudah identifikasi.</div>
                @error('image')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <div class="card-title">Lokasi & Waktu Penemuan</div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kampus *</label>
                    <select name="campus" class="form-select" required>
                        <option value="">Pilih kampus...</option>
                        <option value="kampus-a" {{ old('campus') == 'kampus-a' ? 'selected' : '' }}>Kampus A – Dharmawangsa</option>
                        <option value="kampus-b" {{ old('campus') == 'kampus-b' ? 'selected' : '' }}>Kampus B – Mulyorejo</option>
                        <option value="kampus-c" {{ old('campus') == 'kampus-c' ? 'selected' : '' }}>Kampus C – Merr</option>
                    </select>
                    @error('campus')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Ditemukan *</label>
                    <input type="date" name="found_date" class="form-control" value="{{ old('found_date', date('Y-m-d')) }}" required>
                    @error('found_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Detail Lokasi</label>
                    <input type="text" name="location_detail" class="form-control" placeholder="Contoh: Lantai 2 Meja 5, Ruang Diskusi B..." value="{{ old('location_detail') }}">
                    @error('location_detail')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Ditemukan Oleh</label>
                    <input type="text" name="found_by" class="form-control" placeholder="Nama petugas / penemu..." value="{{ old('found_by', auth()->user()->name) }}">
                    @error('found_by')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header">
                <div class="card-title">Catatan Tambahan</div>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <textarea name="notes" class="form-control" placeholder="Kondisi barang, catatan khusus, dll...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan & Generate QR Code
            </button>
            <a href="{{ route('items.index') }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection
