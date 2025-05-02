<?php
include 'conn/koneksi.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM barang WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        
        http_response_code(404);
        echo json_encode(['error' => 'Data barang tidak ditemukan.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    
    http_response_code(400);
    echo json_encode(['error' => 'ID barang tidak valid.']);
}
?>