<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ruang dan Fasilitas Sidang</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <article>
        <div class="profil" style="width: 480px;">
            <div class="judul" style="text-align: center;">
                Login Sistem Ruang & Fasilitas Sidang
            </div>

            @if(session('success'))
                <div class="alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="form-ruang">
                @csrf

                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" style="width: 100%; padding: 8px; margin: 6px 0 12px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;" required>

                <div style="margin-top: 15px; text-align: center;">
                    <button type="submit" class="button button-submit" style="width: 100%; margin-right: 0;">
                        Masuk
                    </button>
                </div>
            </form>

            <div style="margin-top: 20px; padding: 12px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 8px; font-size: 13px; color: #333;">
                <strong>Akun Demo Hak Akses:</strong>
                <ul style="margin: 6px 0 0; padding-left: 18px;">
                    <li><strong>Admin:</strong> <code>admin</code> / <code>admin123</code> (Tambah, Edit, Hapus semua modul)</li>
                    <li><strong>User / Mahasiswa:</strong> <code>user</code> / <code>user123</code> (Hanya Lihat daftar)</li>
                </ul>
            </div>
        </div>
    </article>
</body>
</html>
