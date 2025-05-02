<?php
$current = basename($_SERVER['PHP_SELF']);
echo "<!-- current: $current -->";
?>
<style>


.navbar-nav .nav-link:hover {
    color: #0d6efd !important;
}

.navbar-nav .nav-link.active {
    color: #0d6efd !important;
    font-weight: bold;
}

</style>


<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="#"><span class="text-primary">P</span>injamBarang</a>

        <!-- Toggle untuk layar kecil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu utama -->
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link fw-semibold <?php echo ($current == 'user_dashboard.php') ? 'active' : ''; ?>" href="user_dashboard.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold <?php echo ($current == 'pinjam_user.php') ? 'active' : ''; ?>" href="pinjam_user.php">Pinjam</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold <?php echo ($current == 'topUp_user.php') ? 'active' : ''; ?>" href="topUp_user.php">Top up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold <?php echo ($current == 'riwayatPinjam_user.php') ? 'active' : ''; ?>" href="riwayatPinjam_user.php">Riwayat Pinjam</a>
            </li>
        </ul>


            <!-- Ikon profil kanan -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
                </li>
            </ul>
        </div>

        
    </div>
</nav>
