<?php
session_start();
?>
<?php
include 'includes_user/header_user.php';

?>

<style>
.animate-zoom {
  transform: scale(0.7);
  transition: transform 0.3s ease-in-out;
}

.modal.fade.show .modal-dialog.animate-zoom {
  transform: scale(1);
}
</style>
<?php
include 'includes_user/navbar_user.php';
?>

<!-- content -->
        <div class="container py-5">
        <h2 class="fw-bold text-center mb-5">📦 Daftar Barang Tersedia</h2>


        <?php if (isset($_GET['error']) && $_GET['error'] == 'saldo_kurang'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Saldo tidak mencukupi!</strong> Silakan isi saldo Anda terlebih dahulu sebelum meminjam.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <div class="row g-3">
            <!-- Card Barang -->
            <?php
            include 'conn/koneksi.php';

            $query = mysqli_query($conn, "SELECT * FROM barang WHERE status_brg = 'tersedia'");
            if (!$query) {
                die("Error saat menjalankan query: " . mysqli_error($conn));
            }

            $id_login = $_SESSION['id_login'] ?? null;
            $isAnggota = false;

            if ($id_login) {
                $cekAnggota = mysqli_query($conn, "SELECT * FROM anggota WHERE id_login = '$id_login'");
                $isAnggota = mysqli_num_rows($cekAnggota) > 0;
            }


            while ($row = mysqli_fetch_assoc($query)) {
                
                ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="uploads/<?php echo $row['foto']; ?>" class="card-img-top" style="width: 100%; height: 150px; object-fit: cover;" alt="<?php echo $row['nama_barang']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nama_barang']; ?></h5>
                            <?php
                            $harga_asli = $row['harga_sewa'];
                            if ($isAnggota) {
                                $harga_diskon = $harga_asli * 0.8;
                                echo "Harga Sewa: <strong><span class='text-decoration-line-through text-danger'>Rp" . number_format($harga_asli) . "</span> 
                                <span class='text-success'>Rp" . number_format($harga_diskon) . "/hari</span></strong>";
                            } else {
                                echo "Harga Sewa: <strong>Rp" . number_format($harga_asli) . "/hari</strong>";
                            }
                            ?>
                            <p class="card-text">Stok: <?php echo $row['status_brg'] == 'tersedia' ? 'tersedia' : 'dipinjam'; ?></p>
                            <div class="d-flex gap-2">
                                <?php if ($row['status_brg'] == 'tersedia'): ?>
                                    <form action="konfirmasi_pinjam.php" method="POST" class="w-100">
                                        <input type="hidden" name="id_barang" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="harga_sewa" value="<?php echo $isAnggota ? $harga_diskon : $harga_asli; ?>">
                                        <input type="hidden" name="tanggal_ajuan" value="<?php echo date('Y-m-d'); ?>">
                                        <input type="hidden" name="tanggal_pinjam" value="<?php echo date('Y-m-d'); ?>">
                                        <input type="hidden" name="tgal_kembali" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                        <button type="submit" class="btn btn-primary w-100">Pinjam</button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled>Tidak Tersedia</button>
                                <?php endif; ?>
                                
                                <button class="btn btn-outline-secondary w-100 detail-btn"
                                        data-nama="<?php echo $row['nama_barang']; ?>"
                                        data-harga="<?php echo $isAnggota ? $harga_diskon : $harga_asli; ?>"
                                        data-deskripsi="Deskripsi barang ini..."
                                        data-gambar="uploads/<?php echo $row['foto']; ?>"
                                        data-stok="<?php echo $row['status_brg'] == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia'; ?>">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }

            mysqli_free_result($query);
            mysqli_close($conn);
            ?>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailBarang" tabindex="-1" aria-labelledby="detailBarangLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered animate-zoom">
                <div class="modal-content shadow-lg">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailBarangLabel">Detail Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <img id="barangGambarDetail" src="" class="img-fluid rounded mb-3" alt="">
                        <p><strong>Nama Barang:</strong> <span id="barangNamaDetail"></span></p>
                        <p><strong>Harga Sewa:</strong> <span id="barangHargaDetail"></span></p>
                        <p><strong>Deskripsi:</strong> <span id="barangDeskripsiDetail"></span></p>
                        <p><strong>Stok Tersedia:</strong> <span id="barangStokDetail"></span></p>
                    </div>
                </div>
            </div>
        </div>


<!-- content -->

<!-- java script -->
 <script>
const detailButtons = document.querySelectorAll('.detail-btn');
const detailModal = document.getElementById('detailBarang');

detailButtons.forEach(button => {
    button.addEventListener('click', function() {
        const nama = this.dataset.nama;
        const harga = this.dataset.harga;
        const deskripsi = this.dataset.deskripsi;
        const gambar = this.dataset.gambar;
        const stok = this.dataset.stok;

        detailModal.querySelector('.modal-title').textContent = `Detail Barang - ${nama}`;
        detailModal.querySelector('#barangNamaDetail').textContent = nama;
        detailModal.querySelector('#barangHargaDetail').textContent = `Rp${harga}/hari`;
        detailModal.querySelector('#barangDeskripsiDetail').textContent = deskripsi;
        detailModal.querySelector('#barangGambarDetail').src = gambar;
        detailModal.querySelector('#barangGambarDetail').alt = nama;
        detailModal.querySelector('#barangStokDetail').textContent = stok;

        const bsModal = new bootstrap.Modal(detailModal);
        bsModal.show();

        detailModal.addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
});


    });
});

</script>
<!-- java script -->

<?php
include 'includes_user/footer_user.php';
?>