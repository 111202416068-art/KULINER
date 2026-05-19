<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3 class="mb-4">Jelajah Kuliner</h3>

<div class="row">

<?php foreach ($kuliner ?? [] as $k): ?>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100">

            <img src="/uploads/<?= $k['foto'] ?? 'default.jpg'; ?>" 
                 class="card-img-top" 
                 style="height:200px;object-fit:cover;">

            <div class="card-body">
                <h5><?= $k['nama']; ?></h5>
                <p class="text-muted"><?= $k['nama_kategori']; ?></p>

                <a href="/jelajah/detail/<?= $k['id']; ?>" 
                   class="btn btn-primary btn-sm">
                   Lihat Detail
                </a>
            </div>

        </div>
    </div>
<?php endforeach; ?>

</div>

<?= $this->endSection(); ?>