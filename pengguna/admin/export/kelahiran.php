<?php
// Ambil data kelahiran berdasarkan id_kelahiran
include '../../../keamanan/koneksi.php';

$id_kelahiran = isset($_GET['id_kelahiran']) ? $_GET['id_kelahiran'] : '';
$query = "SELECT kln.id_kelahiran, p.no_kk, p.nik, p.nama, p.tpt_lahir, p.tgl_lahir, p.jk, p.alamat, p.id_rt, p.agama, 
                 kln.nama_anak, kln.nama_ayah, p_ayah.nama AS nama_data_ayah, p_ayah.id_penduduk, 
                 kln.nama_ibu, p_ibu.nama AS nama_data_ibu, p_ibu.id_penduduk,
                 rt.nama_rt, p.pendidikan, p.pekerjaan, p.status, 
                 kln.nama_ayah, kln.nama_ibu
          FROM kelahiran kln
          JOIN penduduk p ON kln.nama_anak = p.id_penduduk
          JOIN penduduk p_ayah ON kln.nama_ayah = p_ayah.id_penduduk
          JOIN penduduk p_ibu ON kln.nama_ibu = p_ibu.id_penduduk
          LEFT JOIN rt ON p.id_rt = rt.id_rt
    WHERE kln.id_kelahiran = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $id_kelahiran);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data dari database
if ($result->num_rows > 0) {
    $dataKelahiran = $result->fetch_assoc();
} else {
    // Jika data tidak ditemukan, buat array dengan placeholder
    $dataKelahiran = [
        'no_kk' => '............................',
        'nik' => '............................',
        'nama' => '............................',
        'tpt_lahir' => '............................',
        'tgl_lahir' => '............................',
        'jk' => '............................',
        'nama_data_ayah' => '............................',
        'nama_data_ibu' => '............................'
    ];
}

// Ambil data lurah dengan id_lurah = 1
$queryLurah = "SELECT * FROM lurah WHERE id_lurah = 1";
$resultLurah = $koneksi->query($queryLurah);
$dataLurah = $resultLurah->fetch_assoc();

// Ambil konten template surat
$tabelHtml = file_get_contents('kelahiran.html');

// Gantikan placeholder dengan data dari database
$htmlContent = str_replace(
    [
        '[No KK]',
        '[NIK]',
        '[Nama]',
        '[Tempat Lahir]',
        '[Tanggal Lahir]',
        '[Jenis Kelamin]',
        '[Nama Ayah]',
        '[Nama Ibu]',
        '[Tanggal Surat]',
        '[Kantor Lurah]',
        '[Nama Lurah]'
    ],
    [
        htmlspecialchars($dataKelahiran['no_kk']),
        htmlspecialchars($dataKelahiran['nik']),
        htmlspecialchars($dataKelahiran['nama']),
        htmlspecialchars($dataKelahiran['tpt_lahir']),
        htmlspecialchars(date('d M Y', strtotime($dataKelahiran['tgl_lahir']))),
        htmlspecialchars($dataKelahiran['jk']),
        htmlspecialchars($dataKelahiran['nama_data_ayah']),
        htmlspecialchars($dataKelahiran['nama_data_ibu']),
        date('d M Y'),
        'Oepura',
        htmlspecialchars($dataLurah['nama_lurah'])
    ],
    $tabelHtml
);

// Buat file HTML sementara di folder sistem
$tmpHtmlFile = tempnam(sys_get_temp_dir(), 'html') . '.html';
file_put_contents($tmpHtmlFile, $htmlContent);

// Nama file output PDF (gunakan direktori sementara untuk menyimpan PDF)
$outputFile = sys_get_temp_dir() . '/hasil_kelahiran.pdf';

// Jalankan perintah wkhtmltopdf dan tangkap output/error
$command = "C:/xampp/htdocs/sistem_kependudukan/wkhtmltopdf/bin/wkhtmltopdf $tmpHtmlFile $outputFile";
exec($command, $output, $return_var);

// Debugging: cek output wkhtmltopdf
if ($return_var != 0) {
    echo "Gagal menghasilkan PDF. Error: <pre>" . print_r($output, true) . "</pre>";
    unlink($tmpHtmlFile); // Hapus file HTML sementara
    exit;
}

// Hapus file HTML sementara
unlink($tmpHtmlFile);

// Cek apakah file PDF benar-benar ada
if (file_exists($outputFile)) {
    // Kirim PDF ke browser
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="hasil_kelahiran.pdf"');
    header('Content-Length: ' . filesize($outputFile));
    readfile($outputFile);
} else {
    echo "File PDF tidak ditemukan.";
}
