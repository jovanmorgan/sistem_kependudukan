<?php
include '../../../../keamanan/koneksi.php';

// Terima ID lurah yang akan dihapus dari formulir HTML
$id_lurah = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_lurah)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data lurah berdasarkan ID
$query_delete_lurah = "DELETE FROM lurah WHERE id_lurah = '$id_lurah'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_lurah)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);