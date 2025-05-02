<?php
include 'conn/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_peminjaman = $_POST['id_peminjaman'];

    // Ambil data peminjaman
    $query = "SELECT * FROM peminjaman WHERE id = $id_peminjaman";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data peminjaman tidak ditemukan!");
    }

    $id_barang = $data['id_barang'];
    $id_user = $data['id_login'];
    $total_bayar = $data['total'];

    // Kurangi saldo user
    mysqli_query($conn, "UPDATE login SET saldo = saldo - $total_bayar WHERE id = $id_user");

    // Ubah status peminjaman jadi 'Disetujui'
    mysqli_query($conn, "UPDATE peminjaman SET ket = 'Disetujui' WHERE id = $id_peminjaman");

    // Ubah status barang jadi 'dipinjam'
    mysqli_query($conn, "UPDATE barang SET status_brg = 'dipinjam' WHERE id = $id_barang");

    header("Location: peminjaman_brg.php?konfirmasi=berhasil");
    exit;
}
?>
