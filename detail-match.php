<?php include '../admin/db.php'; ?>
<?php
if (!isset($_GET['id'])) {
    echo "ID pertandingan tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);

// Ambil info pertandingan
$match = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pertandingan WHERE id = $id"));

// Ambil detail gol
$goals = mysqli_query($conn, "SELECT * FROM goal_detail WHERE pertandingan_id = $id ORDER BY menit ASC");

// Ambil statistik
$stats = mysqli_query($conn, "SELECT * FROM statistik WHERE match_id = $id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Match - GFC 2025</title>
    <style>
        body {
            background: #111;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            padding: 30px;
        }

        .box {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 0 10px rgba(255,255,255,0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        h3 {
            font-size: 20px;
            margin-bottom: 15px;
            border-bottom: 1px solid #333;
            padding-bottom: 8px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 4px solid #007bff;
            background: rgba(255,255,255,0.03);
            border-radius: 6px;
            font-size: 15px;
            line-height: 1.6;
        }

        .team-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ffd700;
            letter-spacing: 1px;
        }

        .score {
            text-align: center;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #00ffcc;
        }

        a {
            transition: 0.3s ease;
        }

        a:hover {
            background: #0056b3;
        }

        a.button {
            color: #fff;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }

        strong {
            color: #ffffff;
            font-weight: 600;
        }

        .centered {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>📋 Detail Pertandingan</h2>

<div class="box">
    <div class="team-title"><?= $match['team_home'] ?> vs <?= $match['team_away'] ?></div>
    <div class="score"><?= $match['score_home'] ?> - <?= $match['score_away'] ?></div>
    <ul>
        <li>🕒 <strong>Waktu Kick-Off:</strong> <?= $match['start_time'] ?></li>
        <li>📌 <strong>Status:</strong> <?= ucfirst($match['status']) ?></li>
    </ul>
</div>

<div class="box">
    <h3>⚽ Pencetak Gol</h3>
    <ul>
        <?php while ($g = mysqli_fetch_assoc($goals)) { ?>
            <li>⚽ <?= $g['nama_pemain'] ?> (<?= $g['tim'] ?>) - menit <?= $g['menit'] ?>'</li>
        <?php } ?>
        <?php if (mysqli_num_rows($goals) == 0) { ?>
            <li>Tidak ada gol tercipta.</li>
        <?php } ?>
    </ul>
</div>

<div class="box">
    <h3>📊 Statistik Tim</h3>
    <ul>
        <?php 
        $total_denda = 0;
        while ($s = mysqli_fetch_assoc($stats)) {
            $denda = ($s['kartu_kuning'] * 10000) + ($s['kartu_merah'] * 20000);
            $total_denda += $denda;
        ?>
            <li>
                🛡️ <strong><?= $s['team'] ?>:</strong><br>
                👕 Kiper: <?= $s['nama_kiper'] ?> <br>
                ⏱️ Menit Main: <?= $s['menit_main'] ?> menit<br>
                🧤 Clean Sheet: <?= $s['clean_sheet'] ? '✅' : '❌' ?><br>
                🎯 Kebobolan: <?= $s['kebobolan'] ?><br>
                🟨 Kartu Kuning: <?= $s['kartu_kuning'] ?><br>
                🟥 Kartu Merah: <?= $s['kartu_merah'] ?><br>
                💰 Denda Kartu: Rp<?= number_format($denda, 0, ',', '.') ?>
            </li>
        <?php } ?>
        <li><strong>💸 Total Denda Pertandingan:</strong> Rp<?= number_format($total_denda, 0, ',', '.') ?></li>
    </ul>
</div>

<div class="centered">
    <a href="index.php" class="button">🏠 Kembali ke Home</a>
</div>

</body>
</html>
