<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php $kuliner = $kuliner ?? []; ?>

<div class="pagetitle mb-4">
    <h1 class="fw-bold text-primary">Dashboard Kuliner</h1>
</div>

<!-- CARD STATISTIK - Rapi & Sejajar -->
<div class="row mb-4">

    <!-- Card Total Lokasi -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
            <div class="card-body p-3">
                <h6 class="text-muted small fw-bold text-uppercase">Total Lokasi</h6>
                <h3 class="fw-bold mb-0"><?= count($kuliner); ?> Tempat</h3>
            </div>
        </div>
    </div>

    <!-- Card Total Review -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
            <div class="card-body p-3">
                <h6 class="text-muted small fw-bold text-uppercase">Total Review</h6>
                <h3 class="fw-bold mb-0"><?= $totalReview ?? 0; ?> Review</h3>
            </div>
        </div>
    </div>

    <!-- Card Rata-rata Rating -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
            <div class="card-body p-3 text-center">
                <h6 class="text-muted small fw-bold text-uppercase text-start">Rata-rata Rating</h6>
                <h3 class="fw-bold mb-0 text-warning">⭐ <?= number_format($rataRating ?? 0, 1); ?></h3>
            </div>
        </div>
    </div>

</div>

<!-- MAP -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">
        <i class="bi bi-geo-alt-fill"></i> Peta Lokasi
    </div>
    <div class="card-body">
        <div id="map" style="height:380px; border-radius:10px;"></div>
    </div>
</div>

<!-- FILTER -->
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <form method="get" class="row g-2">

            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama / alamat..."
                    value="<?= $_GET['search'] ?? '' ?>">
            </div>

            <div class="col-md-4">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori ?? [] as $k): ?>
                        <option value="<?= $k['id_kategori']; ?>"
                            <?= (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : ''; ?>>
                            <?= $k['nama_kategori']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>

        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold text-primary">
        <i class="bi bi-table"></i> Data Kuliner
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">

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

                                <td><?= $no++; ?></td>

                                <td>
                                    <img src="/uploads/<?= $k['foto'] ?? 'default.jpg'; ?>"
                                        width="70" height="50"
                                        style="object-fit:cover; border-radius:6px;">
                                </td>

                                <td class="text-start">
                                    <b><?= $k['nama']; ?></b><br>
                                    <small class="text-muted"><?= $k['alamat']; ?></small>
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        <?= $k['nama_kategori'] ?? '-'; ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-warning text-dark">
                                        ⭐ <?= $k['rating']; ?>
                                    </span>
                                </td>

                                <td>
                                    <small>
                                        <?= !empty($k['review']) ? $k['review'] : '-'; ?>
                                    </small>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">

                                        <?php if (!empty($k['lat'])): ?>
                                            <a href="https://www.google.com/maps?q=<?= $k['lat']; ?>,<?= $k['lng']; ?>"
                                                target="_blank"
                                                class="btn btn-success btn-sm">
                                                <i class="bi bi-geo-alt"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="/kuliner/detail/<?= $k['id']; ?>"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <?php if (session()->get('role') != 'pengunjung'): ?>

                                            <a href="/kuliner/edit/<?= $k['id']; ?>"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="/kuliner/delete/<?= $k['id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus?')">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="7">Data belum ada</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- MAP SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var map = L.map('map').setView([-7.0, 110.4], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        setTimeout(() => map.invalidateSize(), 500);

        <?php foreach ($kuliner as $k): ?>
            <?php if (!empty($k['lat']) && !empty($k['lng'])): ?>
                L.marker([<?= $k['lat']; ?>, <?= $k['lng']; ?>])
                    .addTo(map)
                    .bindPopup("<b><?= $k['nama']; ?></b><br><?= $k['alamat']; ?>");
            <?php endif; ?>
        <?php endforeach; ?>

    });
</script>

<?= $this->endSection(); ?>