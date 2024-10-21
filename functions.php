<?php 
require "config/config.php";


function connect_db()
{
    $db = new mysqli (HOSTNAME,USERNAME,PASSWORD,DATABASE);
    return $db;
}

function login_santri()
{
    $nama_santri = $_POST['nama_santri'];
    $nomor_santri = $_POST['nomor_santri'];

    $sql_login_santri = "SELECT * FROM santri WHERE nama_santri = '$nama_santri' AND nomor_santri = '$nomor_santri'";
    $eksekusi_login_santri = connect_db()->query($sql_login_santri);

    if($eksekusi_login_santri->num_rows > 0){
        $user = $eksekusi_login_santri->fetch_assoc();
        $_SESSION['id_santri'] = $user['id_santri'];
        return $user;
    }else{
        return false;
    }
}

function login_guru()
{
    $nama_guru = $_POST['nama_guru'];
    $nomor_guru = $_POST['nomor_guru'];

    $sql_login_guru = "SELECT * FROM guru WHERE nama_guru = '$nama_guru' AND nomor_guru = '$nomor_guru'";
    $eksekusi_login_guru = connect_db()->query($sql_login_guru);

    if($eksekusi_login_guru->num_rows > 0){
        $user = $eksekusi_login_guru->fetch_assoc();
        $_SESSION['id_guru'] = $user['id_guru'];
        return $user;
    }else{
        return false;
    }
}

function tambah_santri()
{
    $nama_santri = $_POST['nama_santri'];
    $nomor_santri = $_POST['nomor_santri'];
    $asal_santri = $_POST['asal'];
    $cek_login_santri = "SELECT * FROM santri WHERE nomor_santri = '$nomor_santri'";
    $eksekusi_cek_login_santri = connect_db()->query($cek_login_santri);

    if($eksekusi_cek_login_santri->num_rows > 0){
        echo "<script>
        alert('Nomor Santri sudah digunakan');
        window.location='index.php';
        </script>";
    }else{
        $tambah_santri = "INSERT INTO santri (nama_santri,nomor_santri,asal) VALUES ('$nama_santri','$nomor_santri','$asal_santri')";
        $tambah = connect_db()->query($tambah_santri);
    if ($tambah) {
        return TRUE;
    } else {
        return "Terjadi kesalahan: " . connect_db()->error;
    }
 }
}

function tampil_data_pengaduan_guru()
{
    $tampil_data_pengaduan = "SELECT p.*, s.nama_santri FROM pengaduan p JOIN santri s ON p.id_santri = s.id_santri";

    $eksekusi_tampil_pengaduan = connect_db()->query($tampil_data_pengaduan);
    $tampil_guru = array();

    while ($row = $eksekusi_tampil_pengaduan->fetch_assoc()) {
        $tampil_guru[] = $row;
    }
    return $tampil_guru;
}

function tampil_data_pengaduan_santri()
{
    $id = $_SESSION['id_santri'];
    $tampil_data_pengaduan = "SELECT * FROM pengaduan WHERE id_santri = '$id'";
    $eksekusi_tampil_pengaduan = connect_db()->query($tampil_data_pengaduan);
    $pengaduan_santri = array();

    while ($row = $eksekusi_tampil_pengaduan->fetch_assoc()) {
        $pengaduan_santri[] = $row;
    }
    return $pengaduan_santri;
}

function tampil_data_tanggapan($id_guru)
{
    $tampil_data_tanggapan = "SELECT * FROM tanggapan WHERE id_guru ='$id_guru'";
    $eksekusi_tampil_tanggapan = connect_db()->query($tampil_data_tanggapan);
    $tampil_guru = array();

    while($tampil = $eksekusi_tampil_tanggapan->fetch_assoc())
    {
        $tampil_guru[]=$tampil;
    }
    return $tampil_guru;
}

function upload_foto_pengaduan()
{
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


function tambah_data_pengaduan()
{
    $id_santri = $_SESSION['id_santri'];
    $isi_pengaduan = $_POST['isi_pengaduan'];
    $foto = upload_foto_pengaduan();
    $isi_pengaduan = $_POST['isi_pengaduan'];
    $tanggal_pengaduan = date('Y-m-d');
    
    $tambah_data_pengaduan ="INSERT INTO pengaduan (tgl_pengaduan,id_santri,isi_pengaduan,foto)
                                VALUES ($tanggal_pengaduan,'$id_santri','$isi_pengaduan','$foto')";
    $eksekusi_tambah_pengaduan = connect_db()->query($tambah_data_pengaduan);

    return $eksekusi_tambah_pengaduan;
}
function get_pengaduan_by_id($id_pengaduan) {
    $db = connect_db();
    $sql = "
        SELECT p.*, s.nama_santri 
        FROM pengaduan p 
        JOIN santri s ON p.id_santri = s.id_santri 
        WHERE p.id_pengaduan = '$id_pengaduan'";
    
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}



function tambah_tanggapan($id_pengaduan, $id_guru, $isi_tanggapan) {

    $tambah_tanggapan = "INSERT INTO tanggapan (id_pengaduan, tgl_pengaduan, isi_tanggapan, id_guru)
                         VALUES ('$id_pengaduan', NOW(), '$isi_tanggapan', '$id_guru')";
    return connect_db()->query($tambah_tanggapan);
}

function tambah_pengaduan($id_santri, $isi_pengaduan, $foto) {
    $db = connect_db();
    $stmt = $db->prepare("INSERT INTO pengaduan (id_santri, isi_pengaduan, foto, tgl_pengaduan) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $id_santri, $isi_pengaduan, $foto);
    return $stmt->execute();
}

function tampil_data_pengaduan() {
    $db = connect_db();
    $sql = "SELECT * FROM pengaduan";
    $result = $db->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}