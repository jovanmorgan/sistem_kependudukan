<?php include 'nama_halaman.php'; ?>

<div class="page-header">
    <h3 class="fw-bold mb-3"><?= htmlspecialchars($page_title) ?> </h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="dashboard">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <!-- Kondisi untuk halaman selain Profile Sekolah, Galery, Berita, dan Sarana Prasarana -->
        <?php if ($page_title !== "Penduduk Masuk" && $page_title !== "Penduduk Pindah" && $page_title !== "Penduduk Tidak Mampu" && $page_title !== "Bantuan" && $page_title !== "Kelahiran" && $page_title !== "Kematian"): ?>
            <li class="nav-item">
                <a href="#">Sistem Kependudukan</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
        <?php endif; ?>

        <!-- Kondisi untuk halaman Profile Sekolah, Galery, Berita, dan Sarana Prasarana -->
        <?php if ($page_title === "Penduduk Masuk" || $page_title === "Penduduk Pindah" || $page_title === "Penduduk Tidak Mampu" || $page_title === "Bantuan" || $page_title === "Kelahiran" || $page_title === "Kematian"): ?>
            <li class="nav-item">
                <a href="#">Laporan Data</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a href="#"><?= htmlspecialchars($page_title) ?> </a>
        </li>
    </ul>

    <!-- Tampilkan bagian ini jika bukan di halaman Dashboard atau Profile Saya -->
    <?php if ($page_title !== "Dashboard" && $page_title !== "Profile Saya"): ?>
        <div class="ms-md-auto py-2 py-md-0">
            <?php include 'nama_halaman_proses.php'; ?>

            <!-- Tampilkan tombol Export jika halaman bukan Galery -->
            <?php if ($page_title !== "Penduduk Masuk" && $page_title !== "Penduduk Pindah" && $page_title !== "Penduduk Tidak Mampu" && $page_title !== "Kelahiran" && $page_title !== "Kematian" && $page_title !== "Bantuan"): ?>
                <a target="_blank" href="export/<?= htmlspecialchars($page_title_proses) ?>"
                    class="btn btn-label-info btn-round me-2">Export</a>
            <?php endif; ?>

            <!-- Hilangkan tombol tambah jika di halaman Pendaftar -->
            <?php if ($page_title !== "Penduduk Masuk"): ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>