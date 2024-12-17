<?php
include '../../../../keamanan/koneksi.php';

if (isset($_POST['id_penduduk'])) {
    $id_penduduk = $_POST['id_penduduk'];

    // Query untuk mengambil data penduduk berdasarkan id_penduduk
    $query = "SELECT alamat, id_rt FROM penduduk WHERE id_penduduk = '$id_penduduk'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data); // Kirim data dalam format JSON
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID penduduk tidak valid']);
}
