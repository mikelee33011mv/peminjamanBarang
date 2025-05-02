<?php
include 'conn/koneksi.php';
    session_start();

    if(!isset($_SESSION['log'])) {
        header('location: login.php');
        exit;
    }

    $timeout = 9000;

    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();
        header("location:login.php?expired=true");
    }

    $_SESSION['last_activity'] = time();

    $query = "SELECT p.id AS id_pinjam, p.ket, p.tgl_peminjaman, p.tgal_kembali, p.total, 
                 u.username AS nama_user, b.nama_barang 
          FROM peminjaman p
          JOIN login u ON p.id_login = u.id
          JOIN barang b ON p.id_barang = b.id";
        $result = mysqli_query($conn, $query);

?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/topnav.php'; ?>

<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 custom-title">Daftar Peminjaman</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"  style="font-family: 'Montserrat', sans-serif; font-weight: 700;"></i>
                        Detail Peminjaman
                    </div>
                    <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Total Bayar</th>
                                <th>Diambil?</th>
                                <th>Konfirmasi Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Jika ada data yang ditemukan, tampilkan
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                if($row['ket']!=='menunggu') {
                                    continue;
                                }
                                $idModal = "konfirmasiModal" . $row['id_pinjam']; // ID unik untuk modal
                            
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['nama_user'] . "</td>";
                                echo "<td>" . $row['nama_barang'] . "</td>";
                                echo "<td><span class='badge bg-info text-dark'>" . $row['ket'] . "</span></td>";
                                echo "<td>" . $row['tgl_peminjaman'] . "</td>";
                                echo "<td>" . $row['tgal_kembali'] . "</td>";
                                echo "<td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>";
                                echo "<td><span class='badge bg-warning text-dark'>" . ($row['ket'] == 1 ? 'Sudah Diambil' : 'Belum Diambil') . "</span></td>";
                                echo "<td>
                                        <div class='d-flex align-items-center gap-2'>
                                            <span class='badge bg-secondary'>" . ($row['ket'] == 'Menunggu Konfirmasi' ? 'menunggu' : 'Dikonfirmasi') . "</span>
                                            <button class='btn btn-sm btn-outline-primary' data-bs-toggle='modal' data-bs-target='#$idModal'>Konfirmasi</button>
                                        </div>
                                      </td>";
                                echo "</tr>";
                            
                                // Modalnya ditaruh dalam loop juga
                                echo "
                                <div class='modal fade' id='$idModal' tabindex='-1' aria-labelledby='{$idModal}Label' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header bg-primary text-white'>
                                                <h5 class='modal-title' id='{$idModal}Label'>Konfirmasi Peminjaman</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Tutup'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <p>Apakah Anda ingin menyetujui peminjaman barang <strong>{$row['nama_barang']}</strong> oleh <strong>{$row['nama_user']}</strong>?</p>
                            
                                                <form action='setuju_pinjam.php' method='POST' class='d-inline'>
                                                    <input type='hidden' name='id_peminjaman' value='{$row['id_pinjam']}'>
                                                    <button type='submit' class='btn btn-success'>Setujui</button>
                                                </form>
                            
                                                <form action='tolak_pinjam.php' method='POST' class='d-inline'>
                                                    <input type='hidden' name='id_peminjaman' value='{$row['id_pinjam']}'>
                                                    <button type='submit' class='btn btn-danger'>Tolak</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ";
                            }
                            
                           ?>

                        </tbody>
                    </table>

                    </div>
                    </div>


                    <!-- modal awal -->
                    <!-- Modal -->
                    <!-- Modal -->

                        <!-- modal konfirmasi awal -->
                <!-- modal akhir -->
            </div>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
        