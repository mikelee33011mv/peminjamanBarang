<?php
include 'koneksi.php';
include 'includes_admin/header_admin.php';
include 'includes_admin/navbar_admin.php';

$id = $_GET['id'];
$id_barang = $_GET['id'];

// Update status peminjaman
mysqli_query($conn, "UPDATE peminjaman SET status='disetujui' WHERE id_peminjaman = '$id'");

// Update status barang
mysqli_query($conn, "UPDATE barang SET status='dipinjam' WHERE id_barang = '$id'");
?>

<div class="container p-5">
    <div class="card shadow-sm p-4 mx-auto text-center" style="max-width: 500px;">
        <h5 class="text-success">Peminjaman Disetujui</h5>
        <p>Data peminjaman telah berhasil dikonfirmasi.</p>
        <p>Anda akan diarahkan kembali ke halaman verifikasi dalam <span id="waktu">3</span> detik...</p>
        <a href="admin_verifikasi.php" class="btn btn-primary mt-3">Kembali Sekarang</a>
    </div>
</div>

<script>
    let detik = 3;
    const waktu = document.getElementById('waktu');

    const interval = setInterval(() => {
        detik--;
        waktu.innerText = detik;
        if (detik <= 0) {
            clearInterval(interval);
            window.location.href = 'verifikasi.php';
        }
    }, 1000);
</script>

<?php include 'includes_admin/footer_admin.php'; ?>
