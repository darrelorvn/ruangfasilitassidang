<?php
if (!defined('LARAVEL_START') && session_status() === PHP_SESSION_NONE) {
    session_start();
}

mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$password = "";
$database = "db_ruang_sidang";

$conn = @mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    $conn = @mysqli_connect("127.0.0.1", $user, $password, $database, 3308);
}

if (!$conn) {
    $conn_init = @mysqli_connect($host, $user, $password) ?: @mysqli_connect("127.0.0.1", $user, $password, "", 3308);
    if ($conn_init) {
        mysqli_query($conn_init, "CREATE DATABASE IF NOT EXISTS `$database`");
        mysqli_select_db($conn_init, $database);
        $conn = $conn_init;
    }
}

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS master_ruang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruang VARCHAR(100) NOT NULL,
    gedung VARCHAR(100) NOT NULL
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS nomor_gedung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_gedung VARCHAR(100) NOT NULL
)");

$cek_gedung = mysqli_query($conn, "SELECT COUNT(*) AS total FROM nomor_gedung");
if ($cek_gedung && ($row_g = mysqli_fetch_assoc($cek_gedung)) && (int)$row_g['total'] === 0) {
    mysqli_query($conn, "INSERT INTO nomor_gedung (nama_gedung) VALUES ('Gedung A'), ('Gedung B'), ('Gedung D')");
}

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS fasilitas_ruang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruang VARCHAR(100) NOT NULL,
    proyektor VARCHAR(50) NOT NULL,
    pc VARCHAR(50) NOT NULL
)");

$cek_fasilitas = mysqli_query($conn, "SELECT COUNT(*) AS total FROM fasilitas_ruang");
if ($cek_fasilitas && ($row_f = mysqli_fetch_assoc($cek_fasilitas)) && (int)$row_f['total'] === 0) {
    mysqli_query($conn, "INSERT INTO fasilitas_ruang (nama_ruang, proyektor, pc) VALUES
        ('Ruang Sidang 1', 'Ada', 'Ada'),
        ('Ruang Sidang 2', 'Ada', 'Tidak Ada'),
        ('Ruang Sidang 3', 'Tidak Ada', 'Ada')");
}

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
)");

$cek_pengguna = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengguna");
if ($cek_pengguna && ($row_p = mysqli_fetch_assoc($cek_pengguna)) && (int)$row_p['total'] === 0) {
    $pass_admin = password_hash('admin123', PASSWORD_DEFAULT);
    $pass_user = password_hash('user123', PASSWORD_DEFAULT);

    $stmt_seed = mysqli_prepare($conn, "INSERT INTO pengguna (username, nama, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt_seed) {
        $u1 = 'admin'; $n1 = 'Administrator'; $r1 = 'admin';
        mysqli_stmt_bind_param($stmt_seed, "ssss", $u1, $n1, $pass_admin, $r1);
        mysqli_stmt_execute($stmt_seed);

        $u2 = 'user'; $n2 = 'Mahasiswa'; $r2 = 'user';
        mysqli_stmt_bind_param($stmt_seed, "ssss", $u2, $n2, $pass_user, $r2);
        mysqli_stmt_execute($stmt_seed);

        mysqli_stmt_close($stmt_seed);
    }
}
?>
