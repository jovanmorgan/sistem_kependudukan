<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_penduduk = $_POST['id_penduduk'];
$id_kelahiran = $_POST['id_kelahiran'];
$nama_anak = $_POST['nama_anak'];
$nama_ayah = $_POST['nama_ayah'];
$nama_ibu = $_POST['nama_ibu'];
$tgl_lahir = $_POST['tgl_lahir'];
$tpt_lahir = $_POST['tpt_lahir'];

// Cek apakah nama_ayah ada di tabel penduduk dan ambil data ayah
$query = "SELECT * FROM penduduk WHERE id_penduduk = '$nama_ayah'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $no_kk = $row['no_kk'];
    $jk = $row['jk'];
    $alamat = $row['alamat'];
    $id_rt = $row['id_rt'];
    $agama = $row['agama'];
    $stts_perkawinan = $row['stts_perkawinan'];
    $pendidikan = $row['pendidikan'];
    $pekerjaan = $row['pekerjaan'];
    $status = "Anak";

    // Update data anak di tabel penduduk berdasarkan id_penduduk
    $query_update = "UPDATE penduduk SET 
                    nama = '$nama_anak', 
                    tpt_lahir = '$tpt_lahir', 
                    tgl_lahir = '$tgl_lahir', 
                    jk = '$jk', 
                    alamat = '$alamat', 
                    id_rt = '$id_rt', 
                    agama = '$agama', 
                    stts_perkawinan = '$stts_perkawinan', 
                    pendidikan = '$pendidikan', 
                    pekerjaan = '$pekerjaan', 
                    status = '$status' 
                    WHERE id_penduduk = '$id_penduduk'";

    if (mysqli_query($koneksi, $query_update)) {
        // Setelah update berhasil, update data juga di tabel kelahiran
        $query_kelahiran_update = "UPDATE kelahiran SET 
                                   nama_anak = '$id_penduduk', 
                                   nama_ayah = '$nama_ayah', 
                                   nama_ibu = '$nama_ibu'
                                   WHERE id_kelahiran = '$id_kelahiran'";

        if (mysqli_query($koneksi, $query_kelahiran_update)) {
            echo "success";
        } else {
            echo "Error updating kelahiran: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error updating penduduk: " . mysqli_error($koneksi);
    }
} else {
    echo "Nama ayah tidak ditemukan dalam tabel penduduk.";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
