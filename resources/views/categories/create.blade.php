@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Master Data / Tambah Kategori')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Tambah Kategori</h1>

        <p class="page-subtitle">
            Tambahkan kategori baru untuk klasifikasi barang tertinggal
        </p>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-ghost">
        ← Kembali
    </a>

</div>


<div style="max-width:800px;">

    <form action="{{ route('categories.store') }}" method="POST">

        @csrf


        {{-- INFORMASI KATEGORI --}}
        <div class="card" style="margin-bottom:20px;">

            <div class="card-header">
                <div class="card-title">
                    Informasi Kategori
                </div>
            </div>


            <div class="form-grid">

                {{-- NAMA --}}
                <div class="form-group">

                    <label class="form-label">
                        Nama Kategori *
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Contoh: Barang Berharga"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- COLOR --}}
                <div class="form-group">

                    <label class="form-label">
                        Warna Kategori *
                    </label>

                    <div style="
                        display:flex;
                        align-items:center;
                        gap:12px;
                    ">

                        <input
                            type="color"
                            name="color"
                            value="{{ old('color', '#3B82F6') }}"
                            style="
                                width:60px;
                                height:48px;
                                border:none;
                                background:none;
                                padding:0;
                                cursor:pointer;
                            "
                        >

                        <div style="
                            font-size:0.82rem;
                            color:var(--text-muted);
                            line-height:1.5;
                        ">
                            Warna ini akan digunakan untuk:
                            <br>
                            badge kategori dan frame QR Code.
                        </div>

                    </div>

                    @error('color')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- STATUS --}}
            <div class="form-group" style="margin-bottom:0;">

                <label class="form-label">
                    Status Kategori
                </label>

                <label style="
                    display:flex;
                    align-items:center;
                    gap:10px;
                    margin-top:8px;
                    cursor:pointer;
                    user-select:none;
                ">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                        style="
                            width:16px;
                            height:16px;
                            cursor:pointer;
                        "
                    >

                    <span style="
                        font-size:0.9rem;
                        color:var(--text-secondary);
                    ">
                        Aktifkan kategori ini
                    </span>

                </label>

                <div style="
                    font-size:0.72rem;
                    color:var(--text-muted);
                    margin-top:8px;
                ">
                    Kategori nonaktif tidak akan muncul saat petugas
                    mencatat barang baru.
                </div>

            </div>

        </div>


        {{-- PREVIEW --}}
        <div class="card" style="margin-bottom:24px;">

            <div class="card-header">
                <div class="card-title">
                    Preview Tampilan
                </div>
            </div>

            <div style="
                display:flex;
                align-items:center;
                gap:16px;
                flex-wrap:wrap;
            ">

                <div id="previewColor"
                     style="
                        width:54px;
                        height:54px;
                        border-radius:14px;
                        background:#3B82F6;
                        border:1px solid rgba(0,0,0,0.08);
                     ">
                </div>

                <div>

                    <div style="
                        font-weight:700;
                        color:var(--text-primary);
                        margin-bottom:8px;
                    ">
                        Badge Kategori
                    </div>

                    <span id="previewBadge"
                          class="badge badge-default">

                        Barang Berharga

                    </span>

                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div style="
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        ">

            <button type="submit" class="btn btn-primary">

                <svg width="16"
                     height="16"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <polyline points="20 6 9 17 4 12"/>

                </svg>

                Simpan Kategori

            </button>


            <a href="{{ route('categories.index') }}"
               class="btn btn-ghost">

                Batal

            </a>

        </div>

    </form>

</div>


<script>

const colorInput = document.querySelector('input[name="color"]');
const nameInput = document.querySelector('input[name="name"]');

const previewColor = document.getElementById('previewColor');
const previewBadge = document.getElementById('previewBadge');

function updatePreview()
{
    previewColor.style.background = colorInput.value;

    previewBadge.style.background = colorInput.value;
    previewBadge.style.color = '#fff';
    previewBadge.style.border = 'none';

    previewBadge.innerText =
        nameInput.value || 'Nama Kategori';
}

colorInput.addEventListener('input', updatePreview);
nameInput.addEventListener('input', updatePreview);

updatePreview();

</script>

@endsection