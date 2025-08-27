<?php include 'db.php'; ?>
<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Pertandingan</title>
    <style>
    body {
        background: #111 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 400px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: white;
        margin: 0;
        padding: 20px;
    }

    .form-box {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(5px);
        padding: 25px;
        border-radius: 15px;
        width: 100%;
        max-width: 420px;
        margin: 30px auto;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    }

    .table-box {
        width: 95%;
        margin: 40px auto;
        overflow-x: auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #00ffcc;
        text-shadow: 1px 1px 3px #000;
    }

    input[type="text"],
    input[type="datetime-local"],
    select {
        width: 100%;
        padding: 12px;
        margin-bottom: 14px;
        border-radius: 8px;
        border: 1px solid #444;
        background: #222;
        color: white;
        font-size: 14px;
    }

    input:focus,
    select:focus {
        outline: none;
        border-color: #00ffcc;
        box-shadow: 0 0 6px #00ffcc66;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(45deg, #00ffcc, #0099ff);
        border: none;
        color: black;
        font-weight: bold;
        font-size: 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 15px rgba(0, 255, 204, 0.4);
    }

    table {
        width: 100%;
        color: white;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 12px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        border: 1px solid #555;
        text-align: center;
        font-size: 14px;
    }

    th {
        background: rgba(0, 255, 204, 0.15);
        color: #00ffcc;
        font-weight: bold;
    }

    a {
        color: #00ccff;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
        color: #00ffcc;
    }

    .success-message {
        color: #90ee90;
        text-align: center;
        margin-top: 10px;
    }

    .error-message {
        color: #ff6666;
        text-align: center;
        margin-top: 10px;
    }

    div[style*="text-align:center"] a {
        background: #007bff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        transition: background 0.3s, transform 0.2s;
    }

    div[style*="text-align:center"] a:hover {
        background: #0056b3;
        transform: scale(1.05);
    }
</style>
</head>
<body>
    <div class="form-box">
        <h2>Input Jadwal Pertandingan</h2>
        <form method="post">
            <label>Waktu Match (Misal: 17:00 - 17:30)</label>
            <input type="text" name="match_time" required>

            <label>Team Home</label>
            <input type="text" name="team_home" required>

            <label>Team Away</label>
            <input type="text" name="team_away" required>

            <label>Waktu Kick-Off</label>
            <input type="datetime-local" name="start_time" required>

            <label>Status Pertandingan</label>
            <select name="status">
                <option value="belum">Belum</option>
                <option value="berlangsung">Berlangsung</option>
                <option value="selesai">Selesai</option>
            </select>

            <button type="submit" name="submit">Simpan Pertandingan</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $match_time = $_POST['match_time'];
            $team_home = $_POST['team_home'];
            $team_away = $_POST['team_away'];
            $start_time = $_POST['start_time'];
            $status = $_POST['status'];

            $query = "INSERT INTO pertandingan (match_time, team_home, team_away, start_time, status)
                      VALUES ('$match_time', '$team_home', '$team_away', '$start_time', '$status')";

            if (mysqli_query($conn, $query)) {
                echo "<p style='color:lightgreen;'>✅ Pertandingan berhasil ditambahkan!</p>";
            } else {
                echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
            }
        }
        ?>
    </div>

    <div class="table-box">
        <h2>📋 Daftar Pertandingan</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Jam</th>
                <th>Home</th>
                <th>Away</th>
                <th>Kick-Off</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM pertandingan ORDER BY start_time ASC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>$no</td>
                    <td>{$row['match_time']}</td>
                    <td>{$row['team_home']}</td>
                    <td>{$row['team_away']}</td>
                    <td>{$row['start_time']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <a href='edit-pertandingan.php?id={$row['id']}'>✏️ Edit</a> |
                        <a href='hapus-pertandingan.php?type=pertandingan&id={$row['id']}' onclick=\"return confirm('Yakin mau hapus data ini?')\">🗑️ Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </table>
    </div>
<div style="text-align:center; margin-top: 20px;">
    <a href="dashboard.php" style="color: #fff; background:#007bff; padding:10px 20px; border-radius:8px; text-decoration:none;">🏠 Kembali ke Home</a>
</div>
</body>
</html>
