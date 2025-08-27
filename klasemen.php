<?php
include '../admin/db.php';

// Ambil semua tim
$teams = [];
$getTeams = mysqli_query($conn, "SELECT team_home AS tim FROM pertandingan UNION SELECT team_away FROM pertandingan");
while ($row = mysqli_fetch_assoc($getTeams)) {
    $teams[] = $row['tim'];
}
$teams = array_unique($teams);

// Inisialisasi klasemen
$klasemen = [];
foreach ($teams as $tim) {
    $klasemen[$tim] = [
        'main' => 0,
        'menang' => 0,
        'seri' => 0,
        'kalah' => 0,
        'gm' => 0,
        'gk' => 0,
        'selisih' => 0,
        'poin' => 0
    ];
}

// Ambil semua pertandingan yang selesai
$matches = mysqli_query($conn, "SELECT * FROM pertandingan WHERE status = 'selesai'");
while ($m = mysqli_fetch_assoc($matches)) {
    $home = $m['team_home'];
    $away = $m['team_away'];
    $sh = $m['score_home'];
    $sa = $m['score_away'];

    $klasemen[$home]['main']++;
    $klasemen[$away]['main']++;

    $klasemen[$home]['gm'] += $sh;
    $klasemen[$home]['gk'] += $sa;
    $klasemen[$away]['gm'] += $sa;
    $klasemen[$away]['gk'] += $sh;

    if ($sh > $sa) {
        $klasemen[$home]['menang']++;
        $klasemen[$away]['kalah']++;
        $klasemen[$home]['poin'] += 3;
    } elseif ($sh < $sa) {
        $klasemen[$away]['menang']++;
        $klasemen[$home]['kalah']++;
        $klasemen[$away]['poin'] += 3;
    } else {
        $klasemen[$home]['seri']++;
        $klasemen[$away]['seri']++;
        $klasemen[$home]['poin'] += 1;
        $klasemen[$away]['poin'] += 1;
    }
}

// Hitung selisih gol
foreach ($klasemen as $tim => $data) {
    $klasemen[$tim]['selisih'] = $data['gm'] - $data['gk'];
}

// Urutkan klasemen
uasort($klasemen, function($a, $b) {
    if ($a['poin'] != $b['poin']) return $b['poin'] - $a['poin'];
    if ($a['selisih'] != $b['selisih']) return $b['selisih'] - $a['selisih'];
    return $b['gm'] - $a['gm'];
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Klasemen GFC 2025</title>
    <style>
       body {
    background: 
        url('../assets/img/logo-gfc.png') no-repeat center center fixed,
        linear-gradient(135deg, #111, #1a1a1a);
    background-size: 300px;
    font-family: 'Segoe UI', sans-serif;
    color: #fff;
    padding: 30px;
    margin: 0;
    overflow-x: hidden;
}

        h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            color: #00ffcc;
            text-shadow: 0 0 10px #00ffcc, 0 0 20px #00e6ac;
            position: relative;
        }

        h2::after {
            content: "";
            width: 60px;
            height: 4px;
            background: #00ffcc;
            display: block;
            margin: 10px auto 0 auto;
            border-radius: 2px;
            box-shadow: 0 0 10px #00ffcc;
        }

        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,255,204,0.5);
            animation: tableGlow 2s infinite alternate;
        }

        @keyframes tableGlow {
            0% { box-shadow: 0 0 10px rgba(0,255,204,0.4); }
            50% { box-shadow: 0 0 30px rgba(0,255,204,0.7); }
            100% { box-shadow: 0 0 10px rgba(0,255,204,0.4); }
        }

        th, td {
            padding: 14px;
            border: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: rgba(0,255,204,0.1);
            color: #00ffff;
            text-shadow: 0 0 5px #00ffff;
        }

        tr:nth-child(even) {
            background-color: rgba(255,255,255,0.05);
        }

        tr:hover {
            background-color: rgba(0,255,204,0.2);
            transform: scale(1.01);
            transition: 0.3s;
        }

        tr.gold {
            background: linear-gradient(to right, #FFD70044, #FFD70011);
            font-weight: bold;
            box-shadow: 0 0 10px #FFD700;
        }

        tr.silver {
            background: linear-gradient(to right, #C0C0C044, #C0C0C011);
            font-weight: bold;
            box-shadow: 0 0 10px #C0C0C0;
        }

        tr.bronze {
            background: linear-gradient(to right, #cd7f3244, #cd7f3211);
            font-weight: bold;
            box-shadow: 0 0 10px #cd7f32;
        }

        .btn-home {
            text-align: center;
            margin-top: 40px;
        }

        .btn-home a {
            color: #fff;
            background: linear-gradient(90deg,#00e6ac,#00aaff);
            padding: 12px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 0 15px #00e6ac, 0 0 25px #00aaff;
            transition: 0.3s;
        }

        .btn-home a:hover {
            background: #fff;
            color: #111;
            transform: scale(1.1);
            box-shadow: 0 0 25px #00e6ac, 0 0 40px #00aaff;
        }

        @media (max-width:600px) {
            h2 { font-size: 28px; }
            th, td { font-size: 13px; padding:10px; }
            .btn-home a { padding:10px 20px; font-size:14px; }
        }
    </style>
</head>
<body>

<h2>🏆 Klasemen GFC 2025</h2>

<?php if (!empty($klasemen)): ?>
<table>
    <tr>
        <th>🥇</th>
        <th>Tim</th>
        <th>🕹️ Main</th>
        <th>✅ Menang</th>
        <th>➖ Seri</th>
        <th>❌ Kalah</th>
        <th>⚽ GM</th>
        <th>🧱 GK</th>
        <th>➕ Selisih</th>
        <th>🎯 Poin</th>
    </tr>

    <?php
    $no = 1;
    foreach ($klasemen as $tim => $d) {
        $row_class = '';
        if ($no == 1) $row_class = 'gold';
        elseif ($no == 2) $row_class = 'silver';
        elseif ($no == 3) $row_class = 'bronze';

        echo "<tr class='$row_class'>
            <td>$no</td>
            <td>$tim</td>
            <td>{$d['main']}</td>
            <td>{$d['menang']}</td>
            <td>{$d['seri']}</td>
            <td>{$d['kalah']}</td>
            <td>{$d['gm']}</td>
            <td>{$d['gk']}</td>
            <td>{$d['selisih']}</td>
            <td><strong>{$d['poin']}</strong></td>
        </tr>";
        $no++;
    }
    ?>
</table>
<?php else: ?>
    <p style="text-align: center; margin-top: 40px;">Belum ada pertandingan selesai.</p>
<?php endif; ?>

<div class="btn-home">
    <a href="index.php">🏠 Kembali ke Home</a>
</div>

</body>
</html>

