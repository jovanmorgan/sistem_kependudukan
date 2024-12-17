<?php
include 'koneksi.php';

function checkpenggunahType($username)
{
    global $koneksi;
    $query_admin = "SELECT * FROM admin WHERE username = '$username'";
    $query_lurah = "SELECT * FROM lurah WHERE username = '$username'";
    $query_rt = "SELECT * FROM rt WHERE username = '$username'";
    $query_rw = "SELECT * FROM rw WHERE username = '$username'";

    $result_admin = mysqli_query($koneksi, $query_admin);
    $result_lurah = mysqli_query($koneksi, $query_lurah);
    $result_rt = mysqli_query($koneksi, $query_rt);
    $result_rw = mysqli_query($koneksi, $query_rw);

    if (mysqli_num_rows($result_admin) > 0) {
        return "admin";
    } elseif (mysqli_num_rows($result_lurah) > 0) {
        return "lurah";
    } elseif (mysqli_num_rows($result_rt) > 0) {
        return "rt";
    } elseif (mysqli_num_rows($result_rw) > 0) {
        return "rw";
    } else {
        return "not_found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi data
    if (empty($username) && empty($password)) {
        echo "tidak_ada_data";
        exit();
    }
    if (empty($username)) {
        echo "username_tidak_ada";
        exit();
    }

    if (empty($password)) {
        echo "password_tidak_ada";
        exit();
    }


    $penggunahType = checkpenggunahType($username);
    if ($penggunahType !== "not_found") {
        $query_penggunah = "SELECT * FROM $penggunahType WHERE username = '$username'";
        $result_penggunah = mysqli_query($koneksi, $query_penggunah);

        if (mysqli_num_rows($result_penggunah) > 0) {
            $row = mysqli_fetch_assoc($result_penggunah);
            $hashed_password = $row['password'];

            if ($password === $hashed_password) {

                // Process login for other penggunah types
                session_start();
                $_SESSION['username'] = $username;

                switch ($penggunahType) {
                    case "admin":
                        $_SESSION['id_admin'] = $row['id_admin'];
                        break;
                    case "lurah":
                        $_SESSION['id_lurah'] = $row['id_lurah'];
                        $id_lurah = $row['id_lurah'];
                        break;
                    case "rt":
                        $_SESSION['id_rt'] = $row['id_rt'];
                        break;
                    case "rw":
                        $_SESSION['id_rw'] = $row['id_rw'];
                        $id_rw = $row['id_rw'];
                        break;
                    default:
                        break;
                }

                // Success response
                switch ($penggunahType) {
                    case "admin":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/admin/";
                        break;
                    case "lurah":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/lurah/";
                        break;
                    case "rt":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/rt/";
                        break;
                    case "rw":
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../pengguna/rw/";
                        break;
                    default:
                        echo "success:" . $username . ":" . $penggunahType . ":" . "../berlangganan/login";
                        break;
                }
            } else {
                echo "error_password";
            }
        } else {
            echo "error_username";
        }
    } else {
        echo "error_username";
    }
}
