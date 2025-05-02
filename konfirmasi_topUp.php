<?php 
    session_start();
    $jumlah = $_POST['jumlah'];
    $metode = $_POST['metode_bayar'];
    $kode_bayar = rand(999999, 10000);

    $_SESSION['nominal'] = $jumlah;
    $_SESSION['metode_bayar'] = $metode;
    $_SESSION['kode_bayar'] = $kode_bayar;
    ?>

    <?php
    include 'includes_user/header_user.php';
    ?>
    <?php
    include 'includes_user/navbar_user.php';
    ?>

    <div class="container p-5">
        <h5>Konfirmasi Top Up</h5>
        <p><strong>Jumlah Top Up:</strong> Rp <?= number_format($jumlah, 0, ',', '.') ?></p>
        <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($metode)?></p>
        <p><strong>Kode Pembayaran Anda:</strong> <span class="text-danger"><?= $kode_bayar ?></span></p>
        
        <form action="proses/proses_saldo.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="bukti" class="form-label">Upload Bukti Transfer</label>
            <input type="file" class="form-control" name="bukti" id="bukti" accept="image/*" required>
            <img id="preview" class="img-fluid mt-3" style="max-width: 30%; display: none;" />
        </div>
            <button type="submit" class="btn btn-success w-100">Kirim Bukti & Proses</button>
        </form>
       
    </div>
<script>
    document.getElementById('bukti').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '';
        }
    });
</script>


    



    <?php
    include 'includes_user/footer_user.php';
    ?>
    