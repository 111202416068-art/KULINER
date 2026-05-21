<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3>Data Kategori</h3>

<a href="<?= base_url('kategori/create'); ?>" class="btn btn-primary mb-3">
    + Tambah Kategori
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($kategori)): ?>
            <?php $no = 1; ?>
            <?php foreach ($kategori as $k): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($k['nama_kategori']); ?></td>
                    <td>
                        <a href="<?= base_url('kategori/edit/' . $k['id_kategori']); ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="<?= base_url('kategori/delete/' . $k['id_kategori']); ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">
                    Data kosong
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
