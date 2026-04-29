@extends('layouts.public')
@section('title', 'Beranda')

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">Perpustakaan Universitas Airlangga · Kampus A, B & C</div>
        <h1 class="hero-title">Found with Care,<br>Returned with Heart</h1>
        <p class="hero-sub">
            AIRCARE adalah sistem digital pengelolaan barang tertinggal terintegrasi di seluruh perpustakaan Universitas Airlangga yang transparan, efisien, dan akuntabel.
        </p>
        <div class="hero-actions">
            <a href="{{ route('items.public') }}" class="btn btn-primary" style="padding:12px 28px; font-size:0.95rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Cari Barang Saya
            </a>
            <a href="{{ route('login') }}" class="btn btn-secondary" style="padding:12px 28px; font-size:0.95rem;">
                Login Staff →
            </a>
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<div style="background:var(--bg-card); border-top:1px solid var(--border); border-bottom:1px solid var(--border);">
    <div style="max-width:1000px; margin:0 auto; padding:0 24px; display:grid; grid-template-columns:repeat(3,1fr);">
        @php
            $totalFound   = \App\Models\Item::where('status','found')->count();
            $totalClaimed = \App\Models\Item::where('status','claimed')->count();
            $totalAll     = \App\Models\Item::count();
        @endphp
        @foreach([
            ['label' => 'Barang Belum Diambil', 'value' => $totalFound,   'color' => 'var(--unair-blue)'],
            ['label' => 'Berhasil Dikembalikan', 'value' => $totalClaimed, 'color' => 'var(--green)'],
            ['label' => 'Total Tercatat',        'value' => $totalAll,    'color' => 'var(--text-primary)'],
        ] as $stat)
        <div style="padding:28px 24px; text-align:center; border-right:1px solid var(--border); last-child:border-right:none;">
            <div style="font-size:2.2rem; font-weight:800; color:{{ $stat['color'] }}; line-height:1;">
                {{ $stat['value'] }}
            </div>
            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px; font-weight:600;">
                {{ $stat['label'] }}
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Problem section --}}
<div class="section" style="padding-top:80px;">
    <div style="text-align:center; margin-bottom:40px;">
        <div style="display:inline-block; background:rgba(220,53,69,0.1); border:1px solid rgba(220,53,69,0.2); color:var(--red-accent); font-size:0.7rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:6px 16px; border-radius:99px; margin-bottom:12px;">
            Tantangan di Perpustakaan
        </div>
        <h2 class="section-title">Masalah yang Kami Selesaikan</h2>
        <p class="section-sub" style="max-width:520px; margin:0 auto;">
            Ribuan pengunjung setiap hari meninggalkan barang pribadi di tiga kampus. Sistem lama manual, tidak terintegrasi, dan tidak terdokumentasi.
        </p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:16px;">
        @foreach([
            [
                'title' => 'Sistem Manual', 
                'desc' => 'Pencatatan tradisional tanpa integrasi antar kampus - data mudah hilang dan tidak bisa diakses lintas lokasi.', 
                'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>'
            ],
            [
                'title' => 'Informasi Terbatas', 
                'desc' => 'Data barang hilang dalam 24 jam tanpa dokumentasi digital. Pemilik tidak bisa melacak statusnya.', 
                'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'
            ],
            [
                'title' => 'Tidak Terstandar', 
                'desc' => 'Prosedur berbeda di setiap kampus - tanpa SOP baku, penanganan tidak konsisten dan tidak terukur.', 
                'icon' => '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
            ],
        ] as $prob)
        <div style="background:var(--bg-card); border:1px solid rgba(220,53,69,0.2); border-radius:var(--radius); padding:24px; box-shadow:var(--shadow);">
            <div style="width:40px; height:40px; background:rgba(220,53,69,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:14px;">
                {{-- Penambahan stroke-linecap="round" stroke-linejoin="round" ada di sini --}}
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--red-accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $prob['icon'] !!}</svg>
            </div>
            <div style="font-weight:700; font-size:0.9rem; margin-bottom:8px; color:var(--text-primary);">{{ $prob['title'] }}</div>
            <div style="font-size:0.8rem; color:var(--text-muted); line-height:1.6;">{{ $prob['desc'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Solution / Features --}}
<div class="section">
    <div style="text-align:center; margin-bottom:40px;">
        <div style="display:inline-block; background:var(--unair-blue-dim); border:1px solid var(--border-glow); color:var(--unair-blue); font-size:0.7rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:6px 16px; border-radius:99px; margin-bottom:12px;">
            Solusi AIRCARE
        </div>
        <h2 class="section-title">Komponen Utama Program</h2>
        <p class="section-sub" style="max-width:520px; margin:0 auto;">
            Program inovatif berbasis digital untuk mengintegrasikan pengelolaan barang tertinggal dengan transparansi dan akuntabilitas.
        </p>
    </div>
    <div class="features-grid">
        @foreach([
            ['num'=>'01', 'title'=>'Sistem Digital Lost & Found', 'desc'=>'Platform online dengan foto, deskripsi, dan status barang real-time yang dapat diakses oleh seluruh civitas akademika.'],
            ['num'=>'02', 'title'=>'SOP Terpadu', 'desc'=>'Standar operasional untuk semua kampus mencakup prosedur penerimaan, penyimpanan, hingga pemusnahan barang.'],
            ['num'=>'03', 'title'=>'Pelabelan QR Code', 'desc'=>'Setiap barang diberi kode unik otomatis untuk pelacakan status dan waktu temuan secara presisi.'],
            ['num'=>'04', 'title'=>'Dokumentasi Digital', 'desc'=>'Pelaporan statistik lengkap berbasis data untuk evaluasi layanan dan pertanggungjawaban publik.'],
            ['num'=>'05', 'title'=>'Multi-Kampus Terintegrasi', 'desc'=>'Data terpusat lintas Kampus A, B, dan C - pencarian satu platform untuk seluruh lokasi.'],
        ] as $feat)
        <div class="feature-card">
            <div class="feature-num" style="color:var(--unair-yellow); opacity:1;">{{ $feat['num'] }}</div>
            <div class="feature-title">{{ $feat['title'] }}</div>
            <div class="feature-desc">{{ $feat['desc'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Benefits --}}
<div style="background:var(--bg-card); border-top:1px solid var(--border); border-bottom:1px solid var(--border); padding:64px 24px;">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:40px;">
            <h2 class="section-title">Manfaat Program</h2>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:16px;">
            @foreach([
                ['icon'=>'<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>', 'title'=>'Efisiensi & Akuntabilitas', 'desc'=>'Pendataan rapi mencegah kehilangan dan penyalahgunaan barang.'],
                ['icon'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>', 'title'=>'Kepercayaan Pengguna', 'desc'=>'Mekanisme transparan meningkatkan kepuasan dan citra perpustakaan.'],
                ['icon'=>'<circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/>', 'title'=>'Budaya Tanggung Jawab', 'desc'=>'Pengguna lebih berhati-hati dan berpartisipasi menjaga ketertiban.'],
                ['icon'=>'<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>', 'title'=>'Good Governance', 'desc'=>'Kebijakan jelas memperkuat tata kelola dan pertanggungjawaban publik.'],
            ] as $benefit)
            <div style="text-align:center; padding:24px 16px;">
                <div style="width:52px; height:52px; background:var(--unair-blue-dim); border:1px solid var(--border-glow); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    {{-- Di sini juga sudah saya pastikan round linecap-nya aktif --}}
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--unair-blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $benefit['icon'] !!}</svg>
                </div>
                <div style="font-weight:700; font-size:0.875rem; margin-bottom:8px; color:var(--text-primary);">{{ $benefit['title'] }}</div>
                <div style="font-size:0.8rem; color:var(--text-muted); line-height:1.6;">{{ $benefit['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Cara Mencari Barang --}}
<div class="section">
    <div style="text-align:center; margin-bottom:40px;">
        <h2 class="section-title">Cara Mencari Barang di Aircare</h2>
    </div>
    <div style="position:relative; max-width:800px; margin:0 auto;">
        <div style="position:absolute; top:20px; left:10%; right:10%; height:3px; background:linear-gradient(90deg, var(--unair-blue), var(--unair-blue-light)); border-radius:2px;"></div>
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; position:relative; z-index:2;">
            @foreach([
                ['num'=>'1', 'title'=>'Akses Sistem', 'desc'=>'Kunjungi situs web resmi Aircare melalui browser pada perangkat pribadi Anda.', 'period'=>'Langkah 1'],
                ['num'=>'2', 'title'=>'Cari Barang', 'desc'=>'Gunakan kolom pencarian. Masukkan kata kunci, kategori barang, atau tanggal kehilangan.', 'period'=>'Langkah 2'],
                ['num'=>'3', 'title'=>'Verifikasi Detail', 'desc'=>'Klik barang yang mirip. Periksa foto, ciri-ciri, tanggal kehilangan, dan lokasi penemuan barang.', 'period'=>'Langkah 3'],
                ['num'=>'4', 'title'=>'Klaim & Ambil', 'desc'=>'Temui petugas perpustakaan untuk verifikasi kepemilikan dengan menunjukkan barcode barang.', 'period'=>'Langkah 4'],
            ] as $step)
            <div style="text-align:center;">
                <div style="width:40px; height:40px; border-radius:50%; background:var(--unair-blue); color:#ffffff; font-weight:800; font-size:1rem; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; box-shadow:0 0 0 4px rgba(0,78,154,0.15);">
                    {{ $step['num'] }}
                </div>
                <div style="font-weight:700; font-size:0.875rem; margin-bottom:6px; color:var(--text-primary);">{{ $step['title'] }}</div>
                <div style="font-size:0.75rem; color:var(--text-muted); line-height:1.5; margin-bottom:8px;">{{ $step['desc'] }}</div>
                <div style="font-size:0.7rem; background:var(--unair-blue-dim); color:var(--unair-blue); padding:4px 12px; border-radius:99px; display:inline-block; font-weight:700;">
                    {{ $step['period'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- CTA --}}
<div style="padding:80px 24px; text-align:center; background:radial-gradient(ellipse 60% 80% at 50% 50%, rgba(0,78,154,0.05) 0%, transparent 70%);">
    <h2 style="font-size:2rem; font-weight:800; margin-bottom:12px; color:var(--text-primary);">Kehilangan Barang?</h2>
    <p style="color:var(--text-secondary); font-size:1rem; margin-bottom:32px;">Cari barang kamu di database AIRCARE sekarang.</p>
    <a href="{{ route('items.public') }}" class="btn btn-primary" style="padding:14px 36px; font-size:1rem;">
        Mulai Pencarian →
    </a>
</div>
@endsection