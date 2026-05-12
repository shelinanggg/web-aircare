@extends('layouts.app')

@section('title', 'Master Kategori')
@section('page-title', 'Master Data / Kategori')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Master Kategori</h1>
        <p class="page-subtitle">
            Kelola kategori barang, warna QR, dan status kategori
        </p>
    </div>

    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>

        Tambah Kategori
    </a>
</div>


{{-- FILTER --}}
<form method="GET" action="{{ route('categories.index') }}">

    <div class="filters-bar">

        <div class="search-wrapper">

            <span class="search-icon">
                <svg width="14" height="14"
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
                placeholder="Cari nama kategori..."
                class="search-input"
                value="{{ request('search') }}"
            >

        </div>

        <select name="status"
                class="filter-select"
                onchange="this.form.submit()">

            <option value="">Semua Status</option>

            <option value="1"
                {{ request('status') == '1' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="0"
                {{ request('status') == '0' ? 'selected' : '' }}>
                Nonaktif
            </option>

        </select>

        @if(request()->anyFilled(['search','status']))
            <a href="{{ route('categories.index') }}"
               class="btn btn-ghost btn-sm">
                Reset
            </a>
        @endif

        <button type="submit" class="btn btn-secondary btn-sm">
            Cari
        </button>

    </div>

</form>


{{-- TABLE --}}
<div class="card" style="padding:0;">

    <div class="table-wrapper" style="border:none;">

        <table>

            <thead>
                <tr>
                    <th>Warna</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Total Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr>

                        {{-- COLOR --}}
                        <td>
                            <div style="
                                width:32px;
                                height:32px;
                                border-radius:10px;
                                background: {{ $category->color }};
                                border:1px solid rgba(0,0,0,0.08);
                                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.2);
                            "></div>
                        </td>


                        {{-- NAME --}}
                        <td>

                            <div style="
                                font-weight:600;
                                color:var(--text-primary);
                            ">
                                {{ $category->name }}
                            </div>

                        </td>


                        {{-- SLUG --}}
                        <td>

                            <span class="qr-code">
                                {{ $category->slug }}
                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td>

                            @if($category->is_active)

                                <span class="badge badge-found">
                                    Aktif
                                </span>

                            @else

                                <span class="badge badge-disposed">
                                    Nonaktif
                                </span>

                            @endif

                        </td>


                        {{-- TOTAL ITEMS --}}
                        <td style="font-size:0.85rem; color:var(--text-secondary);">

                            {{ $category->items_count ?? $category->items->count() }} Barang

                        </td>


                        {{-- ACTION --}}
                        <td>

                            <div style="
                                display:flex;
                                gap:6px;
                                flex-wrap:wrap;
                            ">

                                <a href="{{ route('categories.edit', $category) }}"
                                   class="btn btn-secondary btn-sm">

                                    Edit

                                </a>

                                <form action="{{ route('categories.destroy', $category) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus kategori ini?')"
                                      style="margin:0;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">

                                        Hapus

                                    </button>

                                </form>

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

                            Belum ada kategori

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection