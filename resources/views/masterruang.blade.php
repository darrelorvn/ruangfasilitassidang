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

            @php
                $authUser = session('auth_user');
                $isAdmin = ($authUser['role'] ?? '') === 'admin';
            @endphp

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div class="judul" style="margin: 0;">
                    Master Ruang Ujian/Sidang
                </div>
                @if($authUser)
                    <div style="font-size: 13px; color: #444;">
                        <strong>{{ $authUser['nama'] }}</strong> ({{ strtoupper($authUser['role']) }})
                        · <a href="{{ route('logout') }}" style="color: #b30000; text-decoration: none; font-weight: bold;">Logout</a>
                    </div>
                @endif
            </div>

            @if(session('error'))
                <div class="alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(!$isAdmin)
                <div style="background: #fff3cd; color: #856404; padding: 10px 15px; border-radius: 6px; border: 1px solid #ffeeba; margin-bottom: 15px; font-size: 14px;">
                    Mode Hanya Lihat (Role: User/Mahasiswa). Hanya Admin yang dapat menambah, mengubah, atau menghapus data.
                </div>
            @endif

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

            <!-- Tombol Menu Tambah Ruang (Hanya untuk Admin) -->
            @if($isAdmin)
                <div>
                    <a href="{{ route('ruang.create') }}" class="button-tambah">
                        + Tambah Ruang
                    </a>
                </div>
            @endif

            <!-- Tabel Data Ruang (READ) -->
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 40%;">Nama Ruang</th>
                        <th style="width: 25%;">Gedung</th>
                        @if($isAdmin)
                            <th style="width: 25%;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($data_ruang as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->nama_ruang }}</td>
                            <td>{{ $row->gedung }}</td>
                            @if($isAdmin)
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
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isAdmin ? 4 : 3 }}" style="padding: 20px; color: #888;">
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
