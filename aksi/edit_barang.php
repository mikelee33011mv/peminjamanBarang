<?php
include '../conn/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori_barang'];
    $harga = $_POST['harga_barang'];
    $sewa = $_POST['harga_sewa'];
    $vip = $_POST['harga_vip'];
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_baru_name = null;

    // Proses upload gambar baru jika ada
    if (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] === 0) {
        $gambar_baru_name = $_FILES['gambar_baru']['name'];
        $gambar_baru_tmp = $_FILES['gambar_baru']['tmp_name'];
        $upload_path = '../uploads/' . $gambar_baru_name;

        // Hapus gambar lama jika ada
        if (!empty($gambar_lama) && file_exists('../uploads/' . $gambar_lama)) {
            unlink('../uploads/' . $gambar_lama);
        }

        if (!move_uploaded_file($gambar_baru_tmp, $upload_path)) {
            echo "Gagal meng-upload gambar baru.";
            exit;
        }
    } else {
        // Jika tidak ada gambar baru diunggah, gunakan gambar lama
        $gambar_baru_name = $gambar_lama;
    }

    $sql = "UPDATE barang SET
            nama_barang = ?,
            kategori_brg = ?,
            harga_barang = ?,
            harga_sewa = ?,
            harga_vip = ?,
            foto = ?
            WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssiiisi", $nama, $kategori, $harga, $sewa, $vip, $gambar_baru_name, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../tambah_barang.php?status=update_sukses"); // Redirect ke halaman yang sesuai
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Jika bukan metode POST
    header("HTTP/1.0 403 Forbidden");
    echo "Akses ditolak.";
}
?>