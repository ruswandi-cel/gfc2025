<?php
$host = "localhost"; // Host database dari InfinityFree (umumnya seperti ini)
$user = "root";            // Username hosting dari gambar kamu
$pass = "";            // Password hosting dari gambar kamu
$db   = "gfc2025";    // Nama database (kamu bisa buat ini nanti di cPanel)

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("❌ Koneksi database gagal: " . mysqli_connect_error());
}
?>