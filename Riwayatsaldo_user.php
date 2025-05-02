<?php
include 'conn/koneksi.php';
session_start();

// Cek user sudah login
if (!isset($_SESSION['id_login'])) {
    header("Location: login.php");
    exit;
}

$id_login = $_SESSION['id_login'];

// Jika ada permintaan hapus
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];

    // Cek apakah data memang milik user
    $cek = mysqli_query($conn, "SELECT * FROM riwayat_saldo WHERE id = $id_hapus AND id_login = $id_login");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "DELETE FROM riwayat_saldo WHERE id = $id_hapus");
        $_SESSION['success'] = "Riwayat berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus riwayat.";
    }

    header("Location: riwayatsaldo_user.php");
    exit;
}

// Ambil data riwayat saldo user
$query = "SELECT * FROM riwayat_saldo WHERE id_login = $id_login ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<?php include 'includes_user/header_user.php'; ?>
<?php include 'includes_user/navbar_user.php'; ?>

<div class="container py-5">
    <h3>Riwayat Saldo</h3>
    <hr>

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

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Tipe Transaksi</th>
                <th>Aksi</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            if ($row['tipe_transaksi'] == 'masuk') {
                                echo '<span class="badge bg-success">Masuk</span>';
                            } else {
                                echo '<span class="badge bg-danger">Keluar</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus riwayat ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">Belum ada riwayat transaksi saldo.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes_user/footer_user.php'; ?>
