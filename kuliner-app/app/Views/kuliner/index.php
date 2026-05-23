<?php echo $this->extend('layout/template'); ?>
<?php echo $this->section('content'); ?>
<?php
$kuliner = $kuliner ?? [];
$totalReview = $totalReview ?? 0;
$rataRating = $rataRating ?? 0;
$cuaca = $cuaca ?? ['desc' => '-', 'temp' => '-', 'humidity' => '-'];
?>

<div class="pagetitle mb-4">
    <h1 class="fw-bold text-primary">Dashboard Direktori Kuliner</h1>
</div>

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

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body p-3">
        <form method="get">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau alamat kuliner..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-tags"></i></span>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategori ?? [] as $k): ?>
                                <option value="<?php echo $k['id_kategori']; ?>" <?php echo ((isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori'])) ? 'selected' : ''; ?>>
                                    <?php echo $k['nama_kategori']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-sliders me-1"></i> Filter Data
                    </button>
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
                        <?php $no = 1; foreach ($kuliner as $k): ?>
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
                                    <div class="d-inline-block text-nowrap text-warning" title="Rating: <?php echo $k['rating'] ?? 0; ?>">
                                        <?php echo render_bintang($k['rating'] ?? 0); ?>
                                        <small class="text-muted ms-1 text-dark">(<?php echo number_format($k['rating'] ?? 0, 1); ?>)</small>
                                    </div>
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

                                        <?php if (session()->get('role') === 'admin'): ?>
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