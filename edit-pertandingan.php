<?php
include 'db.php';
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID pertandingan tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$match = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pertandingan WHERE id = $id"));

if (!$match) {
    echo "Data pertandingan tidak ditemukan.";
    exit;
}

if (isset($_POST['submit'])) {
    $match_time = $_POST['match_time'];
    $team_home = $_POST['team_home'];
    $team_away = $_POST['team_away'];
    $start_time = $_POST['start_time'];
    $status = $_POST['status'];

    $update = mysqli_query($conn, "UPDATE pertandingan SET 
        match_time = '$match_time',
        team_home = '$team_home',
        team_away = '$team_away',
        start_time = '$start_time',
        status = '$status'
        WHERE id = $id");

    if ($update) {
        echo "<p style='color:lightgreen;'>✅ Pertandingan berhasil diupdate!</p>";
        echo "<script>setTimeout(() => window.location.href='input-match.php', 1500);</script>";
    } else {
        echo "<p style='color:red;'>❌ Gagal update: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pertandingan</title>
    <style>
    body {
        background: #0d1117 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 350px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #fff;
        margin: 0;
        padding: 30px;
    }

    .form-box {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 25px;
        border-radius: 15px;
        width: 420px;
        margin: 60px auto;
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease-in-out;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #ffce00;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
        margin-top: 10px;
    }

    input[type="text"],
    input[type="datetime-local"],
    select {
        width: 100%;
        padding: 10px 14px;
        margin-bottom: 14px;
        border-radius: 8px;
        border: none;
        background: rgba(255, 255, 255, 0.07);
        color: #fff;
        transition: 0.2s ease;
        outline: none;
    }

    input:focus,
    select:focus {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid #ffc107;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(145deg, #ffc107, #ffdd57);
        border: none;
        color: #111;
        font-weight: bold;
        font-size: 16px;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.2s ease-in-out;
    }

    button:hover {
        background: linear-gradient(145deg, #ffca2c, #ffe066);
        transform: scale(1.02);
    }

    a {
        color: #fff;
        background: #007bff;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.2s ease;
        font-weight: bold;
    }

    a:hover {
        background: #0056b3;
    }

    div[style*="text-align:center"] {
        margin-top: 40px;
    }
</style>
</head>
<body>
    <div class="form-box">
        <h2>Edit Jadwal Pertandingan</h2>
        <form method="post">
            <label>Waktu Match</label>
            <input type="text" name="match_time" value="<?= $match['match_time'] ?>" required>

            <label>Team Home</label>
            <input type="text" name="team_home" value="<?= $match['team_home'] ?>" required>

            <label>Team Away</label>
            <input type="text" name="team_away" value="<?= $match['team_away'] ?>" required>

            <label>Waktu Kick-Off</label>
            <input type="datetime-local" name="start_time" value="<?= date('Y-m-d\TH:i', strtotime($match['start_time'])) ?>" required>

            <label>Status Pertandingan</label>
            <select name="status" required>
                <option value="belum" <?= $match['status'] == 'belum' ? 'selected' : '' ?>>Belum</option>
                <option value="berlangsung" <?= $match['status'] == 'berlangsung' ? 'selected' : '' ?>>Berlangsung</option>
                <option value="selesai" <?= $match['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>

            <button type="submit" name="submit">Update Pertandingan</button>
        </form>
    </div>
<div style="text-align:center; margin-top: 20px;">
    <a href="dashboard.php" style="color: #fff; background:#007bff; padding:10px 20px; border-radius:8px; text-decoration:none;">🏠 Kembali ke Home</a>
</div>
</body>
</html>
