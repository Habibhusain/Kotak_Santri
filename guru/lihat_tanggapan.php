<?php session_start();
require "../functions.php";

// Cek apakah santri atau guru sudah login
if (!isset($_SESSION['id_santri']) && !isset($_SESSION['id_guru'])) {
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='../index.php';
    </script>";
    exit();
}

// Ambil semua pengaduan santri
$pengaduan_santri = tampil_pengaduan_dan_santri();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Tanggapan Guru</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <div class="container-judul">
        <h1>Tanggapan Guru untuk Pengaduan Santri</h1>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
    
    <div class="container-table-guru">
        <!-- Tabel Tanggapan -->
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Santri</td>
                    <td>Isi Pengaduan</td>
                    <td>Tanggapan Guru</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pengaduan_santri as $pengaduan): ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo htmlspecialchars($pengaduan['nama_santri']); ?></td>
                    <td><?php echo htmlspecialchars($pengaduan['isi_pengaduan']); ?></td>
                    <td>
                        <!-- Menampilkan tanggapan dari guru -->
                        <?php
                        $tanggapan_guru = tampil_tanggapan_by_pengaduan($pengaduan['id_pengaduan']);
                        if (!empty($tanggapan_guru)): ?>
                            <ul>
                                <?php foreach ($tanggapan_guru as $tanggapan): ?>
                                <li>
                                    <strong><?php echo htmlspecialchars($tanggapan['nama_guru']); ?>:</strong> 
                                    <?php echo htmlspecialchars($tanggapan['isi_tanggapan']); ?>
                                    <small>(<?php echo date('d-m-Y', strtotime($tanggapan['tgl_pengaduan'])); ?>)</small>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Tidak ada tanggapan untuk pengaduan ini.</p>
                        <?php endif; ?>
                    </td>
                    <td><a href="edit_tanggapan.php?id_tanggapan=<?php echo $tanggapan['id_tanggapan'];?>">Edit</a></td>
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
