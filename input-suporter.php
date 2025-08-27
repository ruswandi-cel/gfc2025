<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';

// Proses hapus jika ada parameter ?hapus=id
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM suporter WHERE id = $id");
    header('Location: input-suporter.php'); // redirect agar tidak menghapus terus saat di-refresh
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Suporter Terbaik</title>
    <style>
    body {
        background: #0d0d0d url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 380px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f5f5f5;
        margin: 0;
        padding: 20px;
    }

    .form-box {
        background: rgba(20, 20, 20, 0.92);
        padding: 30px;
        border-radius: 14px;
        width: 480px;
        max-width: 95%;
        margin: 40px auto;
        box-shadow: 0 0 25px rgba(0, 191, 255, 0.15);
    }

    h2, h3 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #00bfff;
        text-shadow: 1px 1px 3px #000;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #ccc;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 16px;
        border-radius: 8px;
        border: 1px solid #444;
        font-size: 14px;
        background-color: #1a1a1a;
        color: #f5f5f5;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.4);
        resize: vertical;
    }

    input:focus,
    textarea:focus {
        border-color: #00bfff;
        outline: none;
        background-color: #222;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #ffc107;
        color: #111;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        transition: 0.3s;
    }

    button:hover {
        background-color: #e0a800;
        box-shadow: 0 0 15px rgba(255, 193, 7, 0.7);
    }

    .success, .error {
        margin-top: 15px;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .data-box {
        max-width: 760px;
        margin: 40px auto;
        background: rgba(255,255,255,0.05);
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 0 15px rgba(0,191,255,0.15);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: #f0f0f0;
        font-size: 14px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #333;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #1b1b1b;
    }

    .hapus-btn {
        color: #ff4d4d;
        text-decoration: none;
        font-weight: bold;
        transition: 0.2s;
    }

    .hapus-btn:hover {
        color: #ff1a1a;
        text-decoration: underline;
    }

    a[href="dashboard.php"] {
        display: inline-block;
        color: #fff;
        background: #007bff;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
        margin-top: 30px;
        transition: 0.3s;
    }

    a[href="dashboard.php"]:hover {
        background-color: #0056b3;
        box-shadow: 0 0 18px rgba(0, 123, 255, 0.6);
    }
</style>
</head>
<body>

<div class="form-box">
    <h2>Input Suporter Terbaik</h2>
    <form method="post">
        <label>Nama Tim:</label>
        <input type="text" name="nama_team" required>

        <label>Jumlah Suporter:</label>
        <input type="number" name="jumlah_suporter" required>

        <label>Catatan Penilaian:</label>
        <textarea name="catatan" rows="4"></textarea>

        <button type="submit" name="submit">Simpan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $team = $_POST['nama_team'];
        $jumlah = $_POST['jumlah_suporter'];
        $catatan = $_POST['catatan'];

        $insert = mysqli_query($conn, "INSERT INTO suporter (nama_team, jumlah_suporter, catatan) 
                                       VALUES ('$team', $jumlah, '$catatan')");

        if ($insert) {
            echo "<div class='success'>✅ Data suporter berhasil disimpan!</div>";
        } else {
            echo "<div class='error'>❌ Gagal menyimpan: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
</div>

<div class="data-box">
    <h3>📋 Daftar Suporter Terbaik</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tim</th>
                <th>Jumlah</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $data = mysqli_query($conn, "SELECT * FROM suporter ORDER BY jumlah_suporter DESC");
        $no = 1;
        while ($row = mysqli_fetch_assoc($data)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_team']}</td>
                    <td>{$row['jumlah_suporter']}</td>
                    <td>{$row['catatan']}</td>
                    <td><a class='hapus-btn' href='?hapus={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a></td>
                </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>

<div style="text-align:center; margin-top: 20px;">
    <a href="dashboard.php" style="color: #fff; background:#007bff; padding:10px 20px; border-radius:8px; text-decoration:none;">🏠 Kembali ke Home</a>
</div>

</body>
</html>
