<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AIRCARE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <div class="login-brand">
            <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:8px;">
                <svg width="40" height="40" viewBox="0 0 28 28" fill="none">
                    <rect width="28" height="28" rx="8" fill="#00BFA5"/>
                    <path d="M7 10l7-4 7 4v8l-7 4-7-4V10z" stroke="white" stroke-width="1.5" fill="none"/>
                    <path d="M14 6v16M7 10l7 4 7-4" stroke="white" stroke-width="1.5"/>
                </svg>
                <div class="login-brand-name">AIRCARE</div>
            </div>
            <div class="login-brand-tagline">Airlangga Library Care & Return Service</div>
        </div>

        <div class="login-card">
            <div class="login-title">Masuk ke Sistem</div>

            @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@aircare.unair.ac.id" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:0.8rem; color:var(--text-muted); cursor:pointer;">
                        <input type="checkbox" name="remember" style="accent-color:var(--teal);">
                        Ingat saya
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px;">
                    Masuk
                </button>
            </form>

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--border);">
                <div style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-bottom:10px;">Akun Demo</div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <div style="background:var(--bg-card-dark); border-radius:var(--radius-sm); padding:10px 14px; font-size:0.75rem; font-family:monospace;">
                        <span style="color:var(--teal);">Admin:</span> admin@aircare.unair.ac.id / password
                    </div>
                    <div style="background:var(--bg-card-dark); border-radius:var(--radius-sm); padding:10px 14px; font-size:0.75rem; font-family:monospace;">
                        <span style="color:var(--teal);">Staff A:</span> staff.a@aircare.unair.ac.id / password
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align:center; margin-top:16px;">
            <a href="{{ route('home') }}" style="color:var(--text-muted); font-size:0.8rem; text-decoration:none;">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
</body>
</html>
