@extends('layouts.app')
@section('title', 'Edit Barang')
@section('page-title', 'Data Barang / Edit')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Barang</h1>
        <p class="page-subtitle">Perbarui informasi barang <strong>{{ $item->name }}</strong></p>
    </div>
    <a href="{{ route('items.show', $item) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div style="max-width: 800px;">
    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <div class="card-title">Informasi Barang</div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Barang *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="category" class="form-select" required>
                        @foreach(['electronics'=>'Elektronik','documents'=>'Dokumen','accessories'=>'Aksesori','bags'=>'Tas & Dompet','clothing'=>'Pakaian','other'=>'Lainnya'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $item->category) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description', $item->description) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Barang</label>
                @if($item->image)
                <div style="margin-bottom:8px;">
                    <img src="{{ Storage::url($item->image) }}" style="height:80px; border-radius:8px; object-fit:cover; border:1px solid var(--border);">
                    <div style="font-size:0.7rem; color:var(--text-muted); margin-top:4px;">Foto saat ini. Upload baru untuk mengganti.</div>
                </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <div class="card-title">Lokasi & Waktu</div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kampus *</label>
                    <select name="campus" class="form-select" required>
                        <option value="kampus-a" {{ old('campus', $item->campus) == 'kampus-a' ? 'selected' : '' }}>Kampus A – Dharmawangsa</option>
                        <option value="kampus-b" {{ old('campus', $item->campus) == 'kampus-b' ? 'selected' : '' }}>Kampus B – Mulyorejo</option>
                        <option value="kampus-c" {{ old('campus', $item->campus) == 'kampus-c' ? 'selected' : '' }}>Kampus C – Merr</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Ditemukan *</label>
                    <input type="date" name="found_date" class="form-control" value="{{ old('found_date', $item->found_date->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Detail Lokasi</label>
                    <input type="text" name="location_detail" class="form-control" value="{{ old('location_detail', $item->location_detail) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Ditemukan Oleh</label>
                    <input type="text" name="found_by" class="form-control" value="{{ old('found_by', $item->found_by) }}">
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 24px;">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control">{{ old('notes', $item->notes) }}</textarea>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('items.show', $item) }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection
