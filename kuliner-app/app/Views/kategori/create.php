<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3>Tambah Kategori</h3>

<form action="/kategori/save" method="post">
    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection(); ?>