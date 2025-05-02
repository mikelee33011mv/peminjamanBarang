<?php 
session_start();
include 'conn/koneksi.php';

if (!isset($_SESSION['id_login'])) {
    die("User belum login.");
}

$id_user = $_SESSION['id_login'];
$id_barang = $_POST['id_barang'];

if(!$id_barang) {
    die("data tidak ditemukan");
}

// Ambil data barang
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id_barang'"));

?>

<?php include 'includes_user/header_user.php'; ?>
<?php include 'includes_user/navbar_user.php'; ?>

<div class="container p-5">
    <div class="card p-3 shadow-sm mx-auto" style="max-width: 600px;">
        <h5>Konfirmasi Peminjaman</h5>
        <p><strong>Nama Barang:</strong> <?= $barang['nama_barang'] ?></p>
        <p><strong>Harga Harian:</strong> Rp <?= number_format($_POST['harga_sewa'], 0, ',', '.') ?></p>

        <form action="proses/proses_pinjam.php" method="post">
            <input type="hidden" name="id" value="<?= $barang['id'] ?>">
            <input type="hidden" name="harga_sewa" value="<?= $barang['harga_sewa'] ?>">

            <div class="mb-3">
                <label for="tanggal_ajuan" class="form-label">Tanggal Pengajuan</label>
                <input type="date" class="form-control" name="tanggal_ajuan" value="<?php echo date(format: 'Y-m-d') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman</label>
                <input type="date" class="form-control" name="tanggal_pinjam" required>
            </div>

            <div class="mb-3">
                <label for="tgal_kembali" class="form-label">Tanggal Pengembalian</label>
                <input type="date" class="form-control" name="tgal_kembali" required>
            </div>

            <button type="submit" name="submit" class="btn btn-success w-100">Konfirmasi Peminjaman</button>
        </form>
    </div>
</div>

<script>
    const tanggalPinjam = document.querySelector('input[name="tanggal_pinjam"]');
    const tanggalKembali = document.querySelector('input[name="tgal_kembali"]');

    tanggalPinjam.addEventListener('change', () => {
        const pinjamDate = new Date(tanggalPinjam.value);
        const maxKembaliDate = new Date(pinjamDate);
        maxKembaliDate.setDate(pinjamDate.getDate() + 7);

        tanggalKembali.min = tanggalPinjam.value;
        tanggalKembali.max = maxKembaliDate.toISOString().split('T')[0];
        tanggalKembali.value = ''; // reset saat user ganti tanggal pinjam
    });
</script>


<?php include 'includes_user/footer_user.php'; ?>
