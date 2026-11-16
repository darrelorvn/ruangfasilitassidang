<?php
require_once "koneksi.php";

$auth_user = $_SESSION['auth_user'] ?? null;
if (!$auth_user) {
    $login_url = defined('LARAVEL_START') ? '/login' : 'login.php';
    header("Location: $login_url");
    if (!defined('LARAVEL_START')) {
        exit;
    }
    return;
}

$is_admin = ($auth_user['role'] ?? '') === 'admin';
$logout_url = defined('LARAVEL_START') ? '/logout' : 'login.php?logout=1';

if (!$is_admin && ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['mode']) || isset($_GET['edit']))) {
    header("Location: fasilitas.php?akses=ditolak");
    if (!defined('LARAVEL_START')) {
        exit;
    }
    return;
}

$opsi_status = ['Ada', 'Tidak Ada'];

if (isset($_POST['tambah'])) {
    $nama_ruang = trim($_POST['nama_ruang'] ?? '');
    $proyektor = trim($_POST['proyektor'] ?? '');
    $pc = trim($_POST['pc'] ?? '');

    if (
        $nama_ruang !== ""
        && in_array($proyektor, $opsi_status, true)
        && in_array($pc, $opsi_status, true)
    ) {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO fasilitas_ruang (nama_ruang, proyektor, pc) VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "sss", $nama_ruang, $proyektor, $pc);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: fasilitas.php");
        if (!defined('LARAVEL_START')) {
            exit;
        }
        return;
    }
}

if (isset($_POST['edit'])) {
    $id = (int) ($_POST['id'] ?? 0);
    $nama_ruang = trim($_POST['nama_ruang'] ?? '');
    $proyektor = trim($_POST['proyektor'] ?? '');
    $pc = trim($_POST['pc'] ?? '');

    if (
        $id > 0
        && $nama_ruang !== ""
        && in_array($proyektor, $opsi_status, true)
        && in_array($pc, $opsi_status, true)
    ) {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE fasilitas_ruang SET nama_ruang = ?, proyektor = ?, pc = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "sssi", $nama_ruang, $proyektor, $pc, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: fasilitas.php");
        if (!defined('LARAVEL_START')) {
            exit;
        }
        return;
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) ($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM fasilitas_ruang WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: fasilitas.php");
    if (!defined('LARAVEL_START')) {
        exit;
    }
    return;
}

$data_edit = null;

if (isset($_GET['edit'])) {
    $id_edit = (int) $_GET['edit'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM fasilitas_ruang WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id_edit);
    mysqli_stmt_execute($stmt);

    $hasil_edit = mysqli_stmt_get_result($stmt);
    $data_edit = mysqli_fetch_assoc($hasil_edit);

    mysqli_stmt_close($stmt);
}

$data_fasilitas = mysqli_query(
    $conn,
    "SELECT * FROM fasilitas_ruang ORDER BY id ASC"
);

$kembali_url = (defined('LARAVEL_START') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '8000'))
    ? '/menu'
    : 'Ruang dan Fasilitas Sidang.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Ruangan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .profil {
            width: 700px;
            min-height: 300px;
            border: 20px solid #491d1d;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            margin: 30px auto;
            padding: 25px;
            box-sizing: border-box;
            background-color: white;
        }

        .judul {
            font-size: 20px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
        }

        .button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 20px;
            background-color: white;
            color: black;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .kembali {
            display: inline-block;
            margin-top: 15px;
            color: black;
            text-decoration: none;
        }

        .form-fasilitas {
            width: 90%;
            margin: 15px auto;
        }

        .form-fasilitas input,
        .form-fasilitas select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 12px;
            box-sizing: border-box;
        }

        @media (max-width: 760px) {
            .profil {
                width: 95%;
                padding: 15px;
                border-width: 10px;
            }
        }
    </style>
</head>

