<?php
session_start();
require "../functions.php";

// Cek apakah santri sudah login
if (!isset($_SESSION['id_santri'])) {
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='../index.php';
    </script>";
    exit();
}

// Ambil id_pengaduan dari URL
$id_pengaduan = $_GET['id_pengaduan'];

$tanggapan_guru = tampil_tanggapan_by_pengaduan($id_pengaduan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanggapan Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="content">
    <div class="content-judul">
        <h1>Tanggapan Pengaduan</h1>
        <a href="index.php">Kembali ke Dashboard</a>
    </div>
    
    <div class="content-table">
        <!-- Tabel Tanggapan -->
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Tanggal Tanggapan</td>
                    <td>Isi Tanggapan</td>
                    <td>Guru</td>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($tanggapan_guru as $tanggapan): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($tanggapan['tgl_pengaduan'])); ?></td>
                    <td><?php echo htmlspecialchars($tanggapan['isi_tanggapan']); ?></td>
                    <td><?php echo htmlspecialchars($tanggapan['nama_guru']); ?></td>
                </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>
