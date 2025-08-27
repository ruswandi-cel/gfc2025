<?php
include '../admin/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistik Pertandingan</title>
    <style>
        body {
            background: #0c0c0c url('../assets/img/logo-gfc.png') no-repeat center center fixed;
            background-size: 300px;
            font-family: 'Segoe UI', sans-serif;
            color: #f1f1f1;
            padding: 30px 10px;
            margin: 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #00ffe0;
            text-shadow: 0 0 10px #00ffe0;
        }

        .match-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.03), rgba(0,255,200,0.05));
            padding: 25px;
            margin: 30px auto;
            border-radius: 15px;
            border: 1px solid #444;
            width: 95%;
            box-shadow: 0 0 12px rgba(0,255,200,0.1);
            transition: transform 0.3s ease;
        }

        .match-card:hover {
            transform: scale(1.01);
            box-shadow: 0 0 18px rgba(0,255,200,0.2);
        }

        .match-header {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #00ffe0;
            text-shadow: 0 0 8px #00ffe0;
        }

        .match-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .match-info div {
            background: rgba(255,255,255,0.02);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #555;
            box-shadow: 0 0 6px rgba(255,255,255,0.02);
            transition: background 0.3s ease;
        }

        .match-info div:hover {
            background: rgba(0,255,200,0.04);
        }

        .label {
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 5px;
        }

        .highlight {
            font-weight: bold;
            color: #00ff88;
            text-shadow: 0 0 6px #00ff88;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 0 10px rgba(0,114,255,0.3);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<h2>📊 Statistik Lengkap Pertandingan GFC 2025</h2>

<?php
$matchQuery = mysqli_query($conn, "SELECT * FROM pertandingan ORDER BY id ASC");

if (!$matchQuery || mysqli_num_rows($matchQuery) == 0) {
    echo "<p style='text-align:center;'>Belum ada data pertandingan tersedia.</p>";
} else {
    $no = 1;
    while ($match = mysqli_fetch_assoc($matchQuery)) {
        $matchId = $match['id'];
        $teamHome = $match['team_home'];
        $teamAway = $match['team_away'];
        $scoreHome = $match['score_home'];
        $scoreAway = $match['score_away'];

        // Ambil pencetak gol
        $goalQuery = mysqli_query($conn, "SELECT * FROM goal_detail WHERE pertandingan_id = $matchId");
        $pencetak_gol = "";
        while ($goal = mysqli_fetch_assoc($goalQuery)) {
            $pencetak_gol .= "{$goal['nama_pemain']} ({$goal['tim']} - {$goal['menit']}')<br>";
        }
        if ($pencetak_gol == "") $pencetak_gol = "Belum ada data";

        // Ambil statistik (dua tim per match)
        $statQuery = mysqli_query($conn, "SELECT * FROM statistik WHERE match_id = $matchId");

        $statistik_output = "";
        $total_denda = 0;
        while ($stat = mysqli_fetch_assoc($statQuery)) {
            $denda = ($stat['kartu_kuning'] * 10000) + ($stat['kartu_merah'] * 20000);
            $total_denda += $denda;

            $statistik_output .= "
                <div>
                    <div class='label'>🏴 Nama Tim:</div> {$stat['team']}
                    <div class='label'>🥅 Kebobolan:</div> {$stat['kebobolan']}
                    <div class='label'>🧤 Clean Sheet:</div> " . ($stat['clean_sheet'] ? '✅' : '❌') . "
                    <div class='label'>🟨 Kartu Kuning:</div> {$stat['kartu_kuning']}
                    <div class='label'>🟥 Kartu Merah:</div> {$stat['kartu_merah']}
                    <div class='label'>💰 Denda Kartu:</div> Rp" . number_format($denda, 0, ',', '.') . "
                    <div class='label'>🧍‍♂️ Nama Kiper:</div> {$stat['nama_kiper']}
                    <div class='label'>⏱️ Menit Main:</div> {$stat['menit_main']} menit
                </div>
            ";
        }

        echo "
        <div class='match-card'>
            <div class='match-header'>#{$no} - {$teamHome} <span class='highlight'>{$scoreHome} - {$scoreAway}</span> {$teamAway}</div>
            <div class='match-info'>
                <div>
                    <div class='label'>⚽ Pencetak Gol:</div> {$pencetak_gol}
                </div>
                {$statistik_output}
                <div>
                    <div class='label'>💸 Total Denda Kartu:</div> Rp" . number_format($total_denda, 0, ',', '.') . "
                </div>
            </div>
        </div>
        ";

        $no++;
    }
}
?>
<div style="text-align:center; margin-top: 20px;">
    <a href="index.php">🏠 Kembali ke Home</a>
</div>

</body>
</html>
