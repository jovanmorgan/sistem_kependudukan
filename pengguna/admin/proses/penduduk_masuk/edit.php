<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_masuk = $_POST['id_masuk'];
$id_penduduk = $_POST['id_penduduk'];
$alasan = $_POST['alasan'];
$tanggal_masuk = $_POST['tanggal_masuk'];

// Data yang akan di-update ke dalam tabel penduduk
$alamat = $_POST['alamat'];
$id_rt = $_POST['id_rt'];

// Update data penduduk_masuk
$query_update_masuk = "UPDATE penduduk_masuk 
                       SET id_penduduk = '$id_penduduk', 
                           alasan = '$alasan', 
                           tanggal_masuk = '$tanggal_masuk' 
                       WHERE id_masuk = '$id_masuk'";

// Update data penduduk
$query_update_penduduk = "UPDATE penduduk SET 
                            alamat = '$alamat',
                            id_rt = '$id_rt'
                          WHERE id_penduduk = '$id_penduduk'";

// Jalankan query update untuk penduduk_masuk
if (mysqli_query($koneksi, $query_update_masuk) && mysqli_query($koneksi, $query_update_penduduk)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
