<?php
include 'db.php';

$msg = '';

// Hapus kontak
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM kontak WHERE id = $id");
    $msg = "🗑️ Kontak berhasil dihapus.";
}

// Tambah kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];

    $query = "INSERT INTO kontak (nama, jabatan, no_hp) VALUES ('$nama', '$jabatan', '$no_hp')";
    if (mysqli_query($conn, $query)) {
        $msg = "✅ Kontak berhasil ditambahkan!";
    } else {
        $msg = "❌ Gagal menambahkan kontak: " . mysqli_error($conn);
    }
}

// Edit data
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM kontak WHERE id = $id");
    $edit_data = mysqli_fetch_assoc($result);
}

// Update kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];

    $update = "UPDATE kontak SET nama='$nama', jabatan='$jabatan', no_hp='$no_hp' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        $msg = "✏️ Kontak berhasil diupdate!";
    } else {
        $msg = "❌ Gagal mengupdate kontak: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kontak GFC 2025</title>
    <style>
    body {
        background: #111 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 300px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f1f1f1;
        margin: 0;
        padding: 30px;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        color: #ffcc00;
    }

    form {
        max-width: 450px;
        margin: 0 auto 30px;
        background: rgba(255, 255, 255, 0.07);
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.08);
    }

    label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="tel"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: none;
        border-radius: 6px;
        background: #1d1d1d;
        color: #fff;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        font-size: 15px;
        transition: background 0.3s;
    }

    button:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
    }

    .message {
        text-align: center;
        margin-top: 20px;
        color: #ffea00;
        font-weight: bold;
    }

    .back-link {
        text-align: center;
        margin-top: 30px;
    }

    .back-link a {
        color: #fff;
        text-decoration: none;
        background: #007bff;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        display: inline-block;
        transition: background 0.3s;
    }

    .back-link a:hover {
        background: #0056b3;
    }

    table {
        width: 100%;
        margin-top: 30px;
        border-collapse: collapse;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #333;
        text-align: center;
    }

    th {
        background: #222;
        color: #f9f9f9;
    }

    tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    a.btn {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        color: white;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
    }

    .edit-btn {
        background: #ffc107;
    }

    .edit-btn:hover {
        background: #e0a800;
    }

    .delete-btn {
        background: #dc3545;
    }

    .delete-btn:hover {
        background: #bd2130;
    }
</style>
</head>
<body>

<h2>📇 Kelola Kontak Panitia GFC 2025</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">

    <label>Nama</label>
    <input type="text" name="nama" value="<?= $edit_data['nama'] ?? '' ?>" required>

    <label>Jabatan</label>
    <input type="text" name="jabatan" value="<?= $edit_data['jabatan'] ?? '' ?>" required>

    <label>No. HP</label>
    <input type="tel" name="no_hp" value="<?= $edit_data['no_hp'] ?? '' ?>" required>

    <?php if ($edit_data): ?>
        <button type="submit" name="update">Update Kontak</button>
    <?php else: ?>
        <button type="submit" name="simpan">Simpan Kontak</button>
    <?php endif; ?>
</form>

<?php if ($msg): ?>
<div class="message"><?= $msg ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>No. HP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $kontak = mysqli_query($conn, "SELECT * FROM kontak ORDER BY id DESC");
        while ($k = mysqli_fetch_assoc($kontak)) {
            echo "<tr>
                <td>{$k['nama']}</td>
                <td>{$k['jabatan']}</td>
                <td>{$k['no_hp']}</td>
                <td>
                    <a href='?edit={$k['id']}' class='btn edit-btn'>Edit</a>
                    <a href='?hapus={$k['id']}' class='btn delete-btn' onclick='return confirm(\"Yakin hapus kontak ini?\")'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<div class="back-link">
    <a href="dashboard.php">🏠 Kembali ke Dashboard</a>
</div>

</body>
</html>
