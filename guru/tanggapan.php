<?php session_start();
require "../functions.php";

// Cek apakah guru sudah login
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

// Cek apakah data pengaduan ditemukan
if (!$data_pengaduan) {
    echo "<script>
    alert('Data pengaduan tidak ditemukan');
    window.location='dashboard.php';
    </script>";
    exit();
}

// Proses tanggapan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    if (tambah_tanggapan($id_pengaduan)) {
        echo "<script>
        alert('Tanggapan Berhasil Dikirim');
        window.location='dashboard.php';
        </script>";
    } else {
        // echo "<script>
        // alert('Tanggapan Gagal Dikirim');
        // </script>";
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
        <div class="box-1">
        <h2>Isi Pengaduan:</h2>
        <p><?php echo htmlspecialchars($data_pengaduan['isi_pengaduan']); ?></p>
        <img src="../image/<?php echo htmlspecialchars($data_pengaduan['foto']); ?>" alt="Foto Pengaduan" width="150">

        <h2>Berikan Tanggapan:</h2>
        <form method="POST">
            <textarea name="isi_tanggapan" required autofocus></textarea>
            <input type="submit" value="Kirim Tanggapan">
        <a href="dashboard.php">Kembali ke Dashboard</a>
        </form>
        </div>
    </div>
</div>
<footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>