<body>

    <article>
        <div class="profil">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div class="judul" style="margin: 0;">
                    Fasilitas Proyektor/PC
                </div>
                <div style="font-size: 13px; color: #444;">
                    <strong><?= htmlspecialchars($auth_user['nama']) ?></strong> (<?= htmlspecialchars(strtoupper($auth_user['role'])) ?>)
                    · <a href="<?= $logout_url ?>" style="color: #b30000; text-decoration: none; font-weight: bold;">Logout</a>
                </div>
            </div>

            <?php if (isset($_GET['akses']) && $_GET['akses'] === 'ditolak') { ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 6px; border: 1px solid #f5c6cb; margin-bottom: 15px; font-size: 14px;">
                    Akses ditolak! Hanya Admin yang dapat menambah, mengubah, atau menghapus data.
                </div>
            <?php } ?>

            <?php if (!$is_admin) { ?>
                <div style="background: #fff3cd; color: #856404; padding: 10px 15px; border-radius: 6px; border: 1px solid #ffeeba; margin-bottom: 15px; font-size: 14px;">
                    Mode Hanya Lihat (Role: User/Mahasiswa). Hanya Admin yang dapat menambah, mengubah, atau menghapus data.
                </div>
            <?php } ?>

            <?php if ($is_admin) { ?>
                <a href="fasilitas.php?mode=tambah" class="button">
                    + Tambah Fasilitas
                </a>
            <?php } ?>

            <?php if (isset($_GET['mode']) && $_GET['mode'] === 'tambah') { ?>
                <div class="form-fasilitas">
                    <h3>Tambah Fasilitas</h3>

                    <form method="POST" action="fasilitas.php">
                        <label>Ruang</label>
                        <input type="text" name="nama_ruang" placeholder="Contoh: Ruang Sidang 4" required>

                        <label>Proyektor</label>
                        <select name="proyektor" required>
                            <?php foreach ($opsi_status as $status) { ?>
                                <option value="<?= $status ?>"><?= $status ?></option>
                            <?php } ?>
                        </select>

                        <label>PC</label>
                        <select name="pc" required>
                            <?php foreach ($opsi_status as $status) { ?>
                                <option value="<?= $status ?>"><?= $status ?></option>
                            <?php } ?>
                        </select>

                        <button type="submit" name="tambah" class="button">
                            Simpan
                        </button>

                        <a href="fasilitas.php" class="button">
                            Batal
                        </a>
                    </form>
                </div>
            <?php } ?>

            <?php if (isset($_GET['edit'])) { ?>
                <?php if ($data_edit) { ?>
                    <div class="form-fasilitas">
                        <h3>Edit Fasilitas</h3>

                        <form method="POST" action="fasilitas.php">
                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int) $data_edit['id'] ?>"
                            >

                            <label>Ruang</label>
                            <input
                                type="text"
                                name="nama_ruang"
                                value="<?= htmlspecialchars($data_edit['nama_ruang']) ?>"
                                required
                            >

                            <label>Proyektor</label>
                            <select name="proyektor" required>
                                <?php foreach ($opsi_status as $status) { ?>
                                    <option
                                        value="<?= $status ?>"
                                        <?= $data_edit['proyektor'] === $status ? 'selected' : '' ?>
                                    ><?= $status ?></option>
                                <?php } ?>
                            </select>

                            <label>PC</label>
                            <select name="pc" required>
                                <?php foreach ($opsi_status as $status) { ?>
                                    <option
                                        value="<?= $status ?>"
                                        <?= $data_edit['pc'] === $status ? 'selected' : '' ?>
                                    ><?= $status ?></option>
                                <?php } ?>
                            </select>

                            <button type="submit" name="edit" class="button">
                                Simpan Perubahan
                            </button>

                            <a href="fasilitas.php" class="button">
                                Batal
                            </a>
                        </form>
                    </div>
                <?php } else { ?>
                    <p>Data fasilitas tidak ditemukan.</p>
                <?php } ?>
            <?php } ?>

            <br><br>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Ruang</th>
                    <th>Proyektor</th>
                    <th>PC</th>
                    <?php if ($is_admin) { ?>
                        <th>Aksi</th>
                    <?php } ?>
                </tr>

                <?php
                $no = 1;

                if ($data_fasilitas && mysqli_num_rows($data_fasilitas) > 0) {
                    while ($row = mysqli_fetch_assoc($data_fasilitas)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_ruang']) ?></td>
                        <td><?= htmlspecialchars($row['proyektor']) ?></td>
                        <td><?= htmlspecialchars($row['pc']) ?></td>
                        <?php if ($is_admin) { ?>
                            <td>
                                <a
                                    href="fasilitas.php?edit=<?= (int) $row['id'] ?>"
                                    class="button"
                                >Edit</a>

                                <form
                                    method="POST"
                                    action="fasilitas.php"
                                    style="display:inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data fasilitas ini?');"
                                >
                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= (int) $row['id'] ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="hapus"
                                        class="button"
                                    >Hapus</button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="<?= $is_admin ? 5 : 4 ?>">Belum ada data fasilitas.</td>
                    </tr>
                <?php } ?>
            </table>

            <a href="<?= $kembali_url ?>" class="kembali">
                <button type="button" class="button">Kembali</button>
            </a>

        </div>
    </article>

</body>

</html>
