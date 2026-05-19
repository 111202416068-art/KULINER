<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3>Data Kategori</h3>

<a href="<?= base_url('kategori/create'); ?>" class="btn btn-primary mb-3">
    + Tambah Kategori
</a>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($kategori)): ?>
            <?php $no = 1; foreach ($kategori as $k): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $k['nama_kategori']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Data kosong</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>