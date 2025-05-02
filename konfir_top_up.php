<?php
session_start();
include 'conn/koneksi.php';

$id_saldo = $_POST['id'];
$id_user = $_POST['id_login'];
$nominal = $_POST['nominal'];

// Cek status saldo
$cekStatus = mysqli_query($conn, "SELECT status FROM saldo WHERE id = '$id_saldo'");
$data = mysqli_fetch_assoc($cekStatus);

if ($data['status'] !== 'diterima') {

    $updateStatus = mysqli_query($conn, "UPDATE saldo SET status = 'diterima' WHERE id = '$id_saldo'");

    $updateSaldoUser = mysqli_query($conn, "
        UPDATE login 
        SET saldo = COALESCE(saldo, 0) + $nominal 
        WHERE id = '$id_user'
    ");

    if ($updateStatus && $updateSaldoUser) {
        $getSaldo = mysqli_query($conn, "SELECT saldo FROM login WHERE id = '$id_user'");
        $saldoBaru = mysqli_fetch_assoc($getSaldo)['saldo'];

        $_SESSION['status'] = "Top up berhasil dikonfirmasi. Total saldo user sekarang: Rp " . number_format($saldoBaru, 0, ',', '.');
        header("Location: topUp.php");
    } else {
        echo "<script>alert('Gagal mengupdate data.'); window.location='topUp.php';</script>";
    }
} else {
    echo "<script>alert('Top up ini sudah dikonfirmasi sebelumnya.'); window.location='topUp.php';</script>";
}
?>
