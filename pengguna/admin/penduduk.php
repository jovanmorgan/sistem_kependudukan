<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>
<?php include 'fitur/nama_halaman.php'; ?>
<?php include 'fitur/nama_halaman_proses.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <?php include 'fitur/papan_halaman.php'; ?>

                    <div id="load_data">
                        <section class="section">
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
                                                    <button class="btn btn-outline-secondary"
                                                        type="submit">Cari</button>
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
                                p.agama, p.stts_perkawinan, 
                                p.pendidikan, p.pekerjaan, p.status, 
                                kk.no_kk, rt.rt, rt.nama_rt, rt.id_rt
                            FROM penduduk p 
                            JOIN kk ON p.no_kk = kk.no_kk 
                            JOIN rt ON p.id_rt = rt.id_rt 
                            WHERE p.nik LIKE ? OR p.nama LIKE ? OR kk.no_kk LIKE ? 
                            LIMIT ?, ?";
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "
                                SELECT COUNT(*) as total 
                                FROM penduduk p 
                                JOIN kk ON p.no_kk = kk.no_kk 
                                JOIN rt ON p.id_rt = rt.id_rt 
                                WHERE p.nik LIKE ? OR p.nama LIKE ? OR kk.no_kk LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("sss", $search_param, $search_param, $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data Penduduk -->
                        <section class="section">
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
                                                                <th>Agama</th>
                                                                <th>Status Perkawinan</th>
                                                                <th>Pendidikan</th>
                                                                <th>Pekerjaan</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
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
                                                                    <td><?php echo htmlspecialchars($row['rt']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['stts_perkawinan']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['pendidikan']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['pekerjaan']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm m-1 m-1"
                                                                            onclick="openEditModal('<?php echo $row['id_penduduk']; ?>', '<?php echo addslashes($row['no_kk']); ?>','<?php echo $row['nik']; ?>','<?php echo $row['nama']; ?>','<?php echo $row['tpt_lahir']; ?>','<?php echo $row['tgl_lahir']; ?>','<?php echo $row['jk']; ?>','<?php echo $row['alamat']; ?>','<?php echo $row['id_rt']; ?>','<?php echo $row['agama']; ?>','<?php echo $row['stts_perkawinan']; ?>','<?php echo $row['pendidikan']; ?>','<?php echo $row['pekerjaan']; ?>','<?php echo $row['status']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm m-1 m-1"
                                                                            onclick="hapus('<?php echo $row['id_penduduk']; ?>')">Hapus</button>
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
                        <section class="section">
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
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                                enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="no_kk" class="form-label">Kartu Keluarga</label>
                                    <select id="no_kk" name="no_kk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Kartu Keluarga</option>
                                        <?php
                                        $query_kk = "SELECT no_kk, nama_kep_kel FROM kk";
                                        $result_kk = mysqli_query($koneksi, $query_kk);
                                        while ($row_kk = mysqli_fetch_assoc($result_kk)) {
                                            echo '<option value="' . $row_kk['no_kk'] . '">' . $row_kk['nama_kep_kel'] . ' (' . $row_kk['no_kk'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" maxlength="16"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="nik" name="nik"
                                        maxlength="16" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="tpt_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="tpt_lahir" name="tpt_lahir" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                    <select id="jk" name="jk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="id_rt" class="form-label">RT</label>
                                    <select id="id_rt" name="id_rt" class="form-select" required>
                                        <option value="" disabled selected>Pilih RT</option>
                                        <?php
                                        $query_rt = "SELECT id_rt, nama_rt, rt FROM rt";
                                        $result_rt = mysqli_query($koneksi, $query_rt);
                                        while ($row_rt = mysqli_fetch_assoc($result_rt)) {
                                            echo '<option value="' . $row_rt['id_rt'] . '">' . $row_rt['nama_rt'] . ' (Rt = ' . $row_rt['rt'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <select id="agama" name="agama" class="form-select" required>
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="stts_perkawinan" class="form-label">Status Perkawinan</label>
                                    <select id="stts_perkawinan" name="stts_perkawinan" class="form-select" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pendidikan" class="form-label">Pendidikan</label>
                                    <select id="pendidikan" name="pendidikan" class="form-control" required>
                                        <option value="" disabled selected>Pilih Pendidikan</option>
                                        <option value="Tidak / Belum Sekolah">Tidak / Belum Sekolah</option>
                                        <option value="Tidak Tamat SD / Sederajat">Tidak Tamat SD / Sederajat</option>
                                        <option value="Tamat SD / Sederajat">Tamat SD / Sederajat</option>
                                        <option value="SLTP / Sederajat">SLTP / Sederajat</option>
                                        <option value="SLTA / Sederajat">SLTA / Sederajat</option>
                                        <option value="Diploma I / II">Diploma I / II</option>
                                        <option value="Akademi / Diploma III / S.Muda">Akademi / Diploma III / S.Muda
                                        </option>
                                        <option value="Diploma IV / Strata I">Diploma IV / Strata I</option>
                                        <option value="Strata II">Strata II</option>
                                        <option value="Strata III">Strata III</option>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                    <select id="pekerjaan" name="pekerjaan" class="form-control" required>
                                        <option value="" disabled selected>Pilih Pekerjaan</option>
                                        <option value="Belum / Tidak Bekerja">Belum / Tidak Bekerja</option>
                                        <option value="Mengurus Rumah Tangga">Mengurus Rumah Tangga</option>
                                        <option value="Pelajar / Mahasiswa">Pelajar / Mahasiswa</option>
                                        <option value="Pensiunan">Pensiunan</option>
                                        <option value="Pegawai Negeri Sipil">Pegawai Negeri Sipil</option>
                                        <option value="Tentara Nasional Indonesia">Tentara Nasional Indonesia</option>
                                        <option value="Kepolisian RI">Kepolisian RI</option>
                                        <option value="Perdagangan">Perdagangan</option>
                                        <option value="Petani / Pekebun">Petani / Pekebun</option>
                                        <option value="Peternak">Peternak</option>
                                        <option value="Nelayan / Perikanan">Nelayan / Perikanan</option>
                                        <option value="Industri">Industri</option>
                                        <option value="Konstruksi">Konstruksi</option>
                                        <option value="Transportasi">Transportasi</option>
                                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                                        <option value="Karyawan BUMN">Karyawan BUMN</option>
                                        <option value="Karyawan BUMD">Karyawan BUMD</option>
                                        <option value="Karyawan Honorer">Karyawan Honorer</option>
                                        <option value="Buruh Harian Lepas">Buruh Harian Lepas</option>
                                        <option value="Buruh Tani / Perkebunan">Buruh Tani / Perkebunan</option>
                                        <option value="Buruh Nelayan / Perikanan">Buruh Nelayan / Perikanan</option>
                                        <option value="Buruh Peternakan">Buruh Peternakan</option>
                                        <option value="Pembantu Rumah Tangga">Pembantu Rumah Tangga</option>
                                        <option value="Tukang Cukur">Tukang Cukur</option>
                                        <option value="Tukang Listrik">Tukang Listrik</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Keluarga Lainnya">Keluarga Lainnya</option>
                                    </select>
                                </div>

                                <!-- Wrapper for the submit button to align it to the right -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                                enctype="multipart/form-data">
                                <input type="hidden" id="edit_id" name="id_penduduk">

                                <div class="mb-3">
                                    <label for="edit_no_kk" class="form-label">Kartu Keluarga</label>
                                    <select id="edit_no_kk" name="no_kk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Kartu Keluarga</option>
                                        <?php
                                        $query_kk = "SELECT no_kk, nama_kep_kel FROM kk";
                                        $result_kk = mysqli_query($koneksi, $query_kk);
                                        while ($row_kk = mysqli_fetch_assoc($result_kk)) {
                                            echo '<option value="' . $row_kk['no_kk'] . '">' . $row_kk['nama_kep_kel'] . ' (' . $row_kk['no_kk'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_nik" class="form-label">NIK</label>
                                    <input type="text" id="edit_nik" name="nik" maxlength="16"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="16"
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="edit_nama" name="nama" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_tpt_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="edit_tpt_lahir" name="tpt_lahir" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="edit_tgl_lahir" name="tgl_lahir" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_jk" class="form-label">Jenis Kelamin</label>
                                    <select id="edit_jk" name="jk" class="form-select" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_alamat" class="form-label">Alamat</label>
                                    <textarea id="edit_alamat" name="alamat" class="form-control" rows="3"
                                        required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_id_rt" class="form-label">RT</label>
                                    <select id="edit_id_rt" name="id_rt" class="form-select" required>
                                        <option value="" disabled selected>Pilih RT</option>
                                        <?php
                                        $query_rt = "SELECT id_rt, nama_rt, rt FROM rt";
                                        $result_rt = mysqli_query($koneksi, $query_rt);
                                        while ($row_rt = mysqli_fetch_assoc($result_rt)) {
                                            echo '<option value="' . $row_rt['id_rt'] . '">' . $row_rt['nama_rt'] . ' (Rt = ' . $row_rt['rt'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_agama" class="form-label">Agama</label>
                                    <select id="edit_agama" name="agama" class="form-select" required>
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_stts_perkawinan" class="form-label">Status Perkawinan</label>
                                    <select id="edit_stts_perkawinan" name="stts_perkawinan" class="form-select"
                                        required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_pendidikan" class="form-label">Pendidikan</label>
                                    <input type="text" id="edit_pendidikan" name="pendidikan" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_pekerjaan" class="form-label">Pekerjaan</label>
                                    <input type="text" id="edit_pekerjaan" name="pekerjaan" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Status</label>
                                    <select id="edit_status" name="status" class="form-select" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Keluarga Lainnya">Keluarga Lainnya</option>
                                    </select>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>
    <script>
        function openEditModal(id_penduduk, no_kk, nik, nama, tpt_lahir, tgl_lahir, jk, alamat, rt, agama, stts_perkawinan,
            pendidikan, pekerjaan, status) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id_penduduk;
            document.getElementById('edit_no_kk').value = no_kk;
            document.getElementById('edit_nik').value = nik;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_tpt_lahir').value = tpt_lahir;
            document.getElementById('edit_tgl_lahir').value = tgl_lahir;
            document.getElementById('edit_jk').value = jk;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_id_rt').value = rt;
            document.getElementById('edit_agama').value = agama;
            document.getElementById('edit_stts_perkawinan').value = stts_perkawinan;
            document.getElementById('edit_pendidikan').value = pendidikan;
            document.getElementById('edit_pekerjaan').value = pekerjaan;
            document.getElementById('edit_status').value = status;
            editModal.show();
        }
    </script>

    <?php include 'fitur/js.php'; ?>
</body>

</html>