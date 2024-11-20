<?php session_start();
require "../functions.php";

if (!isset($_SESSION['id_santri'])) {
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
<nav class="navigasi">
    <a href="../logout.php" onclick="return confirm('Yakin Mau logout???')">Logout</a>
    </nav>
<div class="content">
        <div class="content-judul">
    <h1>Dashboard Pengaduan</h1>
    <a href="tambah_pengaduan.php">Tambah pengaduan</a>
    </div>
    <div class="content-table">
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>id_santri</td>
                <td>Isi pengaduan</td>
                <td>Foto</td>
                <td>Cek Tanggapan</td>
                <td colspan="2">Aksi</td>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach ($pengaduan_santri as $pengaduan):?>
            <tr>
                <td><?php echo $no;?></td>
                <td>MY <?php echo $pengaduan['id_santri']?></td>
                <td><?php echo $pengaduan['isi_pengaduan']?></td>
                <td><img src="../image/<?php echo $pengaduan['foto']?>" alt="" width="100px"></td>
                <td><a href="tanggapan.php?id_pengaduan=<?php echo $pengaduan['id_pengaduan']; ?>">Lihat Tanggapan</a></td>
                <td><a href="edit_pengaduan.php?id_pengaduan=<?php echo $pengaduan['id_pengaduan']; ?>">Edit</a></td>
            </tr>
        <?php $no++; endforeach;?>
        </tbody>
    </table>    
</div>
</div>
<footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>