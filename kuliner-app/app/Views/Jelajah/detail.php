<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3><?= isset($kuliner['nama']) ? $kuliner['nama'] : 'Nama Kuliner'; ?></h3>
<p><?= isset($kuliner['alamat']) ? $kuliner['alamat'] : 'Alamat tidak tersedia'; ?></p>

<hr>

<h5>Review Pengunjung</h5>

<?php if (isset($review) && !empty($review)): ?>
    <?php foreach ($review as $r): ?>
        <div class="card p-2 mb-2">
            ⭐ <?= $r['rating']; ?><br>
            <small><?= $r['isi']; ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Belum ada review.</p>
<?php endif; ?>

<hr>

<?php if (session()->get('role') == 'pengunjung'): ?>

<h5>Tambah Review</h5>

<form action="/review/save" method="post">
    <input type="hidden" name="kuliner_id" value="<?= isset($kuliner['id']) ? $kuliner['id'] : ''; ?>">

    <input type="number" name="rating" min="1" max="5" class="form-control mb-2" required>
    <textarea name="isi" class="form-control mb-2" required></textarea>

    <button class="btn btn-primary">Kirim</button>
</form>

<?php endif; ?>

<?= $this->endSection(); ?>