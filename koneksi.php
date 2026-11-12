<?php
$host     = "sql100.infinityfree.com";
$username = "if0_41612666";
$password = "tyn240910";
$database = "if0_41612666_db_sekolah";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
