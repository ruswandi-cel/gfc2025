<?php
include '../admin/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Live Score GFC 2025</title>
    <style>
        body {
            background: #111 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
            background-size: 300px;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            margin: 0;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #00ffcc;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .match-box {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            margin: 20px auto;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 0 12px rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        .match-box:hover {
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.2);
        }

        .match-title {
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin-bottom: 10px;
            color: #ffd700;
        }

        .info {
            font-size: 15px;
            text-align: center;
            margin-bottom: 6px;
        }

        .goal-list {
            margin-top: 12px;
            font-size: 14px;
            padding: 10px;
            background: rgba(255,255,255,0.03);
            border-left: 4px solid #007bff;
            border-radius: 8px;
        }

        .goal-list ul {
            padding-left: 20px;
            margin: 0;
        }

        .goal-list li {
            margin-bottom: 6px;
        }

        a {
            color: #00bfff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
            color: #00ffff;
        }

        .btn-home {
            text-align: center;
            margin-top: 30px;
        }

        .btn-home a {
            color: #fff;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-home a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h2>📺 LIVE SCORE GFC 2025</h2>

<?php
$matches = mysqli_query($conn, "SELECT * FROM pertandingan ORDER BY start_time ASC");
while ($m = mysqli_fetch_assoc($matches)) {
    echo "<div class='match-box'>";
    echo "<div class='match-title'>🆚 {$m['team_home']} vs {$m['team_away']}</div>";
    echo "<div class='info'>🕒 <strong>Status:</strong> {$m['status']} | ⏰ <strong>Waktu:</strong> {$m['match_time']}</div>";
    echo "<div class='info'>🔢 <strong>Skor:</strong> {$m['score_home']} - {$m['score_away']}</div>";

    // Goal detail
    $match_id = $m['id'];
    $goals = mysqli_query($conn, "SELECT * FROM goal_detail WHERE pertandingan_id = $match_id ORDER BY menit ASC");

    if (mysqli_num_rows($goals) > 0) {
        echo "<div class='goal-list'><strong>⚽ Pencetak Gol:</strong><ul>";
        while ($g = mysqli_fetch_assoc($goals)) {
            echo "<li>⚽ {$g['nama_pemain']} ({$g['tim']}) - menit {$g['menit']}’</li>";
        }
        echo "</ul></div>";
    } else {
        echo "<div class='goal-list'><em>❌ Belum ada gol tercipta.</em></div>";
    }

    echo "<br><div style='text-align:center;'><a href='detail-match.php?id={$m['id']}'>🔎 Detail Pertandingan</a></div>";
    echo "</div>";
}
?>

<div class="btn-home">
    <a href='index.php'>🏠 Kembali ke Home</a>
</div>

</body>
</html>
