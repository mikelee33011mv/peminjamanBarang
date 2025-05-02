<?php
   include 'conn/koneksi.php';
   session_start();

   if(isset($_SESSION['username'])) {
      $username = $_SESSION['username'];
   } else {
      $username = 'pengguna';
   }

   if(!isset($_SESSION['id_login'])) {
      die('anda belum melakukan login');
   }

   $id_user = $_SESSION['id_login'];
   $query = mysqli_query($conn, "SELECT saldo FROM login where id = $id_user");
   $data = mysqli_fetch_assoc($query);
   $total = $data['saldo'];
   
$id_login = $_SESSION['id_login'];

$query = mysqli_query($conn, "SELECT is_member FROM login WHERE id = '$id_login'");
$data = mysqli_fetch_assoc($query);
$is_member = $data['is_member'];


?>

<!-- header -->
 <?php
    include 'includes_user/header_user.php';
 ?>
<!-- header -->
 <!-- navbar -->
 <?php
    include 'includes_user/navbar_user.php'
 ?>
 <!-- navbar -->
    
 <!-- content -->
      <div class="container py-5">
         <!-- Sambutan Personal -->
         <h2 class="fw-bold">Halo, <span class="text-primary"><?php echo htmlspecialchars($username)?></span>!</h2>
         <p class = "mb-3">Saldo anda saat ini <sup>Rp</sup><strong><?= number_format($total, 0, ',', '.');?></strong></p>
         <p class="fs-5 text-secondary">Selamat datang di sistem peminjaman barang kampus.</p>

         <!-- Penjelasan Singkat -->
         <div class="alert alert-light shadow-sm mt-4">
            <h5 class="fw-bold">Apa itu Peminjaman Barang?</h5>
            <p class="mb-0 text-muted">
                  Sistem ini memudahkan mahasiswa untuk meminjam alat penunjang kegiatan kampus seperti proyektor, kabel HDMI, speaker, dan lainnya.
                  Cukup pilih barang, isi form peminjaman, lalu ambil barang sesuai jadwal.
            </p>
         </div>

         <!-- Ajakan Daftar Anggota -->
         <?php if ($is_member == 0): ?>
            <!-- Ajakan Daftar Anggota -->
            <div class="card bg-info text-white text-center my-4">
               <div class="card-body">
                     <h4 class="card-title">🎉 Dapatkan Akses Premium!</h4>
                     <p class="card-text">Ingin pinjam lebih banyak barang dan lebih lama?</p>
                     <a href="daftar_anggota.php" class="btn btn-light fw-semibold">Daftar Sebagai Anggota</a>
                     <a href="topUp_user.php" class="btn btn-outline-light ms-2">Top Up Sekarang</a>
               </div>
            </div>
         <?php else: ?>
            <!-- Pemberitahuan Sudah Menjadi Member -->
            <div class="alert alert-success text-center fw-semibold">
               🎊 Selamat! Anda sekarang adalah <strong>Anggota</strong>. Nikmati diskon dan fasilitas eksklusif!
            </div>
         <?php endif; ?>

         <!-- Navigasi Cepat -->
         <div class="row text-center mt-4">
            <div class="col-md-3 col-6 mb-3">
                  <a href="pinjam_user.php" class="btn btn-outline-primary w-100"><i class="fa-solid fa-box-open me-2"></i>Pinjam Barang</a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                  <a href="topUp_user.php" class="btn btn-outline-success w-100"><i class="fa-solid fa-coins me-2"></i>Top Up</a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                  <a href="riwayatPinjam_user.php" class="btn btn-outline-warning w-100"><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat</a>
            </div>
            <div class="col-md-3 col-6 mb-3">
                  <a href="daftar_anggota.php" class="btn btn-outline-dark w-100"><i class="fa-solid fa-id-card me-2"></i>Daftar Anggota</a>
            </div>
         </div>

         <!--Tips -->
         <div class="alert alert-secondary mt-5">
            <h6 class="mb-2">💡 Tips Peminjaman</h6>
            <ul class="mb-0">
                  <li>Barang yang dipinjam lebih dari 3 hari tanpa konfirmasi akan otomatis diblokir.</li>
                  <li>Ambil barang maksimal 1x24 jam setelah permintaan disetujui.</li>
            </ul>
         </div>
      </div>

 <!-- content -->

<!-- java script -->

<!-- java script -->
<?php
include 'includes_user/footer_user.php'
?>