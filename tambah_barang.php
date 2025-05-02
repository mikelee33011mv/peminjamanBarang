<?php
    include 'conn/koneksi.php';
?>

<?php include 'includes/header.php'?>
<?php include 'includes/topNav.php'?>
<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class = "pt-4">Tambah Barang Baru</h1>
            <div class="card mb-4 mt-5">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Barang
                    </div>
                    <div class="card-body">
                       
                        <table id="datatablesSimple" class = "table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kode Barang</th>
                                    <th>Kategori Barang</th>
                                    <th>Status</th>
                                    <th>Harga Barang</th>
                                    <th>Harga Sewa</th>
                                    <th>Harga VIP</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = mysqli_query($conn, "SELECT * FROM barang");
                                    while($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['kode_barang'] ?></td>
                                        <td><?= $row['kategori_brg'] ?></td>
                                        <td><?= $row['status_brg'] ?></td>
                                        <td><sup>Rp</sup><?= number_format($row['harga_barang']) ?></td>
                                        <td><sup>Rp</sup><?= number_format($row['harga_sewa']) ?></td>
                                        <td><sup>Rp</sup><?= number_format($row['harga_vip']) ?></td>
                                        <td>
                                            <?php if (!empty($row['foto']) && file_exists('uploads/' . $row['foto'])): ?>
                                                <img src="uploads/<?php echo $row['foto']; ?>" width="60">
                                            <?php else: ?>
                                                <span style="color:red;">Gambar tidak ada</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                        <button class="btn btn-sm btn-primary" onclick="editData(<?= $row['id'] ?>)" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="setDeleteId(<?= $row['id'] ?>)" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                        <!-- button tambah barang -->
                        <div class="mt-3">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                <i class="bi bi-plus-circle"></i> Tambah Barang
                            </button>
                        </div>
                        <!-- modal tambah barang -->
                        

                        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahModalLabel">Tambah Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="tambahForm" method="POST" action="proses/proses_barang.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                            <label for="namaBarangBaru" class="form-label">Nama Barang:</label>
                                            <input type="text" class="form-control" id="namaBarangBaru" name="nama_barang" required>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                            <label for="jenisBarang" class="form-label">Kategori Barang:</label>
                                            <select name="kategori_barang" id="" class = "form-select">
                                                <option value="">--pilih barang--</option>
                                                <option value="Elektronik">Elektronik</option>
                                                <option value="Buku">Buku</option>
                                                <option value="Perlengkapan">Perlengkapan</option>
                                                <option value="Pakaian">Pakaian</option>
                                                <option value="Alat Tulis">Alat Tulis</option>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                            <label for="hargaBarang" class="form-label">Harga Barang:</label>
                                            <input type="number" class="form-control" id="hargaBarang" name="harga_barang" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                            <label for="hargaSewa" class="form-label">Harga Sewa:</label>
                                            <input type="number" class="form-control" id="hargaSewa" name="harga_sewa" required>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                            <label for="hargaVip" class="form-label">Harga VIP:</label>
                                            <input type="number" class="form-control" id="hargaVip" name="harga_vip" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label for="hargaSewa" class="form-label">Gambar:</label>
                                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Tambah Barang</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                            <!-- tambah barang -->

                        <!-- edit barang -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="formEdit" class="modal-content" action="aksi/edit_barang.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Data Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="editId" name="id">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="namaBarangEdit" class="form-label">Nama Barang:</label>
                                                <input type="text" class="form-control" id="namaBarangEdit" name="nama_barang" required>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="kategoriBarang" class="form-label">Kategori Barang:</label>
                                                <select name="kategori_barang" id="kategoriBarangEdit" class="form-select">
                                                    <option value="">--pilih barang--</option>
                                                    <option value="Elektronik">Elektronik</option>
                                                    <option value="Buku">Buku</option>
                                                    <option value="Perlengkapan">Perlengkapan</option>
                                                    <option value="Pakaian">Pakaian</option>
                                                    <option value="Alat Tulis">Alat Tulis</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="hargaBarangEdit" class="form-label">Harga Barang:</label>
                                                <input type="number" class="form-control" id="hargaBarangEdit" name="harga_barang" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="hargaSewaEdit" class="form-label">Harga Sewa:</label>
                                                <input type="number" class="form-control" id="hargaSewaEdit" name="harga_sewa" required>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="hargaVipEdit" class="form-label">Harga VIP:</label>
                                                <input type="number" class="form-control" id="hargaVipEdit" name="harga_vip" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label for="gambarLama" class="form-label">Gambar Baru (kosongkan jika tidak ingin diubah):</label>
                                            <input type="file" class="form-control" id="gambarEdit" name="gambar_baru">
                                            <small class="form-text text-muted">Pilih gambar baru untuk mengganti gambar yang ada.</small>
                                            <input type="hidden" name="gambar_lama" id="gambarLama">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- edit barang -->

                        <!-- hapus barang -->
                        <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah kamu yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" id="deleteId">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger" onclick="deleteData()">Ya, Hapus</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- hapus barang -->

                        
                    </div>
                </div>
            </div>
        </main>
        
        <!-- javascript untuk edit barang -->
        <script>
            function editData(id) {
    console.log("ID yang dikirim:", id);

    document.getElementById('editId').value = id;

    fetch(`get_barang.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            console.log("Data yang diterima:", data);

            const namaBarangInput = data['nama_barang'];
            const kategoriBarangSelect = data['kategori_brg'];
            const hargaBarangInput = data['harga_barang'];
            const hargaSewaInput = data['harga_sewa'];
            const hargaVipInput = data['harga_vip'];
            const gambarLamaInput = data['foto'];


            document.getElementById('namaBarangEdit').value = namaBarangInput;
            document.getElementById('kategoriBarangEdit').value = kategoriBarangSelect;
            document.getElementById('hargaBarangEdit').value = hargaBarangInput;
            document.getElementById('hargaSewaEdit').value = hargaSewaInput;
            document.getElementById('hargaVipEdit').value = hargaVipInput;
            document.getElementById('gambarLama').value = gambarLamaInput;


            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Terjadi kesalahan...');
        });
}
        </script>

        <!-- javascript untuk edit barang -->

        <!-- javascript hapus barang -->
        <script>
            function setDeleteId(id) {
                document.getElementById('deleteId').value = id;
            }

            function deleteData() {
            const id = document.getElementById('deleteId').value;

            
            fetch('aksi/hapus_barang.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.text())
            .then(data => {
                alert('Barang berhasil dihapus!');
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('hapusModal'));
                modal.hide();

                location.reload();
            })
            .catch(error => {
                alert('Terjadi kesalahan saat menghapus data.');
                console.error(error);
            });
        }
        </script>

            
        <?php
        include 'includes/footer.php';
        ?>