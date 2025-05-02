<?php include 'includes/header.php'; ?>
<?php include 'includes/topnav.php'; ?>

<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 custom-title">Daftar Pengembalian</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-undo-alt me-1"></i>
                        Pengembalian Barang
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                            <th>Nama User</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Kondisi</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php
                                include 'conn/koneksi.php'; // pastikan sesuai

                                $query = "SELECT p.id AS id_pinjam, p.ket, p.tgl_peminjaman, p.tgal_kembali, p.kondisi, p.denda, 
                                                u.username AS nama_user, b.nama_barang 
                                        FROM peminjaman p
                                        JOIN login u ON p.id_login = u.id
                                        JOIN barang b ON p.id_barang = b.id
                                        WHERE p.ket = 'Disetujui'";
                                        
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $tgl_kembali = new DateTime($row['tgal_kembali']);
                                    $today = new DateTime();
                                    $hari_terlambat = $today > $tgl_kembali ? $tgl_kembali->diff($today)->days : 0;
                                    $denda = $hari_terlambat * 2000;
                                    $status = $hari_terlambat > 0 ? "<span class='badge bg-danger'>Terlambat</span>" : "<span class='badge bg-success'>Tepat Waktu</span>";

                                    echo "<tr>
                                            <td>{$row['nama_user']}</td>
                                            <td>{$row['nama_barang']}</td>
                                            <td>{$row['tgl_peminjaman']}</td>
                                            <td>{$row['tgal_kembali']}</td>
                                            <td>$status</td>
                                            <td>{$row['kondisi']}</td>
                                            <td>" . ($denda > 0 ? "Rp$denda" : "-") . "</td>
                                            <td>
                                                <button class='btn btn-sm btn-primary' 
                                                        data-bs-toggle='modal' 
                                                        data-bs-target='#detailModal'
                                                        data-id='{$row['id_pinjam']}'
                                                        data-nama='{$row['nama_user']}'
                                                        data-barang='{$row['nama_barang']}'
                                                        data-tglpinjam='{$row['tgl_peminjaman']}'
                                                        data-tglkembali='{$row['tgal_kembali']}'
                                                        data-denda='$denda'>
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>";
                                }
                                ?>

                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                    $('.btn-primary').on('click', function () {
                        var idPeminjaman = $(this).data('id');
                        var namaUser = $(this).data('nama');
                        var namaBarang = $(this).data('barang');
                        var tglPinjam = $(this).data('tglpinjam');
                        var tglKembali = $(this).data('tglkembali');
                        var denda = $(this).data('denda');

                        $('#detailModal input[name="id_peminjaman"]').val(idPeminjaman);
                        var modalBodyHtml = `
                            <p><strong>Nama User:</strong> ${namaUser}</p>
                            <p><strong>Nama Barang:</strong> ${namaBarang}</p>
                            <p><strong>Tanggal Pinjam:</strong> ${tglPinjam}</p>
                            <p><strong>Tanggal Kembali:</strong> ${tglKembali}</p>
                            <div class="mb-3">
                                <label for="kondisi" class="form-label">Kondisi Barang Saat Dikembalikan</label>
                                <select class="form-control" name="kondisi" required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                    <option value="Hilang">Hilang</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="denda" class="form-label">Denda (Rp)</label>
                                <input type="number" class="form-control" name="denda" min="0" value="${denda}">
                            </div>
                        `;

                        // Inject modal content
                        $('#detailModal .modal-body').html(modalBodyHtml);
                    });
                });


                </script>
            <!-- Modal Detail -->
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <form action="proses/proses_pengembalian.php" method="post">
                        <input type="hidden" name="id_peminjaman">
                        <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                        <!-- Akan diisi lewat JavaScript -->
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Konfirmasi Pengembalian</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>



                <!-- modal akhir -->
            </div>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
        