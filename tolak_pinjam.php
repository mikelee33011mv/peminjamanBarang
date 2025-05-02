<?php
session_start(); // Tambahkan ini di paling atas
include 'conn/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_peminjaman = $_POST['id_peminjaman'];

    // Update status jadi Ditolak
    mysqli_query($conn, "UPDATE peminjaman SET ket = 'Ditolak' WHERE id = $id_peminjaman");

    // Set session agar alert ditampilkan 1x di riwayatPinjam_user.php
    $_SESSION['penolakan'] = "❌ Salah satu peminjaman Anda ditolak oleh admin. Silakan cek detailnya.";

    header("Location: peminjaman_brg.php?tolak=berhasil");
    exit;
}
?>
