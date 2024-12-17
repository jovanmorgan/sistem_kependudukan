<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_anak = $_POST['nama_anak'];
$nama_ayah = $_POST['nama_ayah'];
$nama_ibu = $_POST['nama_ibu'];
$tgl_lahir = $_POST['tgl_lahir'];
$tpt_lahir = $_POST['tpt_lahir'];

// Cek apakah nama_ayah ada di tabel penduduk dan ambil id_rt
$query = "SELECT * FROM penduduk WHERE id_penduduk = '$nama_ayah'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $no_kk = $row['no_kk'];
    $nik = "-";
    $nama = $row['nama'];
    $jk = $row['jk'];
    $alamat = $row['alamat'];
    $id_rt = $row['id_rt'];
    $agama = $row['agama'];
    $stts_perkawinan = $row['stts_perkawinan'];
    $pendidikan = $row['pendidikan'];
    $pekerjaan = $row['pekerjaan'];
    $status = "Anak";

    // Masukkan nama_anak ke dalam tabel penduduk
    $query_anak = "INSERT INTO penduduk (no_kk, nik, nama, tpt_lahir, tgl_lahir, jk, alamat, id_rt, agama, stts_perkawinan, pendidikan, pekerjaan, status) VALUES ('$no_kk', '$nik', '$nama_anak', '$tpt_lahir', '$tgl_lahir', '$jk', '$alamat', '$id_rt', '$agama', '$stts_perkawinan', '$pendidikan', '$pekerjaan', '$status')";
    if (mysqli_query($koneksi, $query_anak)) {
        // Ambil id_penduduk yang baru saja ditambahkan
        $data_id_penduduk = mysqli_insert_id($koneksi);

        // Buat query SQL untuk menambahkan data ke tabel kelahiran
        $query_kelahiran = "INSERT INTO kelahiran (nama_anak, nama_ayah, nama_ibu) 
                            VALUES ('$data_id_penduduk', '$nama_ayah', '$nama_ibu')";

        // Jalankan query untuk tabel kelahiran
        if (mysqli_query($koneksi, $query_kelahiran)) {
            echo "success";
        } else {
            echo "Error inserting into kelahiran: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error inserting into penduduk: " . mysqli_error($koneksi);
    }
} else {
    echo "Nama ayah tidak ditemukan dalam tabel penduduk.";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
