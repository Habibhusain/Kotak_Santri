<?php
session_start();
require "../functions.php";

if(!isset($_SESSION['id_guru']))
{
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location ='index.php';
    </script>";
}

if($_SERVER['REQUEST_METHOD']=='POST'){
$tambah_santri=tambah_santri();

if($tambah_santri)
{
    echo "<script>
    alert('Santri Berhasil di Tambah');
    window.location ='dashboard.php';
    </script>";
}else{
    echo "<script>
    alert('Santri Berhasil di Tambah');
    window.location ='tambah_santri.php';
    </script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Santri</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="box-judul">
        <h1>Tambah Santri</h1>
    </div>
    <div class="box">
        <div class="box-1">
    <form method="POST">
        <label for="nama_santri">Nama Pengguna:</label>
        <input type="text" name="nama_santri" required autofocus>
        
        <label for="nomor_santri">Nomor Santri:</label>
        <input type="text" name="nomor_santri" required>
        
        <label for="asal">Asal:</label>
        <input type="text" name="asal" required>
        
        <input type="submit" value="Buat Santri Baru">
        <a href="dashboard.php">Kembali</a>
    </form>
    </div>
    </div>
    <footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>