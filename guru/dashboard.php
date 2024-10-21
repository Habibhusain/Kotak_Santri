<?php
session_start();
require "../functions.php";

if(!isset($_SESSION['id_guru']))
{
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='index.php';
    </script>";
    exit();
}

$id_guru = $_SESSION['id_guru'];
$data_pengaduan = tampil_data_pengaduan_guru();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
        <div class="container-judul">
    <h1>Dashboard</h1>
    <a href="tambah_santri.php">Tambah Santri</a>
    </div>
    <div class="table">
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>Isi pengaduan</td>
                <td>Nama Santri</td>
                <td>Tanggal</td>
                <td>Foto</td>
                <td>Tanggapan</td>
            </tr>
        </thead>
        <tbody>
        <?php
                $no = 1; // Untuk nomor urut
                foreach ($data_pengaduan as $pengaduan):
        ?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $pengaduan['isi_pengaduan'];?></td>
                <td><?php echo $pengaduan['nama_santri'];?></td>
                <td><?php echo date('d-m-Y',strtotime($pengaduan['tgl_pengaduan']));?></td>
                <td><img src="../image/<?php echo $pengaduan['foto'];?>" alt=""></td>
                <td><a href="tanggapan.php?id_pengaduan=<?php echo $pengaduan['id_pengaduan']; ?>">Tanggapan</a></td>
            </tr>
            <?php $no++; endforeach?>
        </tbody>
    </table>    
    </div>
    <a href="logout.php" onclick="return confirm('Yakin Mau logout???')">Logout</a>
</div>
</body>
</html>