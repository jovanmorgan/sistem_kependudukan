<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk'];
$alasan = $_POST['alasan'];
$tanggal_masuk = $_POST['tanggal_masuk'];

// Data yang akan di-update ke dalam tabel penduduk
$alamat = $_POST['alamat'];
$id_rt = $_POST['id_rt'];;

// Query untuk menambahkan data ke tabel penduduk_masuk
$query_insert = "INSERT INTO penduduk_masuk (id_penduduk, alasan, tanggal_masuk) 
                 VALUES ('$id_penduduk', '$alasan', '$tanggal_masuk')";

// Query untuk meng-update data di tabel penduduk
$query_update = "UPDATE penduduk SET 
                    alamat = '$alamat',
                    id_rt = '$id_rt'
                WHERE id_penduduk = '$id_penduduk'";

// Jalankan query insert dan update
if (mysqli_query($koneksi, $query_insert) && mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
