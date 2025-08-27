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
    <title>Input Top Skor</title>
</head>
<body>
    <h2>Input / Update Top Skor</h2>
    <form method="post">
        <label>Nama Pemain:</label><br>
        <input type="text" name="nama_pemain" required><br><br>

        <label>Asal Tim:</label><br>
        <input type="text" name="tim" required><br><br>

        <label>Jumlah Gol:</label><br>
        <input type="number" name="jumlah_gol" required><br><br>

        <button type="submit" name="submit">Simpan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama_pemain'];
        $tim = $_POST['tim'];
        $gol = $_POST['jumlah_gol'];

        // cek apakah sudah ada data pemain ini
        $cek = mysqli_query($conn, "SELECT * FROM topskor WHERE nama_pemain = '$nama' AND tim = '$tim'");
        if (mysqli_num_rows($cek) > 0) {
            // update
            $sql = "UPDATE topskor SET jumlah_gol = $gol WHERE nama_pemain = '$nama' AND tim = '$tim'";
        } else {
            // insert
            $sql = "INSERT INTO topskor (nama_pemain, tim, jumlah_gol)
                    VALUES ('$nama', '$tim', $gol)";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<p>Data top skor berhasil disimpan!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    ?>
</body>
<div style="text-align:center; margin-top: 20px;">
    <a href="dashboard.php" style="color: #fff; background:#007bff; padding:10px 20px; border-radius:8px; text-decoration:none;">🏠 Kembali ke Home</a>
</div>
</html>
