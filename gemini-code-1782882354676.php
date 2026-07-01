<?php
require 'koneksi.php';
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute(['username' => $username, 'password' => $password_hashed]);
            $pesan = "<p style='color: green;'>Pendaftaran berhasil! Silakan <a href='login.php'>Login</a></p>";
        } catch (PDOException $e) {
            $pesan = "<p style='color: red;'>Username sudah digunakan!</p>";
        }
    } else {
        $pesan = "<p style='color: red;'>Semua kolom harus diisi!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Daftar Akun</h2>
    <?php echo $pesan; ?>
    <form action="daftar.php" method="POST">
        <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <button type="submit">Daftar Sekarang</button>
    </form>
    <p style="text-align:center; font-size:14px;">Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body>
</html>