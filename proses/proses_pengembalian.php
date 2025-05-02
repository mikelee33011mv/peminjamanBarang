<?php
include '../conn/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $kondisi = $_POST['kondisi'];
    $denda = $_POST['denda'];

    // Ambil data peminjaman termasuk id_barang
    $query_get = mysqli_query($conn, "SELECT id_barang FROM peminjaman WHERE id = '$id_peminjaman'");
    $data = mysqli_fetch_assoc($query_get);
    $id_barang = $data['id_barang'];

    // Update peminjaman (ket jadi dikembalikan, isi kondisi dan denda)
    $update_peminjaman = mysqli_query($conn, "
        UPDATE peminjaman 
        SET ket = 'Dikembalikan', kondisi = '$kondisi', denda = '$denda'
        WHERE id = '$id_peminjaman'
    ");

    $update_status_barang = mysqli_query($conn, "
        UPDATE barang 
        SET status_brg = 'tersedia'
        WHERE id = '$id_barang'
    ");

    if ($update_peminjaman && $update_status_barang) {
        echo "<script>alert('Pengembalian berhasil diproses'); window.location.href='../pengembalian.php';</script>";
    } else {
        echo "<script>alert('Gagal memproses pengembalian'); window.history.back();</script>";
    }
}
?>
