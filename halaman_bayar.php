<?php
include 'conn/koneksi.php';
session_start();

if (isset($_POST['bayar_denda'])) {
    // Ambil id_login dari session
    $id_login = $_SESSION['id_login'];

    // Ambil saldo user dari database
    $query_saldo = "SELECT saldo FROM login WHERE id = $id_login";
    $result_saldo = mysqli_query($conn, $query_saldo);
    $data_saldo = mysqli_fetch_assoc($result_saldo);
    $saldo = $data_saldo['saldo'] ?? 0;

    // Ambil total denda user dari peminjaman
    $query_denda = "SELECT SUM(denda) as total_denda FROM peminjaman WHERE id_login = $id_login AND denda > 0";
    $result_denda = mysqli_query($conn, $query_denda);
    $data_denda = mysqli_fetch_assoc($result_denda);
    $total_denda = $data_denda['total_denda'] ?? 0;

    if ($saldo >= $total_denda) {
        // Kurangi saldo
        $new_saldo = $saldo - $total_denda;
        $update_saldo = "UPDATE login SET saldo = $new_saldo WHERE id = $id_login";
        mysqli_query($conn, $update_saldo);

        // Tandai semua denda sudah dibayar
        $clear_denda = "UPDATE peminjaman SET denda = 0 WHERE id_login = $id_login AND denda > 0";
        mysqli_query($conn, $clear_denda);

        // Catat ke riwayat_saldo
        $tanggal = date('Y-m-d');
        $keterangan = 'Pembayaran Denda';
        mysqli_query($conn, "INSERT INTO riwayat_saldo (id_login, tanggal, keterangan, nominal, tipe_transaksi)
        VALUES ($id_login, '$tanggal', '$keterangan', $total_denda, 'keluar')");


        // Tampilkan pesan sukses dan arahkan ke halaman riwayat pinjam
        $_SESSION['success'] = '✅ Denda berhasil dibayar. Saldo Anda telah terpotong.';
        header('Location: riwayatPinjam_user.php');
        exit;
    } else {
        // Tampilkan pesan jika saldo tidak mencukupi
        $_SESSION['error'] = '❌ Saldo tidak mencukupi untuk membayar denda.';
        header('Location: riwayatPinjam_user.php');
        exit;
    }
}
?>
