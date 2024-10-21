<?php
session_start();
require "../functions.php";

if(!isset($_SESSION['id_santri']))
{
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='../index.php';
    </script>";
    exit();
}
    
    $pengaduan_santri = tampil_data_pengaduan_santri();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Santri</title>
    <link rel ="stylesheet" href="../css/style.css">
</head>
<body>
<div class="content">
        <div class="content-judul">
    <h1>Dashboard</h1>
    <a href="tambah_pengaduan.php">Tambah pengaduan</a>
    <h2>Pengaduan</h2>
    </div>
    <div class="content-table">
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>id_santri</td>
                <td>Isi pengaduan</td>
                <td>Foto</td>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach ($pengaduan_santri as $pengaduan):?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $pengaduan['id_santri']?></td>
                <td><?php echo $pengaduan['isi_pengaduan']?></td>
                <td><img src="../image/<?php echo $pengaduan['foto']?>" alt=""></td>
            </tr>
        <?php $no++; endforeach;?>
        </tbody>
    </table>    

</div>
</body>
</html>