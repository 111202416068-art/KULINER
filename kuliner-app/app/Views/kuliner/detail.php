<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3><?= isset($kuliner['nama']) ? $kuliner['nama'] : 'Nama tidak tersedia'; ?></h3>
<p><?= isset($kuliner['alamat']) ? $kuliner['alamat'] : 'Alamat tidak tersedia'; ?></p>

<hr>

<h5>Review Pengunjung</h5>

<?php if (!empty($review)) : ?>
    <?php foreach ($review as $r): ?>
        <div class="card mb-2 p-2">
            <b>User ID: <?= $r['user_id']; ?></b><br>
            ⭐ <?= $r['rating']; ?><br>
            <small><?= $r['isi']; ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Belum ada review</p>
<?php endif; ?>
<hr>

<h5>Tambah Review</h5>

<form action="/review/save" method="post">
    <input type="hidden" name="kuliner_id" value="<?= isset($kuliner['id']) ? $kuliner['id'] : '' ?>">

    <div class="mb-2">
        <label>Rating</label>
        <input type="number" name="rating" min="1" max="5" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Review</label>
        <textarea name="isi" class="form-control" required></textarea>
    </div>

    <button class="btn btn-primary">Kirim Review</button>
</form>

<?php if (session()->get('role') == 'pengunjung'): ?>

<h5>Tambah Review</h5>

<form action="/review/save" method="post">
    <input type="hidden" name="kuliner_id" value="<?= isset($kuliner['id']) ? $kuliner['id'] : '' ?>">

    <div class="mb-2">
        <label>Rating</label>
        <input type="number" name="rating" min="1" max="5" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Review</label>
        <textarea name="isi" class="form-control" required></textarea>
    </div>

    <button class="btn btn-primary">Kirim Review</button>
</form>

<?php endif; ?>

<?= $this->endSection(); ?>