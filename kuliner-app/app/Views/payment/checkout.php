<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container py-5 text-center">
    <?php $kuliner = isset($kuliner) ? $kuliner : ['nama' => 'Produk']; ?>
    <div class="card shadow border-0 p-4 mx-auto" style="max-width: 500px;">
        <h4 class="fw-bold text-primary mb-3">Konfirmasi Pembelian Voucher</h4>
        <p>Anda akan membeli voucher diskon digital untuk:</p>
        <h5><b><?= $kuliner['nama']; ?></b></h5>
        <?php $nominal = isset($nominal) ? $nominal : 0; ?>
        <h3 class="text-success fw-bold my-3">Rp <?= number_format($nominal, 0, ',', '.'); ?></h3>

        <button id="pay-button" class="btn btn-primary w-100 py-2 fw-bold">Bayar Sekarang</button>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?? ''; ?>"></script>
<script type="text/javascript">
    <?php $snapToken = $snapToken ?? ''; ?>
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        window.snap.pay(<?= json_encode($snapToken); ?>, {
            onSuccess: function(result) {
                alert("Pembayaran Berhasil! Notifikasi konfirmasi sedang dikirim.");
                window.location.href = "/kuliner";
            },
            onPending: function(result) {
                alert("Menunggu pembayaran Anda.");
            },
            onError: function(result) {
                alert("Pembayaran gagal, silakan coba lagi.");
            }
        });
    });
</script>

<?= $this->endSection(); ?>