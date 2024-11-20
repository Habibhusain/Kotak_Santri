<?php 
require "config/config.php";

function connect_db() {
    $db = new mysqli (HOSTNAME,USERNAME,PASSWORD,DATABASE);
    return $db;
}

function login_santri() {

    $nama_santri = $_POST['nama_santri'];
    $nomor_santri = $_POST['nomor_santri'];

    $sql_login_santri = "SELECT * FROM santri WHERE nama_santri = '$nama_santri' AND nomor_santri = '$nomor_santri'";
    $eksekusi_login_santri = connect_db()->query($sql_login_santri);

    if ($eksekusi_login_santri->num_rows > 0) {
        $user = $eksekusi_login_santri->fetch_assoc();
        $_SESSION['id_santri'] = $user['id_santri'];
        return $user;
    } else {
        return false;
    }
}

function login_guru() {

    $nama_guru = $_POST['nama_guru'];
    $nomor_guru = $_POST['nomor_guru'];

    $sql_login_guru = "SELECT * FROM guru WHERE nama_guru = '$nama_guru' AND nomor_guru = '$nomor_guru'";
    $eksekusi_login_guru = connect_db()->query($sql_login_guru);

    if ($eksekusi_login_guru->num_rows > 0) {
        $user = $eksekusi_login_guru->fetch_assoc();
        $_SESSION['id_guru'] = $user['id_guru'];
        return $user;
    } else {
        return false;
    }
}

function tambah_santri() {

    $nama_santri = $_POST['nama_santri'];
    $nomor_santri = $_POST['nomor_santri'];
    $asal_santri = $_POST['asal'];

    $cek_login_santri = "SELECT * FROM santri WHERE nomor_santri = '$nomor_santri'";
    $eksekusi_cek_login_santri = connect_db()->query($cek_login_santri);

    if ($eksekusi_cek_login_santri->num_rows > 0) {
        echo "<script>
        alert('Nomor Santri sudah digunakan');
        window.location='index.php';
        </script>";
    } else {
        $tambah_santri = "INSERT INTO santri (nama_santri,nomor_santri,asal) VALUES ('$nama_santri','$nomor_santri','$asal_santri')";
        $tambah = connect_db()->query($tambah_santri);
    if ($tambah) {
        return TRUE;
    } else {
        return "Terjadi kesalahan: " . connect_db()->error;
    }
 }
}

function tampil_data_pengaduan_guru() {

    $tampil_data_pengaduan = "SELECT pengaduan.*, santri.nama_santri FROM pengaduan JOIN santri ON pengaduan.id_santri = santri.id_santri";
    $eksekusi_tampil_pengaduan = connect_db()->query($tampil_data_pengaduan);
    $tampil_guru = array();

    while ($row = $eksekusi_tampil_pengaduan->fetch_assoc()) {
        $tampil_guru[] = $row;
    }

    return $tampil_guru;
}

function tampil_data_pengaduan_santri() {
    
    $id = $_SESSION['id_santri']['id_santri'];
    $tampil_data_pengaduan = "SELECT pengaduan.*, santri.nama_santri FROM pengaduan JOIN santri ON pengaduan.id_santri = santri.id_santri WHERE pengaduan.id_santri = '$id' ";
    $eksekusi_tampil_pengaduan = connect_db()->query($tampil_data_pengaduan);
    $pengaduan_santri = array();

    while ($row = $eksekusi_tampil_pengaduan->fetch_assoc()) {
        $pengaduan_santri[] = $row;
    }
    return $pengaduan_santri;
}


function upload_foto_pengaduan() {

    $ambil_ukuran_file = $_FILES['foto']['size'];
    $ukuran_diizinkan = 10000000;

    if ($ambil_ukuran_file > $ukuran_diizinkan) {
        echo 'Ukuran file maksimal 10 MB !!';
        exit();
    }

    $ambil_nama_file = $_FILES['foto']['name'];
    $ambil_ektensi_file = pathinfo($ambil_nama_file, PATHINFO_EXTENSION);
    $extensi_diizinkan = ['jpg', 'jpeg', 'png', 'svg', 'JPG', 'avif'];

    if (in_array($ambil_ektensi_file, $extensi_diizinkan)) {
        $ambil_tmp_file = $_FILES['foto']['tmp_name'];
        $tujuan_folder = "../image/";
        $target_file = $tujuan_folder . basename($ambil_nama_file);

        if (move_uploaded_file($ambil_tmp_file, $target_file)) {
            return $ambil_nama_file;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}


function tambah_data_pengaduan() {

    $id_santri = $_SESSION['id_santri']['id_santri'];
    $isi_pengaduan = $_POST['isi_pengaduan'];
    $foto = upload_foto_pengaduan();
    var_dump($id_santri);
    if ($foto === FALSE) {
        echo 'Upload foto gagal atau format tidak diizinkan.';
        return false;
    }

    $tambah_data_pengaduan = connect_db()->query("INSERT INTO pengaduan (tgl_pengaduan, id_santri, isi_pengaduan, foto) 
    VALUES (NOW(),'$id_santri','$isi_pengaduan','$foto')");

   return $tambah_data_pengaduan;
}


function get_pengaduan_by_id($id_pengaduan) {
    $sql = "SELECT pengaduan.*, santri.nama_santri FROM pengaduan  
        JOIN santri ON pengaduan.id_santri = santri.id_santri 
        WHERE pengaduan.id_pengaduan = '$id_pengaduan'";
    
    $result = connect_db()->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}


function tambah_tanggapan($id_pengaduan)  {

    $tanggapan = $_POST['isi_tanggapan'];
    $id_guru = $_SESSION['id_guru']['id_guru'];
    $tambah_tanggapan = connect_db()->query("INSERT INTO tanggapan (id_pengaduan, tgl_pengaduan, isi_tanggapan, id_guru) VALUES ('$id_pengaduan', NOW(),'$tanggapan', '$id_guru')");

    return $tambah_tanggapan;
}

function tampil_data_tanggapan_santri() {

    $id_santri = $_SESSION['id_santri']['id_santri'];
    
    $sql = "SELECT t.*, g.nama_guru 
            FROM tanggapan t 
            JOIN pengaduan p ON t.id_pengaduan = p.id_pengaduan
            JOIN santri s ON p.id_santri = s.id_santri
            JOIN guru g ON t.id_guru = g.id_guru
            WHERE s.id_santri = '$id_santri'";
    
    $eksekusi_tampil_tanggapan = connect_db()->query($sql);
    $tanggapan_santri = array();

    while ($row = $eksekusi_tampil_tanggapan->fetch_assoc()) {
        $tanggapan_santri[] = $row;
    }
    
    return $tanggapan_santri;
}

function tampil_tanggapan_by_pengaduan($id_pengaduan) {

    $sql = "SELECT t.*, g.nama_guru 
            FROM tanggapan t
            JOIN guru g ON t.id_guru = g.id_guru
            WHERE t.id_pengaduan = '$id_pengaduan'";
    
    $eksekusi = connect_db()->query($sql);
    $tanggapan = array();

    while ($row = $eksekusi->fetch_assoc()) {
        $tanggapan[] = $row;
    }

    return $tanggapan;
}

function tampil_pengaduan_dan_santri() {

    $sql = "SELECT p.*, s.nama_santri 
            FROM pengaduan p
            JOIN santri s ON p.id_santri = s.id_santri";
    $eksekusi = connect_db()->query($sql);
    $pengaduan = array();

    while ($row = $eksekusi->fetch_assoc()) {
        $pengaduan[] = $row;
    }

    return $pengaduan;
}

function edit_pengaduan($id_pengaduan, $isi_pengaduan, $foto) {

    if (!empty($foto)) {
        $update_query = "UPDATE pengaduan SET isi_pengaduan = '$isi_pengaduan', foto = '$foto' WHERE id_pengaduan = '$id_pengaduan'";
    } else {
        $update_query = "UPDATE pengaduan SET isi_pengaduan = '$isi_pengaduan' WHERE id_pengaduan = '$id_pengaduan'";
    }

    if (connect_db()->query($update_query) === TRUE) {
        // Jika ada foto baru, pindahkan file ke direktori tujuan
        if (!empty($foto)) {
            $target_dir = "../image/";
            $target_file = $target_dir . basename($foto);
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
        }
        return true;
    } else {
        return false; 
    }
}

function edit_tanggapan_guru($id_tanggapan, $isi_tanggapan) {

    // Membuat query SQL untuk mengedit tanggapan
    $edit_tanggapan_guru = "UPDATE tanggapan SET isi_tanggapan = '$isi_tanggapan' WHERE id_tanggapan = '$id_tanggapan'";

    $edit_tanggapan = connect_db()->query($edit_tanggapan_guru);

    return $edit_tanggapan;
}

function get_tanggapan_by_id($id_tanggapan) {

    $query = "SELECT * FROM tanggapan WHERE id_tanggapan = '$id_tanggapan'";
    $result = connect_db()->query($query);
    if ($result->num_rows > 0) {

        return $result->fetch_assoc();
    }
    
    return false;
}
