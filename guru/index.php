<?php
session_start();

require "../functions.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $login_guru = login_guru();
    if($login_guru)
    {
    $_SESSION['id_guru']= $login_guru;
    echo "<script>
    alert('Berhasil Login');
    window.location ='dashboard.php';
    </script>";
    }else{
    echo "<script>
    alert('Nama Pengguna Atau Password Salah');
    window.location ='index.php';
    </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container-login-guru">
    <div class="container-judul-login-guru">
    <h1>Form Login Guru</h1>
    </div>
    <div class="container-form-login-guru">
        <form action="" method="POST">
            <label for="">Nama</label>
            <input type="text" name="nama_guru" required autofocus>
            <label for="">Nomor</label>
            <input type="text" name="nomor_guru" required>
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