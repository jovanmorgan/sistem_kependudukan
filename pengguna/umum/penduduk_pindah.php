<!DOCTYPE html>
<html lang="en">

<?php include 'fitur/head.php'; ?>
<style>
    /* CSS untuk card dan tabel */
    .card {
        background-color: #ffffff;
        /* Warna latar belakang card */
        border-radius: 12px;
        /* Sudut melengkung pada card */
        padding: 20px;
        /* Padding di dalam card */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        /* Efek bayangan */
        margin: 20px auto;
        /* Margin otomatis untuk pusat */
        max-width: 90%;
        /* Maksimal lebar card */
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background-color: #007bff;
        /* Warna latar belakang header */
        color: white;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
        /* Warna latar belakang untuk baris genap */
    }

    .table tbody tr:hover {
        background-color: #e1f5fe;
        /* Warna latar belakang saat hover */
        transition: background-color 0.3s;
        /* Transisi saat hover */
    }

    .btn {
        background-color: #28a745;
        /* Warna tombol */
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        /* Transisi saat hover */
    }

    .btn:hover {
        background-color: #218838;
        /* Warna saat hover */
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
        /* Fokus tombol */
    }

    /* CSS untuk card pencarian */
    .search-card {
        background-color: #f8f9fa;
        /* Warna latar belakang card */
        border-radius: 12px;
        /* Sudut melengkung pada card */
        padding: 20px;
        /* Padding di dalam card */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        /* Efek bayangan */
        margin: 20px auto;
        /* Margin otomatis untuk pusat */
        max-width: 90%;
        /* Maksimal lebar card */
    }

    .input-group {
        width: 100%;
        /* Lebar input group penuh */
    }

    .input-group .form-control {
        border-radius: 5px 0 0 5px;
        /* Sudut melengkung pada input */
    }

    .input-group .btn {
        border-radius: 0 5px 5px 0;
        /* Sudut melengkung pada tombol */
    }
</style>

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

    <div id="load_data">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search-card">
                        <div class="card-body text-center">
                            <!-- Search Form -->
                            <form method="GET" action="">
                                <h5 class="mb-3">Cari Data</h5> <!-- Judul form pencarian -->
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Cari Data Kelurahan Oepura..."
                                        name="search"
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

        // Query untuk mendapatkan data penduduk_pindah dengan pencarian dan pagination
        $query = "SELECT pp.id_pindah, p.no_kk, p.nik, p.nama, p.tpt_lahir, p.tgl_lahir, p.jk, p.alamat, p.id_rt, p.agama, pp.id_penduduk,
                 rt.nama_rt, p.id_rw, rw.nama_rw, p.pendidikan, p.pekerjaan, p.status, pp.alasan, pp.tgl_pindah, pp.alamat_asal, pp.alamat_tujuan
          FROM penduduk_pindah pp
          JOIN penduduk p ON pp.id_penduduk = p.id_penduduk
          LEFT JOIN rt ON p.id_rt = rt.id_rt
          LEFT JOIN rw ON p.id_rw = rw.id_rw
          WHERE p.nama LIKE ? LIMIT ?, ?";

        $stmt = $koneksi->prepare($query);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("sii", $search_param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Hitung total halaman
        $total_query = "SELECT COUNT(*) as total FROM penduduk_pindah pp
                JOIN penduduk p ON pp.id_penduduk = p.id_penduduk
                WHERE p.nama LIKE ?";
        $stmt_total = $koneksi->prepare($total_query);
        $stmt_total->bind_param("s", $search_param);
        $stmt_total->execute();
        $total_result = $stmt_total->get_result();
        $total_row = $total_result->fetch_assoc();
        $total_pages = ceil($total_row['total'] / $limit);
        ?>

        <!-- Tabel Data penduduk_pindah -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <h3 class="text-center">Data Penduduk Pindah</h3> <!-- Judul card -->
                        <div class="card-body" style="overflow-x: hidden;">
                            <div style="overflow-x: auto;">
                                <?php if ($result->num_rows > 0): ?>
                                    <table class="table table-hover text-center mt-3">
                                        <thead>
                                            <tr>
                                                <th style="white-space: nowrap;">Nomor</th>
                                                <th style="white-space: nowrap;">NIK</th>
                                                <th style="white-space: nowrap;">Nama</th>
                                                <th style="white-space: nowrap;">Tempat Lahir</th>
                                                <th style="white-space: nowrap;">Tanggal Lahir</th>
                                                <th style="white-space: nowrap;">Jenis Kelamin</th>
                                                <th style="white-space: nowrap;">Status</th>
                                                <th style="white-space: nowrap;">Pekerjaan</th>
                                                <th style="white-space: nowrap;">Agama</th>
                                                <th style="white-space: nowrap;">Alamat Asal</th>
                                                <th style="white-space: nowrap;">Alamat Tujuan</th>
                                                <th style="white-space: nowrap;">Alasan</th>
                                                <th style="white-space: nowrap;">Tanggal Pindah</th>
                                                <th style="white-space: nowrap;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                            while ($row = $result->fetch_assoc()) :
                                            ?>
                                                <tr>
                                                    <td><?php echo $nomor++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['tpt_lahir']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['tgl_lahir']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['pekerjaan']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['alamat_asal']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['alamat_tujuan']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['alasan']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['tgl_pindah']); ?></td>
                                                    <td>
                                                        <form action="export/penduduk_pindah" method="GET"
                                                            style="display: inline-block;">
                                                            <input type="hidden" name="id_pindah"
                                                                value="<?php echo $row['id_pindah']; ?>">
                                                            <button type="submit" class="btn btn-primary btn-sm m-1">Cetak
                                                                PDF</button>
                                                        </form>
                                                    </td>
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
        <section class="section" style="position: relative; bottom: 150px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Pagination with icons -->
                            <nav aria-label="Pagxample" style="margin-top: 2.2rem;">
                                <ul class="pagination justify-content-center">
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


    <?php include 'fitur/footer.php'; ?>

    <div class="copyrights">
        <div class="container">
            <div class="footer-distributed">
                <div class="footer-left">
                    <p class="footer-company-name">Di buat Olleh Arnando
                </div>


            </div>
        </div><!-- end container -->
    </div><!-- end copyrights -->

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <?php include 'fitur/js.php'; ?>

</body>

</html>