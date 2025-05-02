<?php
include '../conn/koneksi.php'; // Pastikan path ke koneksi database benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']); // amankan input ID

        $query = "DELETE FROM barang WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "Gagal menghapus data: " . mysqli_error($conn);
        }
    } else {
        echo "ID tidak dikirim.";
    }
} else {
    echo "Metode tidak diizinkan.";
}
?>
