<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

// cek user di database
$query  = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 1) {
    // login berhasil — simpan data ke session
    $user = mysqli_fetch_assoc($result);
    $_SESSION['id']       = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];

    // arahkan sesuai role
    if ($role == 'guru') {
        header("Location: dashboard_guru.php");
    } else {
        header("Location: dashboard_siswa.php");
    }
} else {
    // login gagal
    header("Location: login.php?error=1");
}
?>
