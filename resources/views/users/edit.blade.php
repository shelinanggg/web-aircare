@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Master Data / Edit User')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Edit User</h1>

        <p class="page-subtitle">
            Perbarui informasi user
            <strong>{{ $user->name }}</strong>
        </p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-ghost">
        ← Kembali
    </a>

</div>


<div style="max-width:800px;">

    <form action="{{ route('users.update', $user) }}"
          method="POST">

        @csrf
        @method('PUT')

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
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('email', $user->email) }}"
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
                        Password Baru
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >

                    <div style="
                        font-size:0.72rem;
                        color:var(--text-muted);
                        margin-top:6px;
                    ">
                        Kosongkan jika tidak ingin mengganti password.
                    </div>

                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                </div>


                <div class="form-group">

                    <label class="form-label">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
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

                        <option value="admin"
                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Administrator
                        </option>

                        <option value="staff"
                            {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
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

                        <option value="kampus-a"
                            {{ old('campus', $user->campus) == 'kampus-a' ? 'selected' : '' }}>
                            Kampus A
                        </option>

                        <option value="kampus-b"
                            {{ old('campus', $user->campus) == 'kampus-b' ? 'selected' : '' }}>
                            Kampus B
                        </option>

                        <option value="kampus-c"
                            {{ old('campus', $user->campus) == 'kampus-c' ? 'selected' : '' }}>
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

                Simpan Perubahan

            </button>

            <a href="{{ route('users.index') }}"
               class="btn btn-ghost">

                Batal

            </a>

        </div>

    </form>

</div>

@endsection