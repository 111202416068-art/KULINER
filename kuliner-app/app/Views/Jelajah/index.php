<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3 class="mb-4">Jelajah Kuliner</h3>

<div class="row">

    <?php if (!empty($kuliner)): ?>
        <?php foreach ($kuliner as $k): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">

                    <img src="/uploads/<?= $k['foto'] ?? 'default.jpg'; ?>"
                        class="card-img-top"
                        style="height:200px;object-fit:cover;">

                    <div class="card-body">
                        <h5><?= $k['nama'] ?? 'Tanpa Nama'; ?></h5>
                        <p class="text-muted"><?= $k['nama_kategori'] ?? '-'; ?></p>

                        <a href="/jelajah/detail/<?= $k['id'] ?? ''; ?>"
                            class="btn btn-primary btn-sm">
                            Lihat Detail
                        </a>

                        <a href="/payment/beli/<?= $k['id'] ?? ''; ?>"
                            class="btn btn-warning btn-sm mt-1 w-100 fw-bold text-dark">
                            <i class="bi bi-ticket-perforated-fill"></i> Beli Voucher Diskon
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada data kuliner untuk dijelajahi.</p>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection(); ?>