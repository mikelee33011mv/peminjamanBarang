<?php
include 'conn/koneksi.php';
session_start();
if(!isset($_SESSION['id_login'])) {
    die ('anda belum melakukan login');
}
$id_login = $_SESSION['id_login'];
$query = mysqli_query($conn, "SELECT saldo FROM login where id = $id_login");
$data = mysqli_fetch_assoc($query);
$saldo = $data['saldo'];

?>
<?php
include 'includes_user/header_user.php';

?>

<?php
include 'includes_user/navbar_user.php';
?>


<?php if (isset($_SESSION['topup_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
        <?= $_SESSION['topup_success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['topup_success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
        <?= $_SESSION['status'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['status']); ?>
<?php endif; ?>
<!-- content -->
 <div class="container p-5">
    <div class="alert alert-info text-center fw-semibold">
    Saldo Anda Saat Ini: <strong><?= number_format($saldo, 0, ',' , '.');?></strong>
    </div>

        <form class="card p-4 shadow-sm mx-auto" style="max-width: 500px;" method = "post" action = "konfirmasi_topUp.php">
            <h5 class="mb-3">💰 Isi Saldo</h5>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Top Up (Rp)</label>
                <input type="text" class="form-control" id="jumlah_display" placeholder="Contoh: 20000" required>
                <input type="hidden" name="jumlah" id="jumlah"> 
            </div>


            <div class="mb-3">
                <label for="metode" class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="metode" name="metode_bayar">
                <option value="">-- Pilih --</option>
                <option value="gopay">GoPay</option>
                <option value="dana">DANA</option>
                <option value="ovo">Bayar Tunai</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Top Up Sekarang</button>
        </form>

        <div class="alert alert-warning mt-4">
        📌 <strong>Petunjuk:</strong> Setelah mengisi form, sistem akan mengarahkan ke halaman pembayaran sesuai metode yang dipilih.
                    Saldo akan bertambah otomatis setelah pembayaran berhasil.
        </div>



 </div>
<!-- content -->

<script>
const displayInput = document.getElementById('jumlah_display');
const hiddenInput = document.getElementById('jumlah');

displayInput.addEventListener('input', function(e) {
    // Ambil hanya angka
    let raw = e.target.value.replace(/\D/g, '');
    // Format tampilan
    e.target.value = new Intl.NumberFormat('id-ID').format(raw);
    // Masukkan nilai asli ke input hidden
    hiddenInput.value = raw;
});
</script>


<?php
include 'includes_user/footer_user.php';
?>