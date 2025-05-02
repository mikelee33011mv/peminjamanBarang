<?php
    include '../conn/koneksi.php'
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Data Barang</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../conn/koneksi.php'; // Langkah 1: Koneksi Database
                $sql = "SELECT id_barang, nama_barang, jumlah_barang, kategori FROM barang";
                $result = mysqli_query($conn, $sql); 

                if (mysqli_num_rows($result) > 0) { // Periksa apakah ada data
                    while ($row = mysqli_fetch_assoc($result)) { // Langkah 3: Ambil Hasil (per baris)
                        echo "<tr>"; // Langkah 4: Tampilkan dalam HTML
                        echo "<td>" . $row['id_barang'] . "</td>";
                        echo "<td>" . $row['nama_barang'] . "</td>";
                        echo "<td>" . $row['jumlah_barang'] . "</td>";
                        echo "<td>" . $row['kategori'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data.</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>

        <div>
            <a href="../tambah_barang.php">Kembali ke halaman Tambah Barang</a>
        </div>

        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </body>
</html>