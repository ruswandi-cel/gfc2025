<?php
include 'db.php';
$message = '';

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $uploadDir = '../public/uploads/galeri/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = time() . '-' . str_replace(' ', '-', basename($_FILES['file']['name']));
    $targetPath = $uploadDir . $fileName;

    $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg','jpeg','png','gif','mp4','webm','ogg'];

    if (!in_array($fileType, $allowedTypes)) {
        $message = "❌ Format file tidak didukung!";
    } elseif (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        $query = "INSERT INTO galeri (nama_file, caption) VALUES ('$fileName', '$caption')";
        $message = mysqli_query($conn, $query)
            ? "✅ File berhasil diupload."
            : "❌ Gagal simpan ke DB.";
    } else {
        $message = "❌ Gagal memindahkan file.";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_file FROM galeri WHERE id = $id"));
    if ($row) {
        $filePath = '../public/uploads/galeri/' . $row['nama_file'];
        if (file_exists($filePath)) unlink($filePath);
        mysqli_query($conn, "DELETE FROM galeri WHERE id = $id");
        $message = "✅ File berhasil dihapus.";
    } else {
        $message = "❌ File tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input & Hapus Galeri</title>
    <style>
    body { background:#0d0d0d; color:#f5f5f5; font-family:sans-serif; padding:30px; }
    h2,h3 { text-align:center; color:#ffc107; }
    form, .gallery { background: rgba(255,255,255,0.05); padding:25px; border-radius:14px; margin:20px auto; max-width:700px; }
    input, button { width:100%; padding:12px; margin:10px 0; border-radius:8px; border:none; font-size:15px; box-sizing:border-box; }
    input[type="text"] { background:#fff; color:#000; }
    input[type="file"] { background:#f5f5f5; color:#000; }
    button { background:#28a745; color:#fff; font-weight:bold; cursor:pointer; transition:0.2s; }
    button:hover { background:#218838; }
    button.delete { background:#dc3545; }
    button.delete:hover { background:#c82333; }
    img, video { width:120px; height:auto; border-radius:8px; box-shadow:0 0 8px rgba(255,255,255,0.1); }
    table { width:100%; margin-top:20px; border-collapse:collapse; }
    th, td { padding:12px 10px; border-bottom:1px solid #444; text-align:center; }
    th { color:#ffc107; background-color:#1a1a1a; }
    .message { text-align:center; background:#333; padding:15px; border-radius:8px; color:#ffeb3b; margin-bottom:25px; font-weight:bold; }
    a { text-decoration:none; }
    .dashboard-link { display:inline-block; text-align:center; margin:30px auto 0; color:#fff; background:#007bff; padding:12px 24px; border-radius:8px; font-weight:bold; font-size:16px; }
    .dashboard-link:hover { background:#0069d9; }
    </style>
</head>
<body>

<h2>🖼️ Upload & Hapus Galeri</h2>

<?php if ($message): ?><div class="message"><?= $message ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" accept="image/*,video/*" required>
    <input type="text" name="caption" placeholder="Caption file..." required>
    <button type="submit">Upload File</button>
</form>

<div class="gallery">
    <h3>Daftar File:</h3>
    <table>
        <tr><th>Preview</th><th>Caption</th><th>Upload</th><th>Aksi</th></tr>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
        while ($g = mysqli_fetch_assoc($res)) {
            $ext = strtolower(pathinfo($g['nama_file'], PATHINFO_EXTENSION));
            $preview = in_array($ext,['mp4','webm','ogg'])
                ? "<video controls><source src='../public/uploads/galeri/{$g['nama_file']}' type='video/$ext'></video>"
                : "<img src='../public/uploads/galeri/{$g['nama_file']}' alt=''>";
            echo "<tr>
                    <td>$preview</td>
                    <td>{$g['caption']}</td>
                    <td>{$g['upload_at']}</td>
                    <td>
                        <a href='?delete={$g['id']}' onclick=\"return confirm('Yakin hapus?');\">
                        <button class='delete'>🗑️ Hapus</button></a>
                    </td>
                </tr>";
        }
        ?>
    </table>
</div>

<div style="text-align:center;">
    <a href="dashboard.php" class="dashboard-link">🏠 Kembali ke Dashboard</a>
</div>

</body>
</html>
