<?php
session_start();

require "functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
$login_santri = login_santri();

if($login_santri)
{
    $_SESSION['id_santri'] = $login_santri;
    echo "<script>
    alert('Berhasil Login');
    window.location='santri/index.php';
    </script>";
}else{
    echo "<script>
    alert('Gagal Login');
    window.location='index.php';
    </script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Santri</title>
    <link rel = "stylesheet" href="css/style.css">
</head>
<body>
<div class="container-login-santri">
    <div class="container-judul-login-santri">
    <h1>Form Login</h1>
    </div>
    <div class="container-form-login-santri">
        <form action="" method="POST">
            <label for="">Nama</label>
            <input type="text" name="nama_santri" required autofocus>
            <label for="">Nomor</label>
            <input type="text" name="nomor_santri" required>
            <div class="submit-login">
            <input type="submit" name="submit" value="submit">
            </div>
        </form>
    </div>    
    </div>
    <footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>