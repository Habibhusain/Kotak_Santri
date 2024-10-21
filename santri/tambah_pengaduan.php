<?php
session_start();
require "../functions.php";

if(!isset($_SESSION['id_santri']))
{
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location ='index.php';
    </script>";
}

if($_SERVER['REQUEST_METHOD']=='POST'){
$tambah_data_pengaduan=tambah_data_pengaduan();

if($tambah_data_pengaduan)
{
    echo "<script>
    alert('Pengaduan Berhasil di Tambah');
    window.location ='index.php';
    </script>";
}else{
    // echo "<script>
    // alert('Pengaduan Gagal di Tambah');
    // window.location ='tambah_pengaduan.php';
    // </script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="box-judul">
        <h1>Tambah Pengaduan</h1>
    </div>
    <div class="box">
        <div class="box-1">
    <form method="POST" enctype="multipart/form-data">
        <label for="isi_pengaduan">Isi Pengaduan:</label>
        <textarea name="isi_pengaduan" id="isi_pengaduan"></textarea>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" required>

        <input type="submit" value="Buat Pengaduan Baru">
        <a href="index.php">Kembali</a>
    </form>
    </div>
    </div>
</body>
</html>