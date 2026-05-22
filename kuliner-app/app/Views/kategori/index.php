<?php echo $this->extend('layout/template'); ?>
<?php echo $this->section('content'); ?>

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Manajemen Kategori Kuliner</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/kuliner">Dashboard</a></li>
                <li class="breadcrumb-item active">Kategori</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10 col-md-12">

            <div class="mb-3">
                <a href="<?php echo base_url('kategori/create'); ?>" class="btn btn-primary shadow-sm px-3">
                    <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kategori Baru
                </a>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 8px;">
                <div class="card-header bg-white fw-bold text-primary py-3 border-bottom-0">
                    <i class="bi bi-tags-fill me-1"></i> Daftar Kategori Terdaftar
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light text-secondary small fw-bold text-uppercase">
                                <tr>
                                    <th width="70" class="py-3">No</th>
                                    <th class="text-start py-3">Nama Kategori</th>
                                    <th width="150" class="py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($kategori)): ?>
                                    <?php $no = 1; foreach($kategori as $kat): ?>
                                        <tr>
                                            <td class="py-3 text-muted"><?php echo $no++; ?></td>
                                            <td class="text-start py-3 px-3 fw-semibold text-dark">
                                                <?php echo $kat['nama_kategori']; ?>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="/kategori/edit/<?php echo $kat['id_kategori']; ?>" class="btn btn-outline-primary btn-sm px-2" title="Edit Kategori">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <a href="/kategori/delete/<?php echo $kat['id_kategori']; ?>" class="btn btn-outline-danger btn-sm px-2" onclick="return confirm('Yakin ingin menghapus kategori <?php echo $kat['nama_kategori']; ?>?')" title="Hapus Kategori">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-muted py-5">
                                                <i class="bi bi-info-circle fs-3 d-block mb-2 text-secondary"></i>
                                                Belum ada data kategori kuliner tersedia.
                                            </td>
                                        </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>

<?php echo $this->endSection(); ?>