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

    <a href="{{ route('items.show', $item) }}" class="btn btn-ghost">
        ← Kembali
    </a>
</div>

<div style="max-width: 800px;">

    <form action="{{ route('items.update', $item) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- INFORMASI BARANG --}}
        <div class="card" style="margin-bottom:20px;">

            <div class="card-header">
                <div class="card-title">
                    Informasi Barang
                </div>
            </div>

            <div class="form-grid">

                {{-- NAMA --}}
                <div class="form-group">

                    <label class="form-label">
                        Nama Barang *
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $item->name) }}"
                        required
                    >

                    @error('name')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- CATEGORY --}}
                <div class="form-group">

                    <label class="form-label">
                        Kategori *
                    </label>

                    <select name="category_id"
                            class="form-select"
                            required>

                        <option value="">
                            Pilih kategori...
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <div style="
                        font-size:0.72rem;
                        color:var(--text-muted);
                        margin-top:6px;
                    ">
                        Pilih kategori yang sesuai dengan jenis barang.
                    </div>

                </div>

            </div>

            {{-- DESKRIPSI --}}
            <div class="form-group">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    placeholder="Warna, merek, ciri khas, kondisi barang..."
                >{{ old('description', $item->description) }}</textarea>

                @error('description')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- FOTO --}}
            <div class="form-group">

                <label class="form-label">
                    Foto Barang
                </label>

                {{-- FOTO SAAT INI --}}
                @if($item->image)

                    <div id="oldImageContainer"
                         style="margin-bottom:10px;">

                        <img
                            src="{{ Storage::url($item->image) }}"
                            alt="Foto Barang"
                            style="
                                height:90px;
                                border-radius:10px;
                                object-fit:cover;
                                border:1px solid var(--border);
                            "
                        >

                        <div style="
                            font-size:0.72rem;
                            color:var(--text-muted);
                            margin-top:6px;
                        ">
                            Foto saat ini.
                            Upload foto baru jika ingin mengganti.
                        </div>

                    </div>

                @endif

                {{-- PREVIEW FOTO BARU --}}
                <div id="imagePreviewContainer"
                     style="display:none; margin-bottom:10px;">

                    <img id="imagePreview"
                         src=""
                         alt="Preview Foto"
                         style="
                            height:90px;
                            border-radius:10px;
                            object-fit:cover;
                            border:1px solid var(--border);
                         ">

                    <div style="
                        font-size:0.72rem;
                        color:var(--text-muted);
                        margin-top:6px;
                    ">
                        Preview foto baru.
                    </div>

                </div>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept="image/*"
                    onchange="previewImage(this)"
                >

                <div style="
                    font-size:0.72rem;
                    color:var(--text-muted);
                    margin-top:4px;
                ">
                    Format JPG / PNG, maksimal 2MB.
                </div>

                @error('image')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        {{-- LOKASI --}}
        <div class="card" style="margin-bottom:20px;">

            <div class="card-header">
                <div class="card-title">
                    Lokasi & Waktu
                </div>
            </div>

            <div class="form-grid">

                {{-- KAMPUS --}}
                <div class="form-group">

                    <label class="form-label">
                        Kampus *
                    </label>

                    <select name="campus"
                            class="form-select"
                            required>

                        <option value="kampus-a"
                            {{ old('campus', $item->campus) == 'kampus-a' ? 'selected' : '' }}>
                            Kampus A – Prof. Dr. Moestopo
                        </option>

                        <option value="kampus-b"
                            {{ old('campus', $item->campus) == 'kampus-b' ? 'selected' : '' }}>
                            Kampus B – Dharmawangsa
                        </option>

                        <option value="kampus-c"
                            {{ old('campus', $item->campus) == 'kampus-c' ? 'selected' : '' }}>
                            Kampus C – Mulyorejo
                        </option>

                    </select>

                    @error('campus')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- TANGGAL --}}
                <div class="form-group">

                    <label class="form-label">
                        Tanggal Ditemukan *
                    </label>

                    <input
                        type="date"
                        name="found_date"
                        class="form-control"
                        value="{{ old('found_date', $item->found_date->format('Y-m-d')) }}"
                        required
                    >

                    @error('found_date')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="form-grid">

                {{-- LOKASI DETAIL --}}
                <div class="form-group">

                    <label class="form-label">
                        Detail Lokasi
                    </label>

                    <input
                        type="text"
                        name="location_detail"
                        class="form-control"
                        value="{{ old('location_detail', $item->location_detail) }}"
                        placeholder="Contoh: Ruang 203, Lantai 2, Lobby Timur"
                    >

                    @error('location_detail')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- FOUND BY --}}
                <div class="form-group">

                    <label class="form-label">
                        Ditemukan Oleh
                    </label>

                    <input
                        type="text"
                        name="found_by"
                        class="form-control"
                        value="{{ old('found_by', $item->found_by) }}"
                    >

                    @error('found_by')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>

        {{-- NOTES --}}
        <div class="card" style="margin-bottom:24px;">

            <div class="card-header">
                <div class="card-title">
                    Catatan Tambahan
                </div>
            </div>

            <div class="form-group" style="margin-bottom:0;">

                <textarea
                    name="notes"
                    class="form-control"
                    placeholder="Kondisi barang, isi dompet, nomor seri, dll..."
                >{{ old('notes', $item->notes) }}</textarea>

                @error('notes')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        {{-- BUTTON --}}
        <div style="
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        ">

            <button type="submit"
                    class="btn btn-primary">

                Simpan Perubahan

            </button>

            <a href="{{ route('items.show', $item) }}"
               class="btn btn-ghost">

                Batal

            </a>

        </div>

    </form>

</div>

<script>

function previewImage(input)
{
    const previewContainer =
        document.getElementById('imagePreviewContainer');

    const previewImage =
        document.getElementById('imagePreview');

    if (input.files && input.files[0])
    {
        const reader = new FileReader();

        reader.onload = function(e)
        {
            previewImage.src = e.target.result;

            previewContainer.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
    else
    {
        previewImage.src = '';

        previewContainer.style.display = 'none';
    }
}

</script>
@endsection