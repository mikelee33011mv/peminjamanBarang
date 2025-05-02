<?php
session_start();
include '../conn/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id_login'])) {
        die("Sesi login tidak ditemukan");
    }

    $id_login = $_SESSION['id_login'];

    // Cek saldo
    $cekSaldo = mysqli_query($conn, "SELECT saldo FROM login WHERE id = '$id_login'");
    $dataSaldo = mysqli_fetch_assoc($cekSaldo);
    $saldo = $dataSaldo['saldo'];

    if ($saldo < 50000) {
        echo "<script>alert('Saldo Anda tidak mencukupi untuk mendaftar sebagai anggota (minimal Rp50.000)');
              window.location.href = '../topUp_user.php';</script>";
        exit;
    }

    // Ambil data form
    $nama = $_POST['nama'];
    $tgl_aktif = date('Y-m-d');
    $tmt_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $agama  = $_POST['agama'];
    $jkel = $_POST['jenis_kelamin'];
    $no_hp = $_POST['nomor_hp'];

    mysqli_begin_transaction($conn);

    try {
        $kurangiSaldo = mysqli_query($conn, "UPDATE login SET saldo = saldo - 50000 WHERE id = '$id_login'");

        $cekSaldoBaru = mysqli_query($conn, "SELECT saldo FROM login WHERE id = '$id_login'");
        $dataSaldoBaru = mysqli_fetch_assoc($cekSaldoBaru);
        $saldoAkhir = $dataSaldoBaru['saldo'];

        
        $insert = mysqli_query($conn, "INSERT INTO anggota (id_login, nama, tgl_aktif_agt, tempat_lahir, tanggal_lahir, alamat, agama, j_kel, no_hp, saldo) 
                     VALUES ('$id_login', '$nama', '$tgl_aktif', '$tmt_lahir', '$tgl_lahir', '$alamat', '$agama', '$jkel', '$no_hp', '$saldoAkhir')");

        $updateMember = mysqli_query($conn, "UPDATE login SET is_member = 1 WHERE id = '$id_login'");

        mysqli_commit($conn);

        echo "<script>alert('Pendaftaran berhasil! Anda sekarang anggota.');
              window.location.href = '../user_dashboard.php';</script>";
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
