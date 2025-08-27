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
    <title>Input Data Kiper Terbaik</title>
</head>
<body>
    <h2>Input Data Kiper Terbaik</h2>
    <form method="post">
        <label>Nama Kiper:</label><br>
        <input type="text" name="nama_kiper" required><br><br>

        <label>Asal Tim:</label><br>
        <input type="text" name="team" required><br><br>

        <label>Jumlah Match:</label><br>
        <input type="number" name="jumlah_match" required><br><br>

        <label>Clean Sheet:</label><br>
        <input type="number" name="clean_sheet" required><br><br>

        <label>Jumlah Kebobolan:</label><br>
        <input type="number" name="kebobolan" required><br><br>

        <label>Menit Bermain:</label><br>
        <input type="number" name="menit_main" required><br><br>

        <button type="submit" name="submit">Simpan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama_kiper = $_POST['nama_kiper'];
        $team = $_POST['team'];
        $jumlah_match = $_POST['jumlah_match'];
        $clean_sheet = $_POST['clean_sheet'];
        $kebobolan = $_POST['kebobolan'];
        $menit_main = $_POST['menit_main'];

        $sql = "INSERT INTO kiper (nama_kiper, team, jumlah_match, clean_sheet, kebobolan, menit_main)
                VALUES ('$nama_kiper', '$team', $jumlah_match, $clean_sheet, $kebobolan, $menit_main)";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Data kiper berhasil disimpan!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    ?>
<div style="text-align:center; margin-top: 20px;">
    <a href="dashboard.php" style="color: #fff; background:#007bff; padding:10px 20px; border-radius:8px; text-decoration:none;">🏠 Kembali ke Home</a>
</div>    
</body>
</html>
