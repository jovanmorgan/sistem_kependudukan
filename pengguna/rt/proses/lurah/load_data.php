   <?php
    include '../../../../keamanan/koneksi.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Query untuk mendapatkan data lurah dengan pencarian dan pagination
    $query = "SELECT * FROM lurah WHERE nama_lurah LIKE ? LIMIT ?, ?";
    $stmt = $koneksi->prepare($query);
    $search_param = '%' . $search . '%';
    $stmt->bind_param("sii", $search_param, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hitung total halaman
    $total_query = "SELECT COUNT(*) as total FROM lurah WHERE nama_lurah LIKE ?";
    $stmt_total = $koneksi->prepare($total_query);
    $stmt_total->bind_param("s", $search_param);
    $stmt_total->execute();
    $total_result = $stmt_total->get_result();
    $total_row = $total_result->fetch_assoc();
    $total_pages = ceil($total_row['total'] / $limit);
    ?>

   <!-- Tabel Data lurah -->
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
                                           <th style="white-space: nowrap;">Nomor</th>
                                           <th style="white-space: nowrap;">Nama Lurah</th>
                                           <th style="white-space: nowrap;">Username</th>
                                           <th style="white-space: nowrap;">Password</th>
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
                                               <td><?php echo htmlspecialchars($row['nama_lurah']); ?></td>
                                               <td><?php echo htmlspecialchars($row['username']); ?></td>
                                               <td><?php echo htmlspecialchars($row['password']); ?></td>
                                               <td>
                                                   <button class="btn btn-warning btn-sm m-1"
                                                       onclick="openEditModal('<?php echo $row['id_lurah']; ?>', '<?php echo $row['nama_lurah']; ?>', '<?php echo addslashes($row['username']); ?>', '<?php echo addslashes($row['password']); ?>')">Edit</button>
                                                   <button class="btn btn-danger btn-sm m-1"
                                                       onclick="hapus('<?php echo $row['id_lurah']; ?>')">Hapus</button>
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