<?php
include 'conn/koneksi.php';

$query = mysqli_query($conn, "SELECT a.*, l.username 
    FROM anggota a 
    JOIN login l ON a.id_login = l.id");

$no = 1;
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/topnav.php'; ?>

<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h2 class = "pt-4">User</h2>

                <div class="table-responsive shadow-sm">
                <table class="table table-bordered table-striped">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Agama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['tempat_lahir'] . ', ' . date('d M Y', strtotime($row['tanggal_lahir']))) ?></td>
                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                <td><?= htmlspecialchars($row['agama']) ?></td>
                                <td><?= htmlspecialchars($row['j_kel']) ?></td>
                                <td><?= date('d M Y', strtotime($row['tgl_aktif_agt'])) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
               
                
            </div>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
        