<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3>Edit Kategori</h3>

<form action="<?= base_url('kategori/update/'.$kategori['id_kategori']); ?>" method="post">

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text"
               name="nama_kategori"
               class="form-control"
               value="<?= esc($kategori['nama_kategori']); ?>"
               required>
    </div>

    <button type="submit" class="btn btn-success">
        Update
    </button>

    <a href="<?= base_url('kategori'); ?>" class="btn btn-secondary">
        Kembali
    </a>

</form>

<?= $this->endSection(); ?>
