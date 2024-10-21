<?php
session_start();
require "../functions.php";

if (!isset($_SESSION['id_guru'])) {
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='index.php';
    </script>";
    exit();
}

// Cek apakah ada ID pengaduan yang dikirim
if (!isset($_GET['id_pengaduan'])) {
    echo "<script>
    alert('ID Pengaduan tidak valid');
    window.location='dashboard.php';
    </script>";
    exit();
}

$id_pengaduan = $_GET['id_pengaduan'];
$data_pengaduan = get_pengaduan_by_id($id_pengaduan);

if (!$data_pengaduan) {
    echo "<script>
    alert('Data pengaduan tidak ditemukan');
    window.location='dashboard.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggapan = $_POST['isi_tanggapan'];
    $id_guru = $_SESSION['id_guru'];

    if (tambah_tanggapan($id_pengaduan, $id_guru, $tanggapan)) {
        echo "<script>
        alert('Tanggapan Berhasil Dikirim');
        window.location='dashboard.php';
        </script>";
    } else {
        echo "<script>
        alert('Tanggapan Gagal Dikirim');
        </script>";
    }
}

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
<div class="container">
    <div class="container-judul">
        <h1>Tanggapan Pengaduan</h1>
    </div>
    <div class="box">
        <h2>Isi Pengaduan:</h2>
        <p><?php echo $data_pengaduan['isi_pengaduan']; ?></p>
        <img src="../image/<?php echo $data_pengaduan['foto']; ?>" alt="Foto Pengaduan" width="300">

        <h2>Berikan Tanggapan:</h2>
        <form method="POST">
            <textarea name="isi_tanggapan" required></textarea>
            <input type="submit" value="Kirim Tanggapan">
        </form>
    </div>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</div>
</body>
</html>
