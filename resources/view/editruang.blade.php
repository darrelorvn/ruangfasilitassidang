<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruang</title>
    <!-- File CSS Terpisah -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <article>
        <div class="profil">
            <div class="judul">
                Edit Ruang Sidang
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

            <form method="POST" action="{{ route('ruang.update', $data_edit->id) }}" class="form-ruang">
                @csrf
                @method('PUT')
                
                <label for="nama_ruang">Nama Ruang:</label>
                <input type="text" id="nama_ruang" name="nama_ruang" value="{{ old('nama_ruang', $data_edit->nama_ruang) }}" required>

                <label for="gedung">Gedung:</label>
                <input type="text" id="gedung" name="gedung" value="{{ old('gedung', $data_edit->gedung) }}" required>

                <div style="margin-top: 20px;">
                    <button type="submit" class="button button-submit">
                        Simpan Perubahan
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
