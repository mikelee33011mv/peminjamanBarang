<?php
session_start();
if(!isset($_SESSION['id_login'])) {
    die('user belum login');
}
include '../conn/koneksi.php';

$id_user = $_SESSION['id_login'];
$nominal = $_SESSION['nominal'];
$metode = $_SESSION['metode_bayar'];
$kode = $_SESSION['kode_bayar'];

$bukti = $_FILES['bukti']['name'];
$tmp = $_FILES['bukti']['tmp_name'];
$folder = "../bukti_tf/" . $bukti;

if (move_uploaded_file($tmp, $folder)) {
    $query = "INSERT INTO saldo (id_login, nominal, metode_bayar, kode_bayar, bkt_pembayaran, tgal_topup, status)
              VALUES ('$id_user', '$nominal', '$metode', '$kode', '$bukti', NOW(), 'menunggu')";

    if (mysqli_query($conn, $query)) {
        // --- Tambahkan data ke riwayat_saldo ---
        $tanggal = date('Y-m-d'); 
        $keterangan = "Top Up Saldo";
        $tipe_transaksi = "masuk";

        mysqli_query($conn, "INSERT INTO riwayat_saldo (id_login, tanggal, keterangan, nominal, tipe_transaksi) 
                             VALUES ('$id_user', '$tanggal', '$keterangan', '$nominal', '$tipe_transaksi')");

        // --- End tambahan ---

        // Kirim flash message ke halaman topUp_user
        $_SESSION['topup_success'] = "Top up berhasil! Kode Pembayaran Anda: $kode, silahkan tunggu pembaruan saldo anda";
        header("Location: ../topUp_user.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    echo "Gagal upload bukti transfer.";
}
?>
