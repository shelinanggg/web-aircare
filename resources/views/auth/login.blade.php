<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AIRCARE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <div class="login-brand">
            <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:8px;">
                <img src="https://arsip.unair.ac.id/wp-content/uploads/2019/01/cropped-logo-unair-1.png" alt="Logo UNAIR" style="height: 40px; width: auto; object-fit: contain;">
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
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required style="padding-right: 40px;">
                        
                        <button type="button" onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); display: flex; align-items: center; justify-content: center; padding: 4px;" title="Tampilkan/Sembunyikan Password">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg id="eye-off-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:0.875rem; color:var(--text-secondary); cursor:pointer; font-weight:500;">
                        <input type="checkbox" name="remember" style="accent-color:var(--unair-blue); width: 16px; height: 16px;">
                        Ingat saya
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px;">
                    Masuk
                </button>
            </form>

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--border);">
                <div style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-bottom:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Akun Demo</div>
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <div style="background:var(--bg-card-dark); border:1px solid var(--border); border-radius:var(--radius-sm); padding:10px 14px; font-size:0.8rem; font-family:monospace; color:var(--text-primary);">
                        <span style="color:var(--unair-blue); font-weight:700;">Admin:</span> admin@aircare.unair.ac.id / password
                    </div>
                    <div style="background:var(--bg-card-dark); border:1px solid var(--border); border-radius:var(--radius-sm); padding:10px 14px; font-size:0.8rem; font-family:monospace; color:var(--text-primary);">
                        <span style="color:var(--unair-blue); font-weight:700;">Staff A:</span> staff.a@aircare.unair.ac.id / password
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="{{ route('home') }}" style="color:var(--text-secondary); font-size:0.875rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeOffIcon = document.getElementById('eye-off-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.style.display = 'none';
            eyeOffIcon.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
        }
    }
</script>
</body>
</html>