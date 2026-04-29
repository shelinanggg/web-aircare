@extends('layouts.app')
@section('title', 'Edit Barang')
@section('page-title', 'Data Barang / Edit')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Barang</h1>
        <p class="page-subtitle">
            Perbarui informasi barang <strong>{{ $item->name }}</strong>
        </p>
    </div>

    <a href="{{ route('items.show', $item) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div style="max-width: 800px;">
    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-title">Informasi Barang</div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Barang *</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $item->name) }}"
                        required
                    >

                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori *</label>

                    <select name="category" class="form-select" required>
                        <option value="valuable" {{ old('category', $item->category) == 'valuable' ? 'selected' : '' }}>
                            Barang Berharga
                        </option>

                        <option value="documents" {{ old('category', $item->category) == 'documents' ? 'selected' : '' }}>
                            Dokumen Berharga
                        </option>

                        <option value="electronics" {{ old('category', $item->category) == 'electronics' ? 'selected' : '' }}>
                            Barang Elektronik
                        </option>

                        <option value="personal" {{ old('category', $item->category) == 'personal' ? 'selected' : '' }}>
                            Barang Pribadi Umum
                        </option>

                        <option value="other" {{ old('category', $item->category) == 'other' ? 'selected' : '' }}>
                            Lainnya
                        </option>
                    </select>

                    @error('category')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>

                <textarea
                    name="description"
                    class="form-control"
                >{{ old('description', $item->description) }}</textarea>

                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Foto Barang</label>

                @if($item->image)
                    <div style="margin-bottom:10px;">
                        <img
                            src="{{ Storage::url($item->image) }}"
                            alt="Foto Barang"
                            style="height:90px; border-radius:10px; object-fit:cover; border:1px solid var(--border);"
                        >

                        <div style="font-size:0.72rem; color:var(--text-muted); margin-top:6px;">
                            Foto saat ini. Upload foto baru jika ingin mengganti.
                        </div>
                    </div>
                @endif

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept="image/*"
                >

                @error('image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <div class="card-title">Lokasi & Waktu</div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kampus *</label>

                    <select name="campus" class="form-select" required>
                        <option value="kampus-a" {{ old('campus', $item->campus) == 'kampus-a' ? 'selected' : '' }}>
                            Kampus A – Prof. Dr. Moestopo
                        </option>

                        <option value="kampus-b" {{ old('campus', $item->campus) == 'kampus-b' ? 'selected' : '' }}>
                            Kampus B – Dharmawangsa
                        </option>

                        <option value="kampus-c" {{ old('campus', $item->campus) == 'kampus-c' ? 'selected' : '' }}>
                            Kampus C – Mulyorejo
                        </option>
                    </select>

                    @error('campus')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Ditemukan *</label>

                    <input
                        type="date"
                        name="found_date"
                        class="form-control"
                        value="{{ old('found_date', $item->found_date->format('Y-m-d')) }}"
                        required
                    >

                    @error('found_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Detail Lokasi</label>

                    <input
                        type="text"
                        name="location_detail"
                        class="form-control"
                        value="{{ old('location_detail', $item->location_detail) }}"
                        placeholder="Contoh: Ruang 203, Lantai 2, Lobby Timur"
                    >

                    @error('location_detail')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Ditemukan Oleh</label>

                    <input
                        type="text"
                        name="found_by"
                        class="form-control"
                        value="{{ old('found_by', $item->found_by) }}"
                    >

                    @error('found_by')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:24px;">
            <div class="card-header">
                <div class="card-title">Catatan Tambahan</div>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <textarea
                    name="notes"
                    class="form-control"
                    placeholder="Kondisi barang, isi dompet, nomor seri, dll..."
                >{{ old('notes', $item->notes) }}</textarea>

                @error('notes')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

            <a href="{{ route('items.show', $item) }}" class="btn btn-ghost">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection