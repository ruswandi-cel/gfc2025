<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';

$msg = '';
$edit_mode = false;
$edit_data = [
    'id' => '',
    'score_home' => '',
    'score_away' => ''
];

// Hapus skor
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "UPDATE pertandingan SET score_home = NULL, score_away = NULL WHERE id = $id");
    $msg = "❌ Skor pertandingan ID $id berhasil dihapus.";
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM pertandingan WHERE id = $id");
    if ($row = mysqli_fetch_assoc($res)) {
        $edit_mode = true;
        $edit_data = [
            'id' => $row['id'],
            'score_home' => $row['score_home'],
            'score_away' => $row['score_away']
        ];
    }
}

// Simpan (update atau tambah)
if (isset($_POST['submit'])) {
    $match_id = $_POST['match_id'];
    $score_home = $_POST['score_home'];
    $score_away = $_POST['score_away'];

    $query = "UPDATE pertandingan SET score_home = $score_home, score_away = $score_away WHERE id = $match_id";
    if (mysqli_query($conn, $query)) {
        $msg = "✅ Skor berhasil disimpan!";
    } else {
        $msg = "❌ Gagal menyimpan skor: " . mysqli_error($conn);
    }

    $edit_mode = false;
    $edit_data = ['id' => '', 'score_home' => '', 'score_away' => ''];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Skor Pertandingan</title>
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

    .message {
        text-align: center;
        margin-top: 15px;
        font-weight: bold;
        color: #ffc107;
    }

    .match-table {
        margin: 30px auto;
        width: 95%;
        max-width: 850px;
        border-collapse: collapse;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .match-table th, .match-table td {
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 12px;
        text-align: center;
        color: #fff;
    }

    .match-table th {
        background: #333;
        font-weight: bold;
        color: #ffc107;
    }

    .match-table tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.03);
    }

    a.button {
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 6px;
        margin: 2px;
        display: inline-block;
        font-size: 13px;
        transition: background 0.3s ease;
    }

    .delete-btn {
        background: #dc3545;
        color: #fff;
    }

    .delete-btn:hover {
        background: #c82333;
    }

    .back-home {
        text-align:center;
        margin-top: 40px;
    }

    .back-home a {
        color: #fff;
        background:#007bff;
        padding:12px 22px;
        border-radius:10px;
        text-decoration:none;
        font-weight: bold;
        font-size: 15px;
        transition: background 0.3s ease;
    }

    .back-home a:hover {
        background: #0056b3;
    }
</style>
</head>
<body>

<div class="form-box">
    <h2><?= $edit_mode ? "✏️ Edit Skor Pertandingan" : "Input Skor Pertandingan" ?></h2>
    <form method="post">
        <label>Pilih Pertandingan:</label>
        <select name="match_id" required <?= $edit_mode ? "readonly disabled" : "" ?>>
            <option value="">-- Pilih --</option>
            <?php
            $matches = mysqli_query($conn, "SELECT * FROM pertandingan ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($matches)) {
                $selected = $edit_mode && $edit_data['id'] == $row['id'] ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>[{$row['id']}] {$row['team_home']} vs {$row['team_away']}</option>";
            }
            ?>
        </select>

        <label>Skor Tim Home:</label>
        <input type="number" name="score_home" required min="0" value="<?= $edit_data['score_home'] ?>">

        <label>Skor Tim Away:</label>
        <input type="number" name="score_away" required min="0" value="<?= $edit_data['score_away'] ?>">

        <button type="submit" name="submit"><?= $edit_mode ? "Update Skor" : "Simpan Skor" ?></button>
    </form>

    <?php if ($msg): ?>
        <div class="message"><?= $msg ?></div>
    <?php endif; ?>
</div>

<!-- Tabel daftar skor -->
<table class="match-table">
    <tr>
        <th>ID</th>
        <th>Tim</th>
        <th>Skor</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = mysqli_query($conn, "SELECT * FROM pertandingan WHERE score_home IS NOT NULL OR score_away IS NOT NULL ORDER BY id DESC");
    while ($m = mysqli_fetch_assoc($data)) {
        echo "<tr>
                <td>{$m['id']}</td>
                <td>{$m['team_home']} vs {$m['team_away']}</td>
                <td>{$m['score_home']} - {$m['score_away']}</td>
                <td>
                    <a href='input-skor.php?hapus={$m['id']}' class='button delete-btn' onclick=\"return confirm('Hapus skor pertandingan ini?')\">🗑️ Hapus</a>
                </td>
              </tr>";
    }
    ?>
</table>

<div class="back-home">
    <a href="dashboard.php">🏠 Kembali ke Home</a>
</div>

</body>
</html>
