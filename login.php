<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'ruswandi' && $password === 'gfcjuara2025') {
        $_SESSION['login'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin GFC 2025</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: #000 url('../assets/img/logo-gfc.png') no-repeat center center fixed;
        background-size: 300px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .login-box {
        backdrop-filter: blur(12px);
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 35px 30px;
        border-radius: 20px;
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        width: 340px;
        text-align: center;
    }

    h2 {
        margin-bottom: 25px;
        font-size: 24px;
        color: #00ffcc;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0 15px;
        border-radius: 10px;
        border: 1px solid #555;
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-size: 15px;
    }

    input::placeholder {
        color: #ccc;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #00ffcc;
        border: none;
        color: #000;
        font-weight: bold;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #00ddaa;
    }

    .error {
        color: #ff4c4c;
        margin-bottom: 15px;
        font-size: 14px;
    }
    </style>
</head>
<body>
<div class="login-box">
    <h2>🔐 Login Admin</h2>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">🔓 Masuk</button>
    </form>
</div>
</body>
</html>
