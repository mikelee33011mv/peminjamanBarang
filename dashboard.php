<?php
session_start();

// Cek login
if (!isset($_SESSION['log'])) {
    header('location: login.php');
    exit;
}

$timeout = 9000;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: login.php?expired=true");
    exit;
}

$_SESSION['last_activity'] = time();
?>

<?php
    include 'conn/koneksi.php';
    $query_total_barang = "SELECT COUNT(*) as total_barang FROM barang";
$result_total_barang = $conn->query($query_total_barang);
$row_total_barang = $result_total_barang->fetch_assoc();
$total_barang = $row_total_barang['total_barang'];

// Query untuk mendapatkan jumlah barang tersedia
$query_barang_tersedia = "SELECT COUNT(*) as barang_tersedia FROM barang WHERE status_brg = 'tersedia'";
$result_barang_tersedia = $conn->query($query_barang_tersedia);
$row_barang_tersedia = $result_barang_tersedia->fetch_assoc();
$barang_tersedia = $row_barang_tersedia['barang_tersedia'];

// Query untuk mendapatkan jumlah barang dipinjam
$query_barang_dipinjam = "SELECT COUNT(*) as barang_dipinjam FROM barang WHERE status_brg = 'dipinjam'";
$result_barang_dipinjam = $conn->query($query_barang_dipinjam);
$row_barang_dipinjam = $result_barang_dipinjam->fetch_assoc();
$barang_dipinjam = $row_barang_dipinjam['barang_dipinjam'];

// Query untuk mendapatkan jumlah pengguna dengan role 'user'
$query_jumlah_pengguna = "SELECT COUNT(*) as jumlah_pengguna FROM login WHERE roles = 'user'";
$result_jumlah_pengguna = $conn->query($query_jumlah_pengguna);
$row_jumlah_pengguna = $result_jumlah_pengguna->fetch_assoc();
$jumlah_pengguna = $row_jumlah_pengguna['jumlah_pengguna'];
?>
<style>
    .dashboard-card {
      position: relative;
      color: white;
      border-radius: 8px;
      padding: 20px;
      min-height: 100px;
      overflow: hidden;
    }
    .dashboard-card .icon-bg {
      position: absolute;
      bottom: 10px;
      right: 10px;
      font-size: 60px;
      opacity: 0.2;
    }
    .dashboard-card h2 {
      font-size: 36px;
      margin: 0;
    }
    .dashboard-card p {
      margin: 0;
      font-size: 16px;
    }
  </style>


<?php include 'includes/header.php'; ?>
<?php include 'includes/topnav.php'; ?>

<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="container my-5">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="dashboard-card bg-success">
                                <h2><?php echo $total_barang; ?></h2>
                                <p>Jumlah Barang</p>
                                <i class="bi bi-box-seam icon-bg"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card bg-warning">
                                <h2><?php echo $barang_tersedia; ?></h2>
                                <p>Barang Tersedia</p>
                                <i class="bi bi-check-circle icon-bg"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card bg-danger">
                                <h2><?php echo $barang_dipinjam; ?></h2>
                                <p>Barang Dipinjam</p>
                                <i class="bi bi-arrow-left-right icon-bg"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card bg-info">
                                <h2><?php echo $jumlah_pengguna; ?></h2>
                                <p>Jumlah Pengguna</p>
                                <i class="bi bi-people icon-bg"></i>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Barang
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class = "table-responsive table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Deskripsi</th>
                                    <th>Jumalh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
        