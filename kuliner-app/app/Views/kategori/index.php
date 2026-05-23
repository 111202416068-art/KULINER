<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Manajemen Kategori Kuliner</h1>
        <p class="text-muted small">Kelola data master pengelompokan jenis kuliner direktori kemitraan</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 rounded-3 small py-2 mb-3">
            <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 rounded-3 small py-2 mb-3">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <button type="button" class="btn btn-primary fw-bold px-4 mb-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Baru
    </button>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white fw-bold text-moka py-3 border-bottom">
            <i class="bi bi-tags-fill text-terracotta me-1"></i> Daftar Kategori Terdaftar
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th width="10%">No</th>
                            <th class="text-start">Nama Klasifikasi Kategori</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark small fw-semibold">
                        <?php if (!empty($kategori)): ?>
                            <?php $no = 1; foreach ($kategori as $k): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="text-start text-dark fw-bold">
                                        <span class="badge-kategori-tabel"><?= htmlspecialchars($k['nama_kategori']); ?></span>
                                    </td>
                                    <td>
                                        <a href="/kategori/delete/<?= $k['id_kategori']; ?>" class="btn btn-danger btn-sm rounded-3 px-3" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-muted py-4">Data kategori kosong atau belum dimuat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title fw-bold text-moka"><i class="bi bi-folder-plus me-1"></i> Input Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kategori/save" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Nama Kategori Kuliner</label>
                        <input type="text" name="nama_kategori" class="form-control rounded-3" placeholder="Contoh: Street Food, Cafe, Restoran" required>
                    </div>
                </div>
                <div class="modal-footer border-top pt-2">
                    <button type="button" class="btn btn-outline-secondary px-3 font-semibold" data-bs-toggle="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-moka { color: #8C6239 !important; }
    .text-terracotta { color: #E6A15C !important; }
    .badge-kategori-tabel {
        background-color: #F5EBE6;
        color: #8C6239;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #E6D5CC;
        display: inline-block;
    }
    .form-control:focus {
        border-color: #8C6239 !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 98, 57, 0.15) !important;
    }
</style>

<?= $this->endSection(); ?>