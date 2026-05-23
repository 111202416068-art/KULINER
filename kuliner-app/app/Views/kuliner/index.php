<?php echo $this->extend('layout/template'); ?>
<?php echo $this->section('content'); ?>
<?php
$kuliner = $kuliner ?? [];
$totalReview = $totalReview ?? 0;
$rataRating = $rataRating ?? 0;
$cuaca = $cuaca ?? ['desc' => '-', 'temp' => '-', 'humidity' => '-'];
?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Dashboard Direktori Kuliner</h1>
        <p class="text-muted small">Ringkasan pengolahan sistem informasi geografis direktori dan pemetaan data kuliner</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 border-start border-moka border-4 h-100">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Lokasi</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo count($kuliner); ?> Tempat</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 border-start border-terracotta border-4 h-100">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Review</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo $totalReview; ?> Ulasan</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Rata-rata Rating</h6>
                    <h3 class="fw-bold mb-0 text-warning">⭐ <?php echo number_format($rataRating, 1); ?> <span class="text-muted fs-6 fw-normal">/ 5.0</span></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0 bg-light-warm">
        <div class="card-body d-flex align-items-center justify-content-between p-3.5">
            <div>
                <h6 class="text-muted small fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px;"><i class="bi bi-cloud-sun-fill text-terracotta me-1"></i> Monitor Cuaca Kota Sekarang</h6>
                <span class="fw-bold text-dark fs-5"><?php echo $cuaca['desc'] ?? '-'; ?></span>
            </div>
            <div class="text-end">
                <span class="badge bg-moka fs-7 p-2 px-3 rounded-pill me-1">Suhu: <?php echo $cuaca['temp'] ?? '-'; ?></span>
                <span class="badge bg-secondary-warm fs-7 p-2 px-3 rounded-pill">Kelembapan: <?php echo $cuaca['humidity'] ?? '-'; ?></span>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom fw-bold text-moka py-3">
            <i class="bi bi-geo-alt-fill text-terracotta me-1"></i> Peta Visual Lokasi Direktori Kuliner
        </div>
        <div class="card-body p-3">
            <div id="map" style="height:350px; border-radius:14px; border: 1px solid #F5EBE6;"></div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body p-3">
            <form method="get">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-light-subtle"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control rounded-end-3" placeholder="Cari nama atau wilayah kuliner..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-light-subtle"><i class="bi bi-tags"></i></span>
                            <select name="kategori" class="form-select rounded-end-3">
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
                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="bi bi-sliders me-1"></i> Saring Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold text-moka py-3 border-bottom">
            <i class="bi bi-table text-terracotta me-1"></i> Data Riwayat Inventaris Tempat Makan
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th width="5%">No</th>
                            <th>Visual</th>
                            <th>Identitas Kuliner</th>
                            <th>Kategori</th>
                            <th>Rating Komunitas</th>
                            <th>Review Inti</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark small fw-semibold">
                        <?php if (!empty($kuliner)): ?>
                            <?php $no = 1; foreach ($kuliner as $k): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <img src="/uploads/<?php echo $k['foto'] ?? 'default.jpg'; ?>" width="75" height="55" style="object-fit:cover; border-radius:10px;" class="shadow-sm">
                                    </td>
                                    <td class="text-start">
                                        <b class="text-dark d-block mb-0"><?php echo $k['nama']; ?></b>
                                        <small class="text-muted"><i class="bi bi-geo-alt text-danger"></i> <?php echo $k['alamat']; ?></small>
                                    </td>
                                    <td>
                                        <span class="badge-kategori-tabel"><?php echo $k['nama_kategori'] ?? '-'; ?></span>
                                    </td>
                                    <td>
                                        <div class="text-warning text-nowrap" title="Rating: <?php echo $k['rating'] ?? 0; ?>">
                                            <?php echo render_bintang($k['rating'] ?? 0); ?>
                                            <small class="text-muted ms-1 text-dark">(<?php echo number_format($k['rating'] ?? 0, 1); ?>)</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted italic">"<?php echo htmlspecialchars($k['review_text'] ?? '-'); ?>"</small>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if (!empty($k['lat'])): ?>
                                                <a href="https://maps.google.com/?q=<?php echo $k['lat']; ?>,<?php echo $k['lng']; ?>" target="_blank" class="btn btn-action-geo btn-sm" title="Google Maps">
                                                    <i class="bi bi-geo-alt"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="/jelajah/detail/<?php echo $k['id']; ?>" class="btn btn-action-view btn-sm" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <?php if (session()->get('role') === 'admin'): ?>
                                                <a href="/kuliner/edit/<?php echo $k['id']; ?>" class="btn btn-action-edit btn-sm" title="Ubah">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/kuliner/delete/<?php echo $k['id']; ?>" class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Yakin hapus data kuliner ini?')" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-muted py-5 rounded-4">
                                    <i class="bi bi-inbox d-block fs-2 text-muted mb-2"></i> Data kuliner belum tersedia di pusat database.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .border-moka { border-color: #8C6239 !important; }
    .border-terracotta { border-color: #E6A15C !important; }
    .text-terracotta { color: #E6A15C !important; }
    .bg-moka { background-color: #8C6239 !important; }
    
    .bg-light-warm {
        background-color: #FDF5EE !important;
        border: 1px solid #FADCC3;
        border-radius: 14px;
    }
    .badge-kategori-tabel {
        background-color: #F5EBE6;
        color: #8C6239;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid #E6D5CC;
    }
    .bg-secondary-warm {
        background-color: #BE9B7B !important;
        color: white !important;
    }

    /* Kustomisasi Desain Tombol Aksi */
    .btn-action-geo { background-color: #198754; color: white; border-radius: 8px; border: none; }
    .btn-action-geo:hover { background-color: #146c43; color: white; }
    
    .btn-action-view { background-color: #BE9B7B; color: white; border-radius: 8px; border: none; }
    .btn-action-view:hover { background-color: #a78364; color: white; }
    
    .btn-action-edit { background-color: #8C6239; color: white; border-radius: 8px; border: none; }
    .btn-action-edit:hover { background-color: #734F2D; color: white; }
</style>

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