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
        <h1 style="text-align:center; margin: 30px 0;">Data Penduduk</h1>
        <div id="load_data">
            <section class="section"
                style="width: 100%; align-items: center; justify-content: center; display: flex; position: relative; bottom: 110px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <!-- Search Form -->
                                <form method="GET" action="">
                                    <div class="input-group mt-3">
                                        <input type="text" class="form-control"
                                            placeholder="Cari Data Kelurahan Oepura..." name="search"
                                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            include '../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data penduduk dengan pencarian dan pagination
            $query = "
                            SELECT p.id_penduduk, p.nik, p.nama, p.tpt_lahir, p.tgl_lahir, p.jk, p.alamat, 
                                p.kel_des, p.kec, p.kewarganegaraan, p.agama, p.stts_perkawinan, 
                                p.pendidikan, p.pekerjaan, p.status, 
                                kk.no_kk, rw.nama_rw, rw.id_rw, rt.nama_rt, rt.id_rt
                            FROM penduduk p 
                            JOIN kk ON p.no_kk = kk.no_kk 
                            JOIN rw ON p.id_rw = rw.id_rw 
                            JOIN rt ON p.id_rt = rt.id_rt 
                            WHERE p.nik LIKE ? OR p.nama LIKE ? 
                            LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "
                                SELECT COUNT(*) as total 
                                FROM penduduk p 
                                JOIN kk ON p.no_kk = kk.no_kk 
                                JOIN rw ON p.id_rw = rw.id_rw 
                                JOIN rt ON p.id_rt = rt.id_rt 
                                WHERE p.nik LIKE ? OR p.nama LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("ss", $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>

            <!-- Tabel Data Penduduk -->
            <section class="section" style="position: relative; bottom: 290px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="overflow-x: hidden;">
                                <div style="overflow-x: auto;">
                                    <?php if ($result->num_rows > 0): ?>
                                        <table class="table table-hover text-center mt-3"
                                            style="border-collapse: separate; border-spacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>Nomor</th>
                                                    <th>Nomor KK</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Tempat Lahir</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Alamat</th>
                                                    <th>RT</th>
                                                    <th>RW</th>
                                                    <th>Kel/Desa</th>
                                                    <th>Kecamatan</th>
                                                    <th>Kewarganegaraan</th>
                                                    <th>Agama</th>
                                                    <th>Status Perkawinan</th>
                                                    <th>Pendidikan</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                while ($row = $result->fetch_assoc()):
                                                ?>
                                                    <tr>
                                                        <td><?php echo $nomor++; ?></td>
                                                        <td><?php echo htmlspecialchars($row['no_kk']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['tpt_lahir']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['tgl_lahir']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama_rt']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama_rw']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['kel_des']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['kec']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['kewarganegaraan']); ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['stts_perkawinan']); ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($row['pendidikan']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['pekerjaan']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p class="text-center mt-4">Data tidak ditemukan.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Pagination Section -->
            <section class="section" style="position: relative; bottom: 290px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <!-- Pagination with icons -->
                                <nav aria-label="Pagxample" style="margin-top: 2.2rem;">
                                    <ul class="pagtion justify-content-center">
                                        <li class="page-item <?php if ($page <= 1) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page > 1) {
                                                                            echo "?page=" . ($page - 1) . "&search=" . $search;
                                                                        } ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                            <li class="page-item <?php if ($i == $page) {
                                                                        echo 'active';
                                                                    } ?>">
                                                <a class="page-link"
                                                    href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li class="page-item <?php if ($page >= $total_pages) {
                                                                    echo 'disabled';
                                                                } ?>">
                                            <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                            echo "?page=" . ($page + 1) . "&search=" . $search;
                                                                        } ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                <!-- End Pagination with icons -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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