<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard</h3>
                            <h6 class="op-7 mb-2">Halaman Dasboard</h6>
                        </div>
                    </div>

                    <?php
                    include '../../keamanan/koneksi.php';



                    $tables = [
                        'pendeta' => [
                            'label' => 'Pendeta',
                            'icon' => 'fas fa-bible', // Ikon pendeta
                            'color' => '#FFC107' // warna pendeta
                        ],
                        'majelis' => [
                            'label' => 'Majelis',
                            'icon' => 'fas fa-church', // Ikon majelis
                            'color' => '#ACFF' // warna majelis yang berbeda
                        ],
                        'rayon' => [
                            'label' => 'Rayon',
                            'icon' => 'fas fa-church', // Ikon rayon
                            'color' => '#2F4F4F' // warna rayon ungu
                        ],
                        'kepala_keluarga' => [
                            'label' => 'Kepala Keluarga',
                            'icon' => 'fas fa-user-tie', // Ikon kepala keluarga
                            'color' => '#4B0082' // warna kepala keluarga
                        ],
                        'jemaat' => [
                            'label' => 'Jemaat',
                            'icon' => 'fas fa-users', // Ikon jemaat
                            'color' => '#0000FF' // warna jemaat
                        ]
                    ];

                    $counts = [];

                    foreach ($tables as $table => $details) {
                        $query = "SELECT COUNT(*) as count FROM $table";
                        $result = mysqli_query($koneksi, $query);
                        $row = mysqli_fetch_assoc($result);
                        $counts[$table] = $row['count'];
                        mysqli_free_result($result);
                    }

                    mysqli_close($koneksi);
                    ?>
                    <?php include 'fitur/nama_halaman.php'; ?>

                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title" style="font-size: 30px;">Selamat Datang</h5>
                                        <p>
                                            Silakan lihat informsi yang kami sajikan pada website ini, Berikut adalah
                                            informasi data pada Halaman
                                            <?= $page_title ?>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section">
                        <div class="row">

                            <div class="row">
                                <?php foreach ($tables as $table => $details): ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="card card-stats card-round">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-icon">
                                                        <div class="icon-big text-center icon-secondary bubble-shadow-small"
                                                            style="background-color: <?= $details['color']; ?>;">
                                                            <i class="<?= $details['icon']; ?>"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col col-stats ms-3 ms-sm-0">
                                                        <div class="numbers">
                                                            <p class="card-category"><?= $details['label']; ?></p>
                                                            <h4 class="card-title"><?= $counts[$table]; ?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>


                            <table>
                                <tr>
                                    <th>Rayon</th>
                                    <th>KK</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>JMLH</th>
                                    <th colspan="2">Anggota Baptis</th>
                                    <th colspan="2">Anggota Sidi</th>
                                </tr>
                                <tr>
                                    <td>I</td>
                                    <td>41</td>
                                    <td>84</td>
                                    <td>91</td>
                                    <td>175</td>
                                    <td>Sudah</td>
                                    <td>155</td>
                                    <td>Belum</td>
                                    <td>20</td>
                                    <td>Sudah</td>
                                    <td>87</td>
                                    <td>Belum</td>
                                </tr>
                                <tr>
                                    <td>JLH</td>
                                    <td>267</td>
                                    <td>520</td>
                                    <td>544</td>
                                    <td>1064</td>
                                    <td></td>
                                    <td>928</td>
                                    <td></td>
                                    <td>136</td>
                                    <td></td>
                                    <td>586</td>
                                </tr>
                            </table>

                        </div>
                    </section>

                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>

    </div>
    <?php include 'fitur/js.php'; ?>
</body>

</html>