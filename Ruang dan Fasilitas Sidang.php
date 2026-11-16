<?php
require_once "koneksi.php";

$auth_user = $_SESSION['auth_user'] ?? null;
if (!$auth_user) {
    header("Location: login.php");
    exit;
}
$is_admin = ($auth_user['role'] ?? '') === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .profil {
            height: 290px;
            width: 450px;
            border: 20px solid #491d1d;
            border-radius: 180px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            margin-left: 700px;
            margin-top: 30px;
            padding: 15px;
            box-sizing: border-box;
            text-align: center;
            background-color: white;
        }

        .nama {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .status {
            color: gray;
            margin-top: 0;
            text-align: left;
        }

        .button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 20px;
            background-color: white;
            color: black;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <article>
        <div class="profil">
            <p>Ruang dan Fasilitas Sidang</p>
            <div style="font-size: 12px; color: #444; margin-bottom: 10px;">
                Login: <strong><?= htmlspecialchars($auth_user['nama']) ?></strong> (<?= htmlspecialchars(strtoupper($auth_user['role'])) ?>)
                · <a href="login.php?logout=1" style="color: #b30000; text-decoration: none; font-weight: bold;">Logout</a>
            </div>
            
            
               Pengelolaan master ruang ujian/sidang <a href="masterruang.php"><button class="button"><?= $is_admin ? 'Kelola' : 'Lihat' ?></button></a>
               
               Nomor Gedung <a href="nomorgedung.php"><button class="button"><?= $is_admin ? 'Kelola' : 'Lihat' ?></button></a><br>
               Fasilitas proyektor/PC di ruangan <a href="fasilitas.php"><button class="button"><?= $is_admin ? 'Kelola' : 'Lihat' ?></button></a>
        </div>
    </article>
</body>
</html>