<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin GFC 2025</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #111 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 400px;
        color: white;
        min-height: 100vh;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.85);
        min-height: 100vh;
        padding: 50px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dashboard-container {
        width: 100%;
        max-width: 600px;
        background: rgba(255, 255, 255, 0.06);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(6px);
    }

    h1 {
        text-align: center;
        margin-bottom: 35px;
        font-size: 28px;
        color: #00ffcc;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    ul li {
        margin: 15px 0;
    }

    a {
        display: block;
        background: linear-gradient(to right, #00ffcc, #0099ff);
        color: #111;
        text-decoration: none;
        padding: 14px 20px;
        border-radius: 10px;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 255, 204, 0.2);
    }

    a:hover {
        background: #fff;
        color: #000;
        transform: scale(1.03);
        box-shadow: 0 6px 20px rgba(0, 255, 204, 0.4);
    }

    .logout {
        margin-top: 30px;
        text-align: center;
    }

    .logout a {
        color: #ff6666;
        font-weight: bold;
        background: none;
        border: 2px solid #ff6666;
        padding: 10px 18px;
        border-radius: 10px;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .logout a:hover {
        background: #ff6666;
        color: #111;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(255, 102, 102, 0.4);
    }
</style>
</head>
<body>
    <div class="overlay">
        <div class="dashboard-container">
            <h1>🎮 Dashboard Admin</h1>
            <ul>
                <li><a href="input-match.php">⚽ Input Pertandingan</a></li>
                <li><a href="input-skor.php">🔢 Input Skor</a></li>
                <li><a href="input-goal.php">🥅 Input Gol</a></li>
                <li><a href="input-statistik.php">📊 Input Statistik</a></li>
                <li><a href="input-suporter.php">🎺 Input Suporter</a></li>
                <li><a href="input-gallery.php">🖼️ Input Galeri</a></li>
                <li><a href="input-kontak.php">📞 Input Kontak</a></li>
            </ul>
            <div class="logout">
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
