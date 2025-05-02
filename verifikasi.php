<?php 
include 'koneksi.php'; 
include 'includes_admin/header_admin.php';
include 'includes_admin/navbar_admin.php';

$query = mysqli_query($conn, "SELECT p.*, b.nama_barang, u.nama_user 
                              FROM peminjaman p 
                              JOIN barang b ON p.id_barang = b.id_barang
                              JOIN user u ON p.id_user = u.id_user
                              WHERE p.status = 'menunggu'");
?>

<div class="container p-5">
    <h3 class="mb-4">Verifikasi Peminjaman</h3>

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <div class="card p-3 shadow-sm mb-4">
        <h5>Permintaan dari: <?= $row['nama_user'] ?></h5>
        <p><strong>Barang:</strong> <?= $row['nama_barang'] ?></p>
        <p><strong>Tanggal Pinjam:</strong> <?= $row['tanggal_peminjaman'] ?></p>
        <p><strong>Tanggal Kembali:</strong> <?= $row['tanggal_pengembalian'] ?></p>
        <a href="setujui_pinjam.php?id=<?= $row['id_peminjaman'] ?>&id_barang=<?= $row['id_barang'] ?>" class="btn btn-success w-100">Setujui Peminjaman</a>
    </div>
    <?php } ?>
</div>

<?php include 'includes_admin/footer_admin.php'; ?>
