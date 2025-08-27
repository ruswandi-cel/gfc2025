<?php
session_start();
include 'db.php'; // sesuaikan path ke db.php

// Cek login
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

// Pastikan id dan type ada
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: input-match.php?hapus=invalid');
    exit;
}

$id = intval($_GET['id']);

// Cek apakah data pertandingan ada
$result = mysqli_query($conn, "SELECT id FROM pertandingan WHERE id = $id");
if (mysqli_num_rows($result) === 0) {
    header('Location: input-match.php?hapus=notfound');
    exit;
}

// Hapus pertandingan
$hapus = mysqli_query($conn, "DELETE FROM pertandingan WHERE id = $id");

if ($hapus) {
    header('Location: input-match.php?hapus=success');
    exit;
} else {
    header('Location: input-match.php?hapus=error');
    exit;
}
?>
