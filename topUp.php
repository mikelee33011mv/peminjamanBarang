<?php
session_start();

include 'conn/koneksi.php';

// Ambil data permintaan top up
$query = "SELECT saldo.*, login.username
          FROM saldo 
          JOIN login ON saldo.id_login = login.id
          WHERE status = 'menunggu'
          ORDER BY tgal_topup DESC";
$result = mysqli_query($conn, $query);
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/topnav.php'; ?>

<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h2 class = "pt-4">Halaman top up saldo</h2>
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Kode Bayar</th>
                            <th>Bukti Transfer</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['username']; ?></td>
                            <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                            <td><?= strtoupper($row['metode_bayar']); ?></td>
                            <td><strong><?= $row['kode_bayar']; ?></strong></td>
                            <td>
                                <a href="bukti_tf/<?= $row['bkt_pembayaran']; ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($row['tgal_topup'])); ?></td>
                            <td>
                            <?php if($row['status'] != 'diterima'): ?>
                                <form action="konfir_top_up.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <input type="hidden" name="id_login" value="<?= $row['id_login']; ?>">
                                    <input type="hidden" name="nominal" value="<?= $row['nominal']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>Sudah Dikonfirmasi</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    </table>
                </div>
                
            </div>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
        