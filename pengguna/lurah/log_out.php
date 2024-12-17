<?php
session_start();

// Hapus sesi id_lurah jika ada
if (isset($_SESSION['id_lurah'])) {
    unset($_SESSION['id_lurah']);
}

// Redirect pengguna kembali ke halaman login
header("Location: ../../berlangganan/login");
exit;
