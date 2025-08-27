<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';

// Hapus data jika ada parameter hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM goal_detail WHERE id = $id");
    header("Location: input-gol.php"); // Refresh agar tidak double delete
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Pencetak Gol</title>
    <style>
    body {
        background: #111 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 400px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #fff;
        margin: 0;
        padding: 20px;
    }

    .form-box {
        background: rgba(0, 0, 0, 0.75);
        padding: 30px 35px;
        border-radius: 14px;
        width: 420px;
        max-width: 95%;
        margin: 50px auto 30px;
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(3px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 24px;
        letter-spacing: 1px;
        color: #ffc107;
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
        color: #ddd;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: none;
        font-size: 14px;
        background-color: #f8f9fa;
        color: #000;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    input:focus,
    select:focus {
        outline: none;
        box-shadow: 0 0 5px #ffc107;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #28a745, #218838);
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
    }

    .success, .error {
        padding: 10px;
        border-radius: 6px;
        margin-top: 10px;
        text-align: center;
        font-weight: bold;
    }

    .success {
        background: #d4edda;
        color: #155724;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
    }

    table {
        width: 95%;
        margin: 30px auto;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
        font-size: 14px;
    }

    th, td {
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 12px;
        text-align: center;
        color: #fff;
    }

    th {
        background: #333;
        font-weight: bold;
        color: #ffc107;
    }

    table tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.02);
    }

    a.hapus-btn {
        text-decoration: none;
        background: #dc3545;
        color: #fff;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        transition: background 0.3s ease;
        display: inline-block;
    }

    a.hapus-btn:hover {
        background: #c82333;
    }

    .back-link {
        text-align: center;
        margin-top: 40px;
    }

    .back-link a {
        color: #fff;
        background: #007bff;
        padding: 12px 22px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        font-size: 15px;
        transition: background 0.3s ease;
    }

    .back-link a:hover {
        background: #0056b3;
    }
</style>
</head>
<body>

<div class="form-box">
    <h2>Input Pencetak Gol</h2>
    <form method="post">
        <label>Pilih Pertandingan:</label>
        <select name="match_id" required>
            <option value="">-- Pilih --</option>
            <?php
            $matches = mysqli_query($conn, "SELECT * FROM pertandingan ORDER BY id DESC");
            while ($m = mysqli_fetch_assoc($matches)) {
                echo "<option value='{$m['id']}'>[{$m['id']}] {$m['team_home']} vs {$m['team_away']} ({$m['match_time']})</option>";
            }
            ?>
        </select>

        <label>Nama Pencetak Gol:</label>
        <input type="text" name="pencetak" required>

        <label>Asal Tim:</label>
        <input type="text" name="tim" required>

        <label>Menit Gol Dicetak:</label>
        <input type="number" name="menit" required>

        <button type="submit" name="submit">Simpan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $match_id = $_POST['match_id'];
        $pencetak = $_POST['pencetak'];
        $tim = $_POST['tim'];
        $menit = $_POST['menit'];

        $sql = "INSERT INTO goal_detail (pertandingan_id, nama_pemain, tim, menit)
                VALUES ($match_id, '$pencetak', '$tim', $menit)";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='success'>✅ Data pencetak gol berhasil disimpan!</div>";
        } else {
            echo "<div class='error'>❌ Gagal simpan: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
</div>

<!-- TABEL DATA -->
<h2 style="text-align:center;">📋 Daftar Gol Tercatat</h2>
<table>
    <tr>
        <th>#</th>
        <th>Nama Pemain</th>
        <th>Tim</th>
        <th>Menit</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data_gol = mysqli_query($conn, "SELECT * FROM goal_detail ORDER BY id DESC");
    $no = 1;
    while ($g = mysqli_fetch_assoc($data_gol)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$g['nama_pemain']}</td>
                <td>{$g['tim']}</td>
                <td>{$g['menit']}'</td>
                <td><a href='?hapus={$g['id']}' class='hapus-btn' onclick='return confirm(\"Hapus data ini?\")'>🗑️</a></td>
              </tr>";
        $no++;
    }
    ?>
</table>

<div class="back-link">
    <a href="dashboard.php">🏠 Kembali ke Dashboard</a>
</div>

</body>
</html>
