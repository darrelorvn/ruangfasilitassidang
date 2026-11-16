<?php
require_once "koneksi.php";

if (isset($_GET['logout'])) {
    unset($_SESSION['auth_user']);
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['auth_user'])) {
    header("Location: Ruang dan Fasilitas Sidang.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username, nama, password, role FROM pengguna WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $user = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['auth_user'] = [
                'id' => (int) $user['id'],
                'username' => $user['username'],
                'nama' => $user['nama'],
                'role' => $user['role'],
            ];
            header("Location: Ruang dan Fasilitas Sidang.php");
            exit;
        }

        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ruang dan Fasilitas Sidang</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .profil {
            width: 480px; min-height: 280px; border: 20px solid #491d1d; border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15); margin: 30px auto; padding: 25px;
            box-sizing: border-box; background-color: white;
        }
        .judul { font-size: 20px; font-weight: bold; margin: 10px 0 20px; text-align: center; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 12px; font-size: 14px; }
        label { font-weight: bold; font-size: 14px; display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; margin: 6px 0 12px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .button {
            width: 100%; padding: 10px; background-color: #491d1d; color: white; border: none;
            border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 14px;
        }
    </style>
</head>
<body>
    <article>
        <div class="profil">
            <div class="judul">Login Sistem Ruang & Fasilitas Sidang</div>
            <?php if ($error !== "") { ?>
                <div class="alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php } ?>
            <form method="POST" action="login.php">
                <label>Username</label>
                <input type="text" name="username" required>
                <label>Password</label>
                <input type="password" name="password" required>
                <button type="submit" class="button">Masuk</button>
            </form>
            <div style="margin-top: 16px; padding: 10px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 8px; font-size: 13px;">
                <strong>Akun Demo:</strong><br>
                Admin: <code>admin</code> / <code>admin123</code><br>
                User: <code>user</code> / <code>user123</code>
            </div>
        </div>
    </article>
</body>
</html>
