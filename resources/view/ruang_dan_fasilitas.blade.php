<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang dan Fasilitas Sidang</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 40px 0;">
    <article>
        <div class="profil-portal">
            <span class="badge-laravel">Laravel MVC + Database CRUD</span>
            <div class="judul">Ruang dan Fasilitas Sidang</div>

            @php
                $authUser = session('auth_user');
                $isAdmin = ($authUser['role'] ?? '') === 'admin';
            @endphp
            @if($authUser)
                <div style="font-size: 12px; color: #444; margin-bottom: 12px;">
                    Login: <strong>{{ $authUser['nama'] }}</strong>
                    ({{ strtoupper($authUser['role']) }})
                    · <a href="{{ route('logout') }}" style="color: #b30000; text-decoration: none; font-weight: bold;">Logout</a>
                </div>
            @endif
            
            <div class="menu-item">
                <span>Pengelolaan master ruang ujian/sidang</span>
                <a href="{{ route('ruang.index') }}">
                    <button type="button" class="button">{{ $isAdmin ? 'Kelola' : 'Lihat' }}</button>
                </a>
            </div>
            
            <div class="menu-item">
                <span>Nomor Gedung</span>
                <a href="{{ url('/nomorgedung.php') }}">
                    <button type="button" class="button">{{ $isAdmin ? 'Kelola' : 'Lihat' }}</button>
                </a>
            </div>

            <div class="menu-item">
                <span>Fasilitas proyektor/PC di ruangan</span>
                <a href="{{ url('/fasilitas.php') }}">
                    <button type="button" class="button">{{ $isAdmin ? 'Kelola' : 'Lihat' }}</button>
                </a>
            </div>
        </div>
    </article>
</body>
</html>
