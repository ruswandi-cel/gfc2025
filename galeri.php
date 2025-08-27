<?php include '../admin/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Galeri GFC 2025</title>
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
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-bottom: 40px;
        }

        .gallery-item {
            width: 250px;
            background: rgba(255, 255, 255, 0.07);
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.6);
        }

        .gallery-item img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 2px solid #fff;
        }

        .gallery-item p {
            margin: 0;
            font-size: 14px;
            color: #ddd;
            font-style: italic;
        }

        a {
            color: #fff;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            transition: background 0.3s;
        }

        a:hover {
            background: #0056b3;
        }

        .back-home {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<h2>📸 Galeri GFC 2025</h2>

<div class="gallery-container">
    <?php
    $galeri = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
    while ($g = mysqli_fetch_assoc($galeri)) {
        echo "<div class='gallery-item'>
                <img src='../public/uploads/galeri/{$g['nama_file']}' alt='galeri'>
                <p>{$g['caption']}</p>
              </div>";
    }
    ?>
</div>

<div class="back-home">
    <a href='index.php'>🏠 Kembali ke Home</a>
</div>

</body>
</html>
