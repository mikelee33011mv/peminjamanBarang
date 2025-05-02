<?php
include '../conn/koneksi.php';

$nama     = $_POST['nama_barang'];
$kategori = $_POST['kategori_barang'];
$harga    = $_POST['harga_barang'];
$sewa     = $_POST['harga_sewa'];
$vip      = $_POST['harga_vip'];

$status = 'tersedia';

$awalan_kode = strtoupper(substr($nama, 0, 3));

// Fungsi untuk mendapatkan nomor urut terakhir berdasarkan awalan (kategori)
function getNomorUrutTerakhir($conn, $awalan) {
    $sql_max = "SELECT MAX(SUBSTR(kode_barang, 5)) AS nomor_urut
                FROM barang
                WHERE LEFT(kode_barang, 3) = '$awalan'";
    $result_max = mysqli_query($conn, $sql_max);
    $row_max = mysqli_fetch_assoc($result_max);
    return $row_max['nomor_urut'] ? (int)$row_max['nomor_urut'] : 0;
}

// Mendapatkan nomor urut berikutnya
$nomor_urut_terakhir = getNomorUrutTerakhir($conn, $awalan_kode);
$nomor_urut_baru = $nomor_urut_terakhir + 1;
$kode = $awalan_kode . "-" . sprintf("%03d", $nomor_urut_baru);

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp  = $_FILES['gambar']['tmp_name'];

    // Pastikan folder uploads/ ada
    $upload_path = '../uploads/' . $gambar_name;

    if (move_uploaded_file($gambar_tmp, $upload_path)) {

        $sql = "INSERT INTO barang (nama_barang, kode_barang, kategori_brg, status_brg, harga_barang, harga_sewa, harga_vip, foto)
                VALUES ('$nama', '$kode', '$kategori', '$status', $harga, $sewa, $vip, '$gambar_name')";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../tambah_barang.php?status=sukses");
            exit;
        } else {
            echo "Gagal menambahkan data: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal meng-upload gambar.";
    }
} else {
    echo "Gambar tidak ditemukan atau terjadi error saat upload (kode error: " . $_FILES['gambar']['error'] . ").";
}
?>