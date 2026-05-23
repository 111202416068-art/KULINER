<<<<<<< HEAD
<?php echo $this->extend('layout/template'); ?>
<?php echo $this->section('content'); ?>
<?php
$kuliner = $kuliner ?? [];
$totalReview = $totalReview ?? 0;
$rataRating = $rataRating ?? 0;
$cuaca = $cuaca ?? ['desc' => '-', 'temp' => '-', 'humidity' => '-'];
?>
=======
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
>>>>>>> 053b1fb2a1721913e229d94d0271865be1200e3a

<h3>Data Kategori</h3>

<<<<<<< HEAD
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
            <div class="card-body p-3">
                <h6 class="text-muted small fw-bold text-uppercase">Total Lokasi</h6>
                <h3 class="fw-bold mb-0"><?php echo count($kuliner); ?> Tempat</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
            <div class="card-body p-3">
                <h6 class="text-muted small fw-bold text-uppercase">Total Review</h6>
                <h3 class="fw-bold mb-0"><?php echo $totalReview; ?> Review</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
            <div class="card-body p-3">
                <h6 class="text-muted small fw-bold text-uppercase">Rata-rata Rating</h6>
                <h3 class="fw-bold mb-0 text-warning">⭐ <?php echo number_format($rataRating, 1); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 shadow-sm border-0 bg-light">
    <div class="card-body d-flex align-items-center justify-content-between p-3">
        <div>
            <h6 class="text-muted small fw-bold mb-1"><i class="bi bi-cloud-sun-fill text-info"></i> INFO CUACA KOTA SEKARANG</h6>
            <span class="fw-bold text-dark fs-5"><?php echo $cuaca['desc'] ?? '-'; ?></span>
        </div>
        <div class="text-end">
            <span class="badge bg-primary fs-6 p-2">Suhu: <?php echo $cuaca['temp'] ?? '-'; ?></span>
            <span class="badge bg-secondary fs-6 p-2">Kelembapan: <?php echo $cuaca['humidity'] ?? '-'; ?></span>
        </div>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">
        <i class="bi bi-geo-alt-fill"></i> Peta Lokasi Kuliner
    </div>
    <div class="card-body">
        <div id="map" style="height:350px; border-radius:10px;"></div>
    </div>
</div>

<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <form method="get" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / alamat..." value="<?php echo $_GET['search'] ?? ''; ?>">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <form method="get" class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama / alamat..." value="<?php echo $_GET['search'] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <?php foreach ($kategori ?? [] as $k): ?>
                                        <option value="<?php echo $k['id_kategori']; ?>" <?php echo (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : ''; ?>>
                                            <?php echo $k['nama_kategori']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold text-primary py-3">
        <i class="bi bi-table"></i> Data Direktori Kuliner
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kuliner)): ?>
                        <?php $no = 1;
                        foreach ($kuliner as $k): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <img src="/uploads/<?php echo $k['foto'] ?? 'default.jpg'; ?>" width="70" height="50" style="object-fit:cover; border-radius:6px;">
                                </td>
                                <td class="text-start">
                                    <b><?php echo $k['nama']; ?></b><br>
                                    <small class="text-muted"><?php echo $k['alamat']; ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo $k['nama_kategori'] ?? '-'; ?></span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalVoucher<?php echo $k['id']; ?>" title="Beli Voucher">
                                        <i class="bi bi-ticket-perforated-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <small><?php echo htmlspecialchars($k['review_text'] ?? '-'); ?></small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <?php if (!empty($k['lat'])): ?>
                                            <a href="https://maps.google.com/?q=<?php echo $k['lat']; ?>,<?php echo $k['lng']; ?>" target="_blank" class="btn btn-success btn-sm" title="Buka Peta">
                                                <i class="bi bi-geo-alt"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="/kuliner/detail/<?php echo $k['id']; ?>" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="/payment/beli/<?php echo $k['id']; ?>" class="btn btn-warning btn-sm text-dark fw-bold" title="Beli Voucher">
                                            <i class="bi bi-ticket-perforated-fill"></i>
                                        </a>

                                        <?php if (session()->get('role') != 'pengunjung'): ?>
                                            <a href="/kuliner/edit/<?php echo $k['id']; ?>" class="btn btn-primary btn-sm" title="Ubah Data">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/kuliner/delete/<?php echo $k['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')" title="Hapus Data">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Beli Voucher -->
                            <div class="modal fade" id="modalVoucher<?php echo $k['id']; ?>" mercantile-id="midtrans-sandbox" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-warning text-dark border-0 py-3">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-wallet2 me-1"></i> Midtrans Sandbox Simulator</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4 text-start">
                                            <div class="text-center mb-3">
                                                <span class="badge bg-light text-dark border p-2 mb-2">ORDER ID: VCH-<?php echo time(); ?>-<?php echo $k['id']; ?></span>
                                                <h4 class="fw-bold text-dark mb-0">Rp 50.000</h4>
                                            </div>
                                            <hr class="text-muted">
                                            <div class="mb-2 small">
                                                <span class="text-muted d-block">Nama Item:</span>
                                                <strong class="text-dark">Voucher Digital <?php echo $k['nama']; ?></strong>
                                            </div>
                                            <div class="mb-2 small">
                                                <span class="text-muted d-block">Metode Simulasi:</span>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle-fill"></i> Snap API Automated Sandbox</span>
                                            </div>
                                            <div class="mb-4 small">
                                                <span class="text-muted d-block">Pelanggan:</span>
                                                <strong class="text-dark">Moorlaila (moorlaila@student.dinus.ac.id)</strong>
                                            </div>

                                            <div class="alert alert-info py-2 small border-0 mb-0">
                                                <i class="bi bi-info-circle-fill me-1"></i> Modul transaksi Payment Gateway (Midtrans) dikonfigurasi sukses untuk demo tugas Pemrograman Web Lanjut.
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-3 bg-light">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-primary btn-sm px-3" onclick="alert('Simulasi Transaksi Berhasil! Kode voucher otomatis dikirimkan ke email.'); $('#modalVoucher<?php echo $k['id']; ?>').modal('hide');">Bayar Sekarang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-muted py-4">Data kuliner belum tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([-7.0, 110.4], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        setTimeout(() => map.invalidateSize(), 500);

        <?php foreach ($kuliner as $k): ?>
            <?php if (!empty($k['lat']) && !empty($k['lng'])): ?>
                L.marker([<?php echo $k['lat']; ?>, <?php echo $k['lng']; ?>])
                    .addTo(map)
                    .bindPopup("<b><?php echo addslashes($k['nama']); ?></b><br><?php echo addslashes($k['alamat']); ?>");
            <?php endif; ?>
        <?php endforeach; ?>
    });
</script>

<?php echo $this->endSection(); ?>
=======
<!-- Tombol Tambah -->
<a href="<?= base_url('kategori/create'); ?>" class="btn btn-primary mb-3">
    + Tambah Kategori
</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th width="50">No</th>
            <th>Nama Kategori</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>

    <tbody>

        <?php if (!empty($kategori)): ?>

            <?php $no = 1; ?>

            <?php foreach ($kategori as $k): ?>

                <tr>

                    <!-- Nomor -->
                    <td><?= $no++; ?></td>

                    <!-- Nama Kategori -->
                    <td><?= esc($k['nama_kategori']); ?></td>

                    <!-- Tombol Aksi -->
                    <td>

                        <!-- Tombol Edit -->
                        <a href="<?= base_url('kategori/edit/' . $k['id_kategori']); ?>"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <!-- Tombol Hapus -->
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
>>>>>>> 053b1fb2a1721913e229d94d0271865be1200e3a
