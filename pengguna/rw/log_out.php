<?php
session_start();

// Hapus sesi id_rw jika ada
if (isset($_SESSION['id_rw'])) {
    unset($_SESSION['id_rw']);
}

// Redirect pengguna kembali ke halaman login
header("Location: ../../berlangganan/login");
exit;
