<?php
// Daftar halaman yang tersedia
$pages = [
    '../dashboard' => 'Dashboard',
    '../bantuan' => 'Bantuan',
    '../kelahiran' => 'Kelahiran',
    '../kematian' => 'Kematian',
    '../kk' => 'Kartu Keluarga',
    '../lurah' => 'Lurah',
    '../penduduk_masuk' => 'Penduduk Masuk',
    '../penduduk_pindah' => 'Penduduk Pindah',
    '../penduduk' => 'Penduduk',
    '../penduduk_tidak_mampu' => 'Penduduk Tidak Mampu',
    '../rt' => 'Rukun Tetangga rt',
    '../rw' => 'Rukun Warga',
    '../profile' => 'Profile',
    '../log_out' => 'Log Out'
];

// Dapatkan query pencarian dari input
$query = isset($_POST['query']) ? strtolower(trim($_POST['query'])) : '';

// Variabel untuk menyimpan halaman yang cocok
$matched_page = null;

if ($query) {
    // Cari halaman yang tepat atau mendekati
    foreach ($pages as $page => $title) {
        if (strpos(strtolower($title), $query) !== false) {
            $matched_page = $page;
            break;
        }
    }

    // Redirect ke halaman yang cocok, atau ke halaman 404 jika tidak ada yang cocok
    if ($matched_page) {
        header("Location: $matched_page");
    } else {
        header("Location: ../404");
    }
    exit;
}
