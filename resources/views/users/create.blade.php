@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Master Data / Tambah User')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Tambah User</h1>

        <p class="page-subtitle">
            Tambahkan akun administrator atau staff baru
        </p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-ghost">
        ← Kembali
    </a>

</div>


<div style="max-width:800px;">

    <form action="{{ route('users.store') }}" method="POST">

        @csrf

        <div class="card" style="margin-bottom:24px;">

            <div class="card-header">
                <div class="card-title">
                    Informasi User
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Nama Lengkap *
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Email *
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Password *
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >

                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Konfirmasi Password *
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required
                    >

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Role *
                    </label>

                    <select name="role"
                            class="form-select"
                            required>

                        <option value="">Pilih role...</option>

                        <option value="admin"
                            {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Administrator
                        </option>

                        <option value="staff"
                            {{ old('role') == 'staff' ? 'selected' : '' }}>
                            Staff
                        </option>

                    </select>

                    @error('role')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Kampus *
                    </label>

                    <select name="campus"
                            class="form-select"
                            required>

                        <option value="">Pilih kampus...</option>

                        <option value="kampus-a"
                            {{ old('campus') == 'kampus-a' ? 'selected' : '' }}>
                            Kampus A
                        </option>

                        <option value="kampus-b"
                            {{ old('campus') == 'kampus-b' ? 'selected' : '' }}>
                            Kampus B
                        </option>

                        <option value="kampus-c"
                            {{ old('campus') == 'kampus-c' ? 'selected' : '' }}>
                            Kampus C
                        </option>

                    </select>

                    @error('campus')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                </div>

            </div>

        </div>


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

                Simpan User

            </button>

            <a href="{{ route('users.index') }}"
               class="btn btn-ghost">

                Batal

            </a>

        </div>

    </form>

</div>

@endsection