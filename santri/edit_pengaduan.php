<?php
session_start();
require "../functions.php";

if (!isset($_SESSION['id_santri'])) {
    echo "<script>
    alert('Login Terlebih Dahulu');
    window.location='index.php';
    </script>";
    exit();
}

if (!isset($_GET['id_pengaduan'])) {
    echo "<script>
            alert('ID Pengaduan tidak ditemukan');
            window.location='index.php';
          </script>";
          exit();
}

$id_pengaduan = $_GET['id_pengaduan'];

$tampil_data = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'";
$result = connect_db()->query($tampil_data);

if ($result->num_rows === 0) {
    echo "<script>
    alert('Pengaduan tidak ditemukan');
    window.location='index.php';
    </script>";
    exit();
}

$pengaduan = $result->fetch_assoc();

// Proses pengeditan pengaduan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi_pengaduan = $_POST['isi_pengaduan'];
    $foto = $_FILES['foto']['name'];

    // Memanggil fungsi untuk memperbarui pengaduan
    if (edit_pengaduan($id_pengaduan, $isi_pengaduan, $foto)) {
        echo "<script>
        alert('Pengaduan berhasil diperbarui');
        window.location='index.php';
        </script>";
        exit();
    } else {
        echo "<script>
        alert('Gagal memperbarui pengaduan');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaduan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
        <div class="boxes-judul">
            <h1>Edit Pengaduan</h1>
        </div>
    <div class="boxes">
        <div class="boxes-1">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="isi_pengaduan">Isi Pengaduan:</label>
            <textarea name="isi_pengaduan" id="isi_pengaduan" required><?php echo $pengaduan['isi_pengaduan']; ?></textarea>

            <img src="../image/<?php echo $pengaduan['foto'];?>" alt="" width="100px">
            <label for="foto">Foto (Opsional):</label>
            <input type="file" name="foto" id="foto">

            <input type="submit" name="submit">
            <a href="index.php">Kembali</a>
        </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 by Habib Husain Nurrohim. All rights reserved.</p>
    </footer>
</body>
</html>
