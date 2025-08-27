<?php include '../admin/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Awards GFC 2025</title>
    <style>
        body {
            background: #0e0e0e url('../assets/img/logo-gfc.png') no-repeat center center fixed;
            background-size: 280px;
            font-family: 'Segoe UI', sans-serif;
            color: #f1f1f1;
            margin: 0;
            padding: 30px 15px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 28px;
            color: #00ffe0;
            text-shadow: 0 0 12px #00ffe0;
        }

        h3 {
            margin-top: 50px;
            font-size: 22px;
            color: #ffd700;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            padding-bottom: 6px;
            width: fit-content;
        }

        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.03);
            box-shadow: 0 0 12px rgba(0,255,200,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 14px;
            border: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 15px;
        }

        th {
            background: linear-gradient(90deg, rgba(0, 200, 255, 0.2), rgba(0, 100, 255, 0.2));
            color: #00eaff;
            font-weight: bold;
            text-shadow: 0 0 4px #00eaff;
        }

        tr:nth-child(even) {
            background-color: rgba(255,255,255,0.03);
        }

        tr:hover {
            background-color: rgba(0,255,200,0.06);
            transition: 0.3s ease;
        }

        a {
            display: inline-block;
            color: #fff;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0,114,255,0.4);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            transform: translateY(-2px);
        }

        div[style*="text-align:center"] {
            margin-top: 40px;
        }
    </style>
</head>
<body>

<h2>🏆 Awards GFC 2025</h2>

<!-- Top Skor -->
<h3>⚽ Top Skor</h3>
<table>
    <tr>
        <th>No</th>
        <th>Nama Pemain</th>
        <th>Tim</th>
        <th>Jumlah Gol</th>
    </tr>
    <?php
    $no = 1;
    $query = mysqli_query($conn, "
        SELECT nama_pemain, tim, COUNT(*) as jumlah_gol 
        FROM goal_detail 
        GROUP BY nama_pemain, tim 
        ORDER BY jumlah_gol DESC
    ");
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
            <td>" . $no++ . "</td>
            <td>{$row['nama_pemain']}</td>
            <td>{$row['tim']}</td>
            <td>{$row['jumlah_gol']}</td>
        </tr>";
    }
    ?>
</table>

<!-- Kiper Terbaik -->
<h3>🧤 Kiper Terbaik</h3>
<table>
    <tr>
        <th>No</th>
        <th>Nama Kiper</th>
        <th>Tim</th>
        <th>Match</th>
        <th>Clean Sheet</th>
        <th>Kebobolan</th>
        <th>Menit Main</th>
    </tr>
    <?php
    $no = 1;
    $kiper = mysqli_query($conn, "
        SELECT nama_kiper, team, COUNT(*) AS jumlah_match,
               SUM(clean_sheet) AS clean_sheet, SUM(kebobolan) AS kebobolan, SUM(menit_main) AS menit_main
        FROM statistik
        GROUP BY nama_kiper, team
        ORDER BY clean_sheet DESC, kebobolan ASC
    ");
    while ($row = mysqli_fetch_assoc($kiper)) {
        echo "<tr>
            <td>" . $no++ . "</td>
            <td>{$row['nama_kiper']}</td>
            <td>{$row['team']}</td>
            <td>{$row['jumlah_match']}</td>
            <td>{$row['clean_sheet']}</td>
            <td>{$row['kebobolan']}</td>
            <td>{$row['menit_main']} menit</td>
        </tr>";
    }
    ?>
</table>

<!-- Suporter Terbaik -->
<h3>🎺 Suporter Terbaik</h3>
<table>
    <tr>
        <th>No</th>
        <th>Team</th>
        <th>Jumlah Suporter</th>
        <th>Catatan</th>
    </tr>
    <?php
    $no = 1;
    $suporter = mysqli_query($conn, "SELECT * FROM suporter ORDER BY jumlah_suporter DESC");
    while ($row = mysqli_fetch_assoc($suporter)) {
        echo "<tr>
            <td>" . $no++ . "</td>
            <td>{$row['nama_team']}</td>
            <td>{$row['jumlah_suporter']}</td>
            <td>{$row['catatan']}</td>
        </tr>";
    }
    ?>
</table>

<div style="text-align:center;">
    <a href="index.php">🏠 Kembali ke Home</a>
</div>
</body>
</html>
