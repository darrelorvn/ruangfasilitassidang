<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Ruang Ujian/Sidang</title>
    <!-- File CSS Terpisah -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <article>
        <div class="profil">

            <div class="judul">
                Master Ruang Ujian/Sidang
            </div>

            <!-- Notifikasi Flash Message Sukses -->
            @if(session('success'))
                <div class="alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

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

            <!-- Tombol Menu Tambah Ruang (Pindah ke View TambahRuang tanpa inline) -->
            <div>
                <a href="{{ route('ruang.create') }}" class="button-tambah">
                    + Tambah Ruang
                </a>
            </div>

            <!-- Tabel Data Ruang (READ) -->
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 40%;">Nama Ruang</th>
                        <th style="width: 25%;">Gedung</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($data_ruang as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->nama_ruang }}</td>
                            <td>{{ $row->gedung }}</td>
                            <td>
                                <!-- Tombol Edit (Pindah ke halaman Edit) -->
                                <a href="{{ route('ruang.edit', $row->id) }}" class="button">
                                    Edit
                                </a>

                                <!-- Tombol Hapus (DELETE ke Database) -->
                                <form method="POST" action="{{ route('ruang.destroy', $row->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus ruang {{ $row->nama_ruang }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 20px; color: #888;">
                                Belum ada data ruang sidang di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Tombol Kembali ke Portal Menu Utama -->
            <a href="{{ route('ruang.dashboard') }}" class="kembali">
                <button type="button" class="button">Kembali ke Menu Utama</button>
            </a>

        </div>
    </article>

</body>
</html>
