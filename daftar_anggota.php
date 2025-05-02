<?php
session_start();
if (!isset($_SESSION['log'])) {
    header("Location: login.php");
    exit;
}

$timeout = 9000;

if(isset($_SESSION['last-activity']) && (time() - $SESSION['last-activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("location: user_dashboard.php?expired=true");
    exit;
}

$SESSION['last-activity'] = time();

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    echo 'username';
}

if (!isset($_SESSION['id_login'])) {
    die("User belum login atau sesi tidak ditemukan");
}


?>
<?php include 'includes_user/header_user.php'; ?>
<?php include 'includes_user/navbar_user.php'; ?>

<div class="container py-5">
    <h3 class="mb-4 fw-bold">📝 Daftar Sebagai Anggota</h3>

    <form action="proses/proses_daftar_anggota.php" method="POST" class="row g-3 shadow-sm p-4 rounded bg-light">

        <!-- Nama & Username dari session -->
        <div class="col-md-6">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama">
        </div>
        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value =" <?php echo htmlspecialchars($username) ?>" readonly>
        </div>

        <!-- Tanggal Aktif -->
        <div class="col-md-6">
            <label for="tanggal_aktif" class="form-label">Tanggal Aktif</label>
            <input type="date" class="form-control" id="tanggal_aktif" name="tanggal_aktif" value="<?php echo date('Y-m-d'); ?>" readonly>
        </div>

        <!-- Tempat & Tanggal Lahir -->
        <div class="col-md-6">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
        </div>
        <div class="col-md-6">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>
        <!-- nomor hp -->
        <div class="col-md-6">
            <label for="tanggal_lahir" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required placeholder = "contoh : 085297371947">
        </div>

        <!-- Alamat -->
        <div class="col-12">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <!-- Agama -->
        <div class="col-md-6">
            <label for="agama" class="form-label">Agama</label>
            <select class="form-select" id="agama" name="agama" required>
                <option value="">-- Pilih Agama --</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
            </select>
        </div>

        <!-- Jenis Kelamin -->
        <div class="col-md-6">
            <label class="form-label d-block">Jenis Kelamin</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki" required>
                <label class="form-check-label" for="laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                <label class="form-check-label" for="perempuan">Perempuan</label>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100" name = "submit">Daftar Sekarang</button>
        </div>
    </form>
</div>

<?php include 'includes_user/footer_user.php'; ?>
