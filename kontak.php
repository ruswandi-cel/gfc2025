<?php include '../admin/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Kontak Panitia GFC 2025</title>
    <style>
    body {
        background: #111 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 300px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: white;
        margin: 0;
        padding: 30px;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #fff;
        text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
    }

    .kontak-container {
        max-width: 700px;
        margin: auto;
        background: rgba(255,255,255,0.06);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }

    .kontak-item {
        margin-bottom: 20px;
        padding: 15px;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .kontak-item:hover {
        transform: scale(1.02);
        background: rgba(255,255,255,0.08);
    }

    .kontak-item strong {
        display: block;
        font-size: 20px;
        color: #00d1ff;
        margin-bottom: 4px;
    }

    .kontak-item small {
        color: #ccc;
        font-size: 14px;
        display: block;
        line-height: 1.5;
    }

    .back-home {
        text-align: center;
        margin-top: 30px;
    }

    .back-home a {
        color: #fff;
        background: #28a745;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(0,0,0,0.4);
        transition: background 0.3s ease;
    }

    .back-home a:hover {
        background: #218838;
    }
</style>
</head>
<body>

<h2>📞 Kontak Panitia GFC 2025</h2>

<div class="kontak-container">
    <?php
    $kontak = mysqli_query($conn, "SELECT * FROM kontak ORDER BY id ASC");
    while ($k = mysqli_fetch_assoc($kontak)) {
        echo "<div class='kontak-item'>
                <strong>{$k['nama']}</strong>
                <small>{$k['jabatan']}</small><br>
                <small>📱 {$k['no_hp']}</small>
              </div>";
    }
    ?>
</div>

<div class="back-home">
    <a href="index.php">🏠 Kembali ke Home</a>
</div>

</body>
</html>
