<?php
session_start();
include '../conn/koneksi.php';

if (!isset($_SESSION['id_login'])) {
    die("Harus login terlebih dahulu.");
}

$id_user = $_SESSION['id_login'];
$id_barang = $_POST['id'];
$harga_harian = $_POST['harga_sewa'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_kembali = $_POST['tgal_kembali'];
$tanggal_ajuan = $_POST['tanggal_ajuan'];

$query_anggota = mysqli_query($conn, "SELECT is_member FROM login WHERE id = '$id_user'");
$data_anggota = mysqli_fetch_assoc($query_anggota);
$isAnggota = $data_anggota['is_member'] == 1;

$query_barang = mysqli_query($conn, "SELECT harga_sewa FROM barang WHERE id = '$id_barang'");
$data_barang = mysqli_fetch_assoc($query_barang);
$harga_harian_asli = $data_barang['harga_sewa'];

$harga_harian = $isAnggota ? $harga_harian_asli * 0.8 : $harga_harian_asli;


$start = new DateTime($tanggal_pinjam);
$end = new DateTime($tanggal_kembali);
$jumlah_hari = $start->diff($end)->days;
$harga_sewa = $harga_harian * $jumlah_hari;

if ($jumlah_hari > 7) {
    header("Location: ../pinjam_user.php?error=max_7_hari");
    exit;
}


$query_saldo = mysqli_query($conn, "SELECT saldo FROM login WHERE id = '$id_user'");
$data_saldo = mysqli_fetch_assoc($query_saldo);
$saldo_user = $data_saldo['saldo'];

// Cek apakah saldo cukup
if ($saldo_user < $harga_sewa) {
    header("Location: ../pinjam_user.php?error=saldo_kurang");
    exit;
}

// Simpan ke database peminjaman
$query = "INSERT INTO peminjaman (id_login, id_barang, tanggal_ajuan, tgl_peminjaman, tgal_kembali, harga_harian, jmlh_hari_pinjam, total, ket)
          VALUES ('$id_user', '$id_barang', '$tanggal_ajuan', '$tanggal_pinjam', '$tanggal_kembali', '$harga_harian', '$jumlah_hari', '$harga_sewa', 'menunggu')";

if (mysqli_query($conn, $query)) {
    $query_update_saldo = "UPDATE login SET saldo = saldo - '$harga_sewa' WHERE id = '$id_user'";
    if (mysqli_query($conn, $query_update_saldo)) {
        $tanggal = date('Y-m-d');
        $keterangan = "Peminjaman Barang";
        $tipe_transaksi = "keluar";

        $query_insert_riwayat = "INSERT INTO riwayat_saldo (id_login, tanggal, keterangan, nominal, tipe_transaksi)
                                  VALUES ('$id_user', '$tanggal', '$keterangan', '$harga_sewa', '$tipe_transaksi')";

        if (mysqli_query($conn, $query_insert_riwayat)) {
            header("Location: ../riwayatPinjam_user.php?success=1");
        } else {
            echo "Gagal insert riwayat saldo: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal update saldo: " . mysqli_error($conn);
    }
} else {
    echo "Gagal menyimpan data peminjaman: " . mysqli_error($conn);
}
?>
