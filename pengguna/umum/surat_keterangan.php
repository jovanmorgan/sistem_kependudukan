<!DOCTYPE html>
<html lang="en">

<?php include 'fitur/head.php'; ?>

<body>

    <!-- LOADER -->
    <div id="preloader">
        <div class="loader">
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__bar"></div>
            <div class="loader__ball"></div>
        </div>
    </div><!-- end loader -->
    <!-- END LOADER -->

    <?php include 'fitur/header.php'; ?>

    <!-- Bagian Card Mulai Di sini -->
    <div class="container">
        <h1 style="text-align:center; margin: 30px 0;">Surat Keterangan</h1>
        <div class="row">
            <!-- Card Penduduk Pindah -->
            <div class="col-md-4">
                <a href="../admin/export/penduduk_pindah.php" class="card-link">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fa fa-home fa-3x"></i>
                            <h3 class="card-title mt-3">Formulir Penduduk Pindah</h3>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Card Kurang Mampu -->
            <div class="col-md-4">
                <a href="../admin/export/penduduk_tidak_mampu.php" class="card-link">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fa fa-home fa-3x"></i>
                            <h3 class="card-title mt-3">Formulir Kurang Mampu</h3>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Card Kelahiran -->
            <div class="col-md-4">
                <a href="../admin/export/kelahiran.php" class="card-link">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fa fa-home fa-3x"></i>
                            <h3 class="card-title mt-3">Formulir Kelahiran</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-4" style="margin-top: 20px;">

            <!-- Card Kematian -->
            <div class="col-md-4">
                <a href="../admin/export/kematian.php" class="card-link">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fa fa-home fa-3x"></i>
                            <h3 class="card-title mt-3">Formulir Kematian</h3>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <!-- Bagian Card Berakhir Di sini -->

    <br><br>
    <?php include 'fitur/footer.php'; ?>

    <div class="copyrights">
        <div class="container">
            <div class="footer-distributed">
                <div class="footer-left">
                    <p class="footer-company-name">Dibuat oleh Arnando</p>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end copyrights -->

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <?php include 'fitur/js.php'; ?>

    <style>
        .card {
            transition: transform 0.3s ease;
            border-radius: 15px;
            padding: 20px;
            background-color: #fff;
            border: none;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card .card-body i {
            color: #007bff;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        h3.card-title {
            font-size: 1.5em;
            margin-top: 15px;
        }

        .shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .row .col-md-4 {
                margin-bottom: 20px;
            }
        }
    </style>

</body>

</html>