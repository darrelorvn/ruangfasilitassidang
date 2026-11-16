<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruang</title>
    <!-- File CSS Terpisah -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <article>
        <div class="profil">
            <div class="judul">
                Tambah Ruang
            </div>

            <!-- Notifikasi Error Validasi -->
            @if(isset($errors) && $errors->any())
                <div class="alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulir Tambah Ruang Baru (Terhubung ke Controller store() dan Model MasterRuang) -->
            <form method="POST" action="{{ route('ruang.store') }}" class="form-ruang">
                @csrf
                
                <label for="N.Ruang">Nama Ruang:</label>
                <input type="text" id="N.Ruang" name="nama_ruang" value="{{ old('nama_ruang') }}" placeholder="Masukkan nama ruang sidang" required>

                <label for="GD">Gedung:</label>
                <input type="text" id="GD" name="gedung" value="{{ old('gedung') }}" placeholder="Masukkan nama gedung (contoh: Gedung D)" required>

                <div style="margin-top: 20px;">
                    <button type="submit" class="button button-submit">
                        Simpan
                    </button>

                    <a href="{{ route('ruang.index') }}" class="button">
                        Batal
                    </a>
                </div>
            </form>

            <a href="{{ route('ruang.index') }}" class="kembali">
                <button type="button" class="button">Kembali</button>
            </a>
        </div>
    </article>
</body>
</html>
