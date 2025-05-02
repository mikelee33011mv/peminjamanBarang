<?php
include 'conn/koneksi.php';
    session_start();
    $id_login = $_SESSION['id_login'];

    $query = "SELECT p.*, b.nama_barang 
    FROM peminjaman p
    JOIN barang b ON p.id_barang = b.id
    WHERE p.id_login = $id_login";
$result = mysqli_query($conn, $query);
?>

<?php
include 'includes_user/header_user.php';
?>
<?php
include 'includes_user/navbar_user.php';
?>

<!-- content -->
 <div class="container py-5">

 <?php
$query_tolak = "SELECT COUNT(*) as total_ditolak 
                FROM peminjaman 
                WHERE id_login = $id_login AND ket = 'Ditolak'";
$result_tolak = mysqli_query($conn, $query_tolak);
$data_tolak = mysqli_fetch_assoc($result_tolak);


$query_tolak = "SELECT COUNT(*) as total_ditolak 
                FROM peminjaman 
                WHERE id_login = $id_login AND ket = 'Ditolak'";
$result_tolak = mysqli_query($conn, $query_tolak);
$data_tolak = mysqli_fetch_assoc($result_tolak);

// Cek apakah user punya denda
$query_denda = "SELECT SUM(denda) as total_denda 
                FROM peminjaman 
                WHERE id_login = $id_login AND denda > 0";
$result_denda = mysqli_query($conn, $query_denda);
$data_denda = mysqli_fetch_assoc($result_denda);

if ($data_denda['total_denda'] > 0) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ⚠️ Anda memiliki denda sebesar <strong>Rp ' . number_format($data_denda['total_denda'], 0, ',', '.') . '</strong> dari peminjaman sebelumnya. Silakan selesaikan pembayaran denda Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}


if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $query_hapus = "DELETE FROM peminjaman WHERE id = $id_hapus AND id_login = $id_login";
    mysqli_query($conn, $query_hapus);

    header("Location: riwayatPinjam_user.php");
    exit;
}

if (isset($_SESSION['penolakan'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
        . $_SESSION['penolakan'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
    unset($_SESSION['penolakan']);
}
?>
<!--  fggergtr-->
        <!--menghitung denda  -->
        <?php
        $query_denda = "SELECT SUM(denda) AS total_denda FROM peminjaman WHERE id_login = $id_login AND denda > 0";
        $result_denda = mysqli_query($conn, $query_denda);
        $data_denda = mysqli_fetch_assoc($result_denda);
        $total_denda = $data_denda['total_denda'] ?? 0;

        $query_saldo = "SELECT saldo FROM login WHERE id = $id_login";
        $result_saldo = mysqli_query($conn, $query_saldo);
        $data_saldo = mysqli_fetch_assoc($result_saldo);
        $saldo = $data_saldo['saldo'] ?? 0;

        if ($total_denda > 0) {
            echo '<div class="alert alert-warning d-flex justify-content-between align-items-center">
                    ⚠️ Anda memiliki denda sebesar <strong>Rp ' . number_format($total_denda, 0, ',', '.') . '</strong>
                    <form method="POST" action="halaman_bayar.php">
                        <button type="submit" name="bayar_denda" class="btn btn-sm btn-primary">Bayar Sekarang</button>
                    </form>
                  </div>';
        }
        ?>

        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }

        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>


        <table class="table">
            <thead>
                <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= date('d M Y', strtotime($row['tgl_peminjaman'])) ?></td>
                <td><?= date('d M Y', strtotime($row['tgal_kembali'])) ?></td>
                <td>
                    <?php if ($row['ket'] == 'menunggu') { ?>
                        <span class="badge bg-secondary">Menunggu</span>
                    <?php } elseif ($row['ket'] == 'Disetujui') { ?>
                        <span class="badge bg-warning">Dipinjam</span>
                    <?php } elseif ($row['ket'] == 'Ditolak') { ?>
                        <span class="badge bg-danger">Ditolak</span>
                    <?php } else { ?>
                        <span class="badge bg-success">Dikembalikan</span>
                    <?php } ?>
                </td>
                <td>
                    <?php 
                    if ($row['denda'] > 0) {
                        echo 'Rp ' . number_format($row['denda'], 0, ',', '.');
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td>
                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">Hapus</a>
                </td>
                </tr>
                <?php } ?>
                


            </tbody>
        </table>

        <button class="btn btn-success"><a href="Riwayatsaldo_user.php" class="text-decoration-none text-white">Lihat Riwayat Saldo</a></button>

<!-- content -->
<!-- modal -->
        
        <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Detail Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Barang:</strong> Proyektor Epson</p>
                <p><strong>Tanggal Pinjam:</strong> 12 Apr 2025</p>
                <p><strong>Tanggal Kembali:</strong> 15 Apr 2025</p>
                <p><strong>Status:</strong> Belum Dikembalikan</p>
                <p><strong>Catatan:</strong> Barang dalam kondisi baik</p>
            </div>
            </div>
        </div>
        </div>

<!-- modal -->


<?php
include 'includes_user/footer_user.php';
?>