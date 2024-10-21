<?php

require "config.php";

    $db = new mysqli(HOSTNAME,USERNAME,PASSWORD);

    if($db->connect_error)
    {
        die('Gagal Terkoneksi' . $db->connect_error);
    }

    $sql_buat_database="CREATE DATABASE kotak_santri";
    $eksekusi_database= $db->query($sql_buat_database);

    if($eksekusi_database)
    {
        echo 'Buat Database kontak santri Berhasil'. '<br>';
    }

    $sql_pakai_database= "USE kotak_santri";
    $eksekusi_pakai_database = $db->query($sql_pakai_database);

    if($eksekusi_pakai_database)
    {
        echo 'Database berhasil di pakai'. '<br>';
    }

    $sql_table_santri = "CREATE TABLE IF NOT EXISTS santri
                    (id_santri INT PRIMARY KEY AUTO_INCREMENT,
                    nama_santri VARCHAR (255),
                    nomor_santri VARCHAR (50) NOT NULL,
                    asal VARCHAR(100)
                    )";

    $eksekusi_table_santri = $db -> query($sql_table_santri);

    if($eksekusi_table_santri)
    {
        echo 'Table Santri Berhasil di buat'. '<br>';
    }

    $sql_table_guru = "CREATE TABLE IF NOT EXISTS guru 
                    (id_guru INT PRIMARY KEY AUTO_INCREMENT,
                    nama_guru VARCHAR (255),
                    nomor_guru VARCHAR (50)
                    )";

    $eksekusi_table_guru = $db->query($sql_table_guru);

    if($eksekusi_table_guru)
    {
        echo 'Table Guru Berhasil di Buat'. '<br>';
    }

    $sql_table_pengaduan = "CREATE TABLE IF NOT EXISTS pengaduan
                        (id_pengaduan INT PRIMARY KEY AUTO_INCREMENT,
                        tgl_pengaduan DATE,
                        id_santri INT NOT NULL,
                        isi_pengaduan TEXT,
                        foto TEXT,
                        FOREIGN KEY (id_santri) REFERENCES santri(id_santri)
                        )";

    $eksekusi_table_pengaduan = $db->query($sql_table_pengaduan);

    if($eksekusi_table_pengaduan)
    {
        echo 'Table Pengaduan Berhasil dibuat';
    }

    $sql_table_tanggapan = "CREATE TABLE IF NOT EXISTS tanggapan
                        (id_tanggapan INT PRIMARY KEY AUTO_INCREMENT,
                        id_pengaduan INT NOT NULL,
                        tgl_pengaduan DATE,
                        isi_tanggapan TEXT,
                        id_guru INT,
                        FOREIGN KEY (id_pengaduan) REFERENCES pengaduan(id_pengaduan),
                        FOREIGN KEY (id_guru) REFERENCES guru(id_guru)
                        )";

    $eksekusi_table_tanggapan = $db->query($sql_table_tanggapan);

    if($eksekusi_table_tanggapan)
    {
        echo 'Table Tanggapan Berhasil dibuat'. '<br>';
    }

    $db ->close();