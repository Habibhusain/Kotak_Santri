<?php
session_start();
require "../functions.php"; // Pastikan fungsi ini memuat koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses pengaduan yang dikirim
    $id_santri = $_POST['id_santri']; // Pastikan ini diisi dari session atau input
    $isi_pengaduan = $_POST['isi_pengaduan'];
    $foto = upload_foto_pengaduan();

    if (tambah_pengaduan($id_santri, $isi_pengaduan, $foto)) {
        echo "<script>alert('Pengaduan berhasil dikirim');</script>";
    } else {
        echo "<script>alert('Gagal mengirim pengaduan');</script>";
    }
}

// Ambil data pengaduan untuk ditampilkan
$data_pengaduan = tampil_data_pengaduan(); // Fungsi ini perlu didefinisikan

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Santri</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Form Pengaduan Santri</h1>
    <form method="POST">
        <input type="hidden" name="id_santri" value="<?php echo $_SESSION['id_santri']; ?>">
        <textarea name="isi_pengaduan" placeholder="Tulis pengaduan..." required></textarea>
        <input type="file" name="foto">
        <input type="submit" value="Kirim Pengaduan">
    </form>

    <h2>Daftar Pengaduan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Isi Pengaduan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($data_pengaduan as $pengaduan): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d-m-Y', strtotime($pengaduan['tgl_pengaduan'])); ?></td>
                <td><?php echo htmlspecialchars($pengaduan['isi_pengaduan']); ?></td>
                <td><img src="../image/<?php echo htmlspecialchars($pengaduan['foto']); ?>" alt="" width="100"></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
