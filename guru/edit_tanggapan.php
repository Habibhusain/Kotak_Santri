<?php session_start();
require "../functions.php";

if(!isset($_SESSION['id_guru'])) {
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='../index.php';
    </script>";
    exit();
}
if (!isset($_GET['id_tanggapan'])) {
    echo "<script>
    alert('ID Pengaduan tidak ditemukan');
    window.location='lihat_tanggapan.php';
    </script>";
    exit();
}
$id_tanggapan = $_GET['id_tanggapan'];
$tanggapan = get_tanggapan_by_id($id_tanggapan);

// Proses pengeditan tanggapan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi_tanggapan = $_POST['isi_tanggapan'];

    // Memanggil fungsi untuk mengedit tanggapan
    if (edit_tanggapan_guru($id_tanggapan, $isi_tanggapan)) {
        echo "<script>
        alert('Tanggapan berhasil diperbarui');
        window.location='lihat_tanggapan.php';
        </script>";
        exit();
    } else {
        echo "<script>
        alert('Gagal memperbarui tanggapan');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tanggapan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="box-judul">
<h1>Edit Tanggapan</h1>
</div>
    <div class="box">
        <div class="boxes-1">
    <form action="" method="post">
        <textarea name="isi_tanggapan" required><?php echo $tanggapan['isi_tanggapan']; ?></textarea>
        <input type="submit" value="Simpan Perubahan">
        <a href="lihat_tanggapan.php">Kembali</a>
    </form>
    </div>
</div>
<footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>
