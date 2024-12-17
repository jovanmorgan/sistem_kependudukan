<?php
include '../../../../keamanan/koneksi.php';

// Terima ID penduduk yang akan dihapus dari formulir HTML
$id_penduduk = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_penduduk)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data penduduk berdasarkan ID
$query_delete_penduduk = "DELETE FROM penduduk WHERE id_penduduk = '$id_penduduk'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_penduduk)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
