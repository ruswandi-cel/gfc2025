<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';

// Proses Hapus Statistik
if (isset($_GET['hapus'])) {
    $idHapus = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM statistik WHERE id = $idHapus");
    header("Location: input-statistik.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Statistik Pertandingan</title>
    <style>
    body {
        background: #0f0f0f url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 350px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #e0e0e0;
        margin: 0;
        padding: 20px;
    }

    .form-box {
        background: rgba(20, 20, 20, 0.95);
        padding: 30px;
        border-radius: 15px;
        width: 480px;
        max-width: 95%;
        margin: 50px auto;
        box-shadow: 0 0 20px rgba(0, 123, 255, 0.4);
        transition: all 0.3s ease-in-out;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 24px;
        color: #00bfff;
        text-shadow: 1px 1px 3px #000;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #ccc;
    }

    input[type="text"],
    input[type="number"],
    select {
        width: 100%;
        padding: 12px;
        margin-bottom: 16px;
        border-radius: 8px;
        border: 1px solid #333;
        font-size: 14px;
        background-color: #1a1a1a;
        color: #f5f5f5;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
    }

    input:focus,
    select:focus {
        border: 1px solid #00bfff;
        outline: none;
        background-color: #222;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #00bfff;
        color: white;
        border: none;
        font-weight: bold;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(0, 191, 255, 0.6);
        transition: 0.3s;
    }

    button:hover {
        background-color: #0099cc;
        box-shadow: 0 0 15px rgba(0, 191, 255, 0.8);
    }

    .success, .error {
        margin-top: 15px;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
    }

    .success { background-color: #d4edda; color: #155724; }
    .error { background-color: #f8d7da; color: #721c24; }

    table {
        width: 96%;
        margin: 40px auto;
        border-collapse: collapse;
        background: #1a1a1a;
        color: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.4);
    }

    table th {
        background-color: #007bff;
        color: white;
        padding: 12px;
        font-size: 14px;
    }

    table td {
        padding: 10px;
        border: 1px solid #333;
        font-size: 13px;
    }

    table tr:nth-child(even) {
        background-color: #222;
    }

    .hapus-btn {
        color: #fff;
        background: #dc3545;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .hapus-btn:hover {
        background: #c82333;
    }

    a.back-home {
        display: inline-block;
        color: #fff;
        background: #007bff;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        margin-top: 30px;
    }

    a.back-home:hover {
        background: #0056b3;
    }

    div[style*="text-align:center"] {
        margin-top: 30px;
    }
</style>
</head>
<body>

<div class="form-box">
    <h2>Input Statistik Pertandingan</h2>
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

        <label>Nama Tim:</label>
        <input type="text" name="team" required>

        <label>Nama Kiper:</label>
        <input type="text" name="nama_kiper" required>

        <label>Jumlah Menit Main:</label>
        <input type="number" name="menit_main" required>

        <label>Kebobolan:</label>
        <input type="number" name="kebobolan" required>

        <label>Clean Sheet (1 = Ya, 0 = Tidak):</label>
        <input type="number" name="clean_sheet" min="0" max="1" required>

        <label>Kartu Kuning:</label>
        <input type="number" name="kartu_kuning" required>

        <label>Kartu Merah:</label>
        <input type="number" name="kartu_merah" required>

        <button type="submit" name="submit">Simpan Statistik</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $match_id = $_POST['match_id'];
        $team = $_POST['team'];
        $nama_kiper = $_POST['nama_kiper'];
        $menit_main = $_POST['menit_main'];
        $kebobolan = $_POST['kebobolan'];
        $clean_sheet = $_POST['clean_sheet'];
        $kuning = $_POST['kartu_kuning'];
        $merah = $_POST['kartu_merah'];

        $insert = mysqli_query($conn, "INSERT INTO statistik 
            (match_id, team, nama_kiper, menit_main, kebobolan, clean_sheet, kartu_kuning, kartu_merah) 
            VALUES ($match_id, '$team', '$nama_kiper', $menit_main, $kebobolan, $clean_sheet, $kuning, $merah)");

        if ($insert) {
            echo "<div class='success'>✅ Statistik berhasil disimpan!</div>";
        } else {
            echo "<div class='error'>❌ Gagal menyimpan: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
</div>

<!-- Daftar Statistik -->
<table>
    <tr>
        <th>ID</th>
        <th>Match</th>
        <th>Tim</th>
        <th>Kiper</th>
        <th>Menit</th>
        <th>Kebobolan</th>
        <th>CS</th>
        <th>Kuning</th>
        <th>Merah</th>
        <th>Hapus</th>
    </tr>
    <?php
    $stats = mysqli_query($conn, "SELECT s.*, p.team_home, p.team_away FROM statistik s 
        LEFT JOIN pertandingan p ON s.match_id = p.id ORDER BY s.id DESC");

    while ($d = mysqli_fetch_assoc($stats)) {
        echo "<tr>
                <td>{$d['id']}</td>
                <td>{$d['team_home']} vs {$d['team_away']}</td>
                <td>{$d['team']}</td>
                <td>{$d['nama_kiper']}</td>
                <td>{$d['menit_main']}</td>
                <td>{$d['kebobolan']}</td>
                <td>{$d['clean_sheet']}</td>
                <td>{$d['kartu_kuning']}</td>
                <td>{$d['kartu_merah']}</td>
                <td><a href='input-statistik.php?hapus={$d['id']}' class='hapus-btn' onclick=\"return confirm('Hapus data ini?')\">🗑️</a></td>
              </tr>";
    }
    ?>
</table>

<div style="text-align:center; margin-top: 20px;">
    <a href="dashboard.php" style="color: #fff; background:#007bff; padding:10px 20px; border-radius:8px; text-decoration:none;">🏠 Kembali ke Home</a>
</div>
</body>
</html>
