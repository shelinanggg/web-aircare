@extends('layouts.app')

@section('title', 'Master User')
@section('page-title', 'Master Data / User')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Master User</h1>

        <p class="page-subtitle">
            Kelola akun administrator dan staff perpustakaan
        </p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary">

        <svg width="16"
             height="16"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>

        </svg>

        Tambah User

    </a>

</div>


<form method="GET" action="{{ route('users.index') }}">

    <div class="filters-bar">

        <div class="search-wrapper">

            <span class="search-icon">

                <svg width="14"
                     height="14"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>

                </svg>

            </span>

            <input
                type="text"
                name="search"
                placeholder="Cari nama atau email..."
                class="search-input"
                value="{{ request('search') }}"
            >

        </div>

        <select name="role"
                class="filter-select"
                onchange="this.form.submit()">

            <option value="">Semua Role</option>

            <option value="admin"
                {{ request('role') == 'admin' ? 'selected' : '' }}>
                Administrator
            </option>

            <option value="staff"
                {{ request('role') == 'staff' ? 'selected' : '' }}>
                Staff
            </option>

        </select>

        <select name="campus"
                class="filter-select"
                onchange="this.form.submit()">

            <option value="">Semua Kampus</option>

            <option value="kampus-a"
                {{ request('campus') == 'kampus-a' ? 'selected' : '' }}>
                Kampus A
            </option>

            <option value="kampus-b"
                {{ request('campus') == 'kampus-b' ? 'selected' : '' }}>
                Kampus B
            </option>

            <option value="kampus-c"
                {{ request('campus') == 'kampus-c' ? 'selected' : '' }}>
                Kampus C
            </option>

        </select>

        @if(request()->anyFilled(['search','role','campus']))

            <a href="{{ route('users.index') }}"
               class="btn btn-ghost btn-sm">

                Reset

            </a>

        @endif

        <button type="submit" class="btn btn-secondary btn-sm">
            Cari
        </button>

    </div>

</form>


<div class="card" style="padding:0;">

    <div class="table-wrapper" style="border:none;">

        <table>

            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Kampus</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>

                            <div style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            ">

                                <div class="user-avatar">

                                    {{ strtoupper(substr($user->name, 0, 2)) }}

                                </div>

                                <div>

                                    <div style="
                                        font-weight:600;
                                        color:var(--text-primary);
                                    ">
                                        {{ $user->name }}
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td style="font-size:0.85rem;">
                            {{ $user->email }}
                        </td>

                        <td>

                            @if($user->role === 'admin')

                                <span class="badge badge-found">
                                    Administrator
                                </span>

                            @else

                                <span class="badge badge-default">
                                    Staff
                                </span>

                            @endif

                        </td>

                        <td style="font-size:0.85rem; color:var(--text-secondary);">

                            {{ $user->campus_label }}

                        </td>

                        <td style="font-size:0.8rem; color:var(--text-muted);">

                            {{ $user->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <div style="
                                display:flex;
                                gap:6px;
                                flex-wrap:wrap;
                            ">

                                <a href="{{ route('users.edit', $user) }}"
                                   class="btn btn-secondary btn-sm">

                                    Edit

                                </a>

                                @if(auth()->id() !== $user->id)

                                    <form action="{{ route('users.destroy', $user) }}"
                                          method="POST"
                                          style="margin:0;"
                                          onsubmit="return confirm('Hapus user ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">

                                            Hapus

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            style="
                                text-align:center;
                                padding:48px;
                                color:var(--text-muted);
                            ">

                            <svg width="40"
                                 height="40"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.5"
                                 style="
                                    margin:0 auto 12px;
                                    display:block;
                                    opacity:0.3;
                                 ">

                                <circle cx="12" cy="12" r="10"/>
                                <path d="M8 12h8"/>

                            </svg>

                            Belum ada user

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection