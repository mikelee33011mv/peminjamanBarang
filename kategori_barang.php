<?php include 'includes/header.php'; ?>
<?php include 'includes/topnav.php'; ?>

<div id="layoutSidenav">
    <?php include 'includes/navbar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Jenis Barang</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Jenis Barang</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Jenis Barang
                    </div>
                    <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                            <tr class="table-dark">
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>null</td>
                                <td>null</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
        