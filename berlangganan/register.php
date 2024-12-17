<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap?v=<?= time(); ?>" rel="stylesheet">
    <title>Register</title>
    <link href="../css/login&register.css?v=<?= time(); ?>" rel="stylesheet" />
    <link rel="shortcut icon" href="../assets/img/kantor_desa/logo.png" type="" />
    <!-- Link untuk Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?v=<?= time(); ?>">
    <style>
        :root {
            --background: #F4F4F9;
            --color: #ffffff;
            --primary-color: #005CAF;
        }

        .show-password {
            position: absolute;
            bottom: 157px;
            right: 45px;
        }

        .lcntainer form input {
            color: #00000000;
            display: block;
            padding: 14.5px;
            width: 100%;
            margin: 2rem 0;
            outline: none;
            background-color: #ffffffd5;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            letter-spacing: 0.8px;
            font-size: 15px;
            backdrop-filter: blur(15px);
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }
    </style>
</head>

<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <!-- <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" /> -->
                <h1 class="opacity" style="text-align: center;">REGISTER</h1>
                <form id="registrasi" action="../keamanan/proses_register_pengunjung" method="POST">
                    <input type="text" name="nama" placeholder="Nama" style="color: black;" />
                    <input type="text" name="username" placeholder="Username" style="color: black;" />
                    <div class="password-container">
                        <input type="password" name="password" id="login-password" placeholder="Password"
                            style="color: black; " required>
                        <i class="fa fa-eye-slash show-password" aria-hidden="true"
                            onclick="togglePasswordVisibility('login-password')"
                            style="margin-bottom: 35px; color: black;"></i>
                    </div>
                    <button type="submit" class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="login">LOGIN</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>
    <!-- End footer -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var passwordIcon = document.querySelector(
                "#" + inputId + " + .show-password"
            );

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            }
        }

        document
            .getElementById("registrasi")
            .addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the form from submitting by default

                // Get the form element
                var form = this;

                // Ambil data dari form
                var formData = new FormData(form);

                // Cek apakah semua input diisi
                var nama = formData.get("nama");
                var password = formData.get("password");
                var username = formData.get("username");

                if (
                    nama === "" ||
                    password === "" ||
                    username === ""
                ) {
                    Swal.fire("Error", "Semua data wajib diisi", "error");
                    return; // Stop the submission process if any input is empty
                }

                // Kirim data menggunakan AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../keamanan/proses_register_pengunjung", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Tampilkan SweetAlert berdasarkan respon dari ../keamanan/proses_register_pengunjung
                            var response = xhr.responseText;
                            if (response.trim() === "success") {
                                // Reset the form after successful submission
                                form.reset();
                                Swal.fire({
                                    title: "Success",
                                    text: "Data berhasil ditambahkan",
                                    icon: "success"
                                })
                            } else if (response.trim() === "error_admin_code") {
                                Swal.fire("Error", "Kode admin tidak sesuai", "error");
                            } else if (response.trim() === "error_username_exists") {
                                Swal.fire("Error", "Akun ini sudah terdaftar!, Silakan gunakan akun lain",
                                    "error");
                            } else if (response.trim() === "username_belum_pas") {
                                Swal.fire("Error", "Nomor Registrasi harus memiliki minimal 12 Nomor", "error");
                            } else if (response.trim() === "error_password_length") {
                                Swal.fire("Error", "Password harus memiliki minimal 8 karakter", "error");
                            } else if (response.trim() === "error_password_strength") {
                                Swal.fire("Error",
                                    "Password harus mengandung huruf besar, huruf kecil, dan angka", "error"
                                );
                            } else {
                                Swal.fire("Error", "Terjadi kesalahan saat proses login", "error");
                            }
                        } else {
                            Swal.fire("Error", "Gagal melakukan request", "error");
                        }
                    }
                };
                xhr.onerror = function() {
                    Swal.fire("Error", "Gagal melakukan request", "error");
                };
                xhr.send(formData);
            });
    </script>
</body>

</html>