<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, #F5EBE6 0%, #E6D5CC 100%);">
        <h1 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Mau Kulineran Hemat Di Mana Hari Ini, <?= session()->get('username') ?? 'Laila'; ?>? 🏷️</h1>
        <p class="text-muted small mb-0">Temukan tempat makan favorit, cek ulasan rating tepercaya, dan dapatkan voucher diskon terbaikmu!</p>
    </div>

    <div class="mb-5 bg-white p-4 shadow-sm rounded-4 border border-light">
        <h6 class="fw-bold text-secondary small mb-3 text-uppercase text-center" style="letter-spacing: 0.5px;">
            <i class="bi bi-grid-fill text-moka me-1"></i> Pilih Kategori Kuliner
        </h6>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 filter-btn fw-semibold" onclick="filterKategori('all')">
                <i class="bi bi-egg-fried me-1"></i> Semua
            </button>

            <?php if (!empty($kategori)): ?>
                <?php foreach ($kategori as $kat): ?>
                    <?php
                    $namaKat = htmlspecialchars_decode($kat['nama_kategori']);
                    $icon = 'bi-bookmark-star-fill';

                    if (stripos($namaKat, 'cafe') !== false || stripos($namaKat, 'kopi') !== false) $icon = 'bi-cup-hot-fill text-danger';
                    elseif (stripos($namaKat, 'restoran') !== false || stripos($namaKat, 'eat') !== false) $icon = 'bi-building-fill text-info';
                    elseif (stripos($namaKat, 'street') !== false || stripos($namaKat, 'warung') !== false || stripos($namaKat, 'warmindo') !== false) $icon = 'bi-shop text-warning';
                    elseif (stripos($namaKat, 'oleh') !== false || stripos($namaKat, 'bakery') !== false) $icon = 'bi-bag-heart-fill text-success';
                    elseif (stripos($namaKat, 'mie') !== false || stripos($namaKat, 'bakso') !== false) $icon = 'bi-bowl-fill text-secondary';
                    ?>
                    <button type="button" class="btn btn-outline-moka btn-sm rounded-pill px-4 filter-btn fw-semibold" onclick="filterKategori('<?= addslashes(htmlspecialchars(trim($namaKat))); ?>')">
                        <i class="bi <?= $icon; ?> me-1"></i> <?= htmlspecialchars($namaKat); ?>
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <hr class="opacity-25 mb-4" style="color: #8C6239;">

    <div class="row" id="kuliner-container">
        <?php if (!empty($kuliner)): ?>
            <?php foreach ($kuliner as $k): ?>
                <div class="col-md-4 mb-4 kuliner-item" data-kategori="<?= htmlspecialchars(trim($k['nama_kategori'] ?? '-')); ?>">
                    <div class="card h-100 shadow-sm border-0 card-kuliner overflow-hidden">
                        <div class="position-relative">
                            <img src="/uploads/<?= $k['foto'] ?? 'default.jpg'; ?>" class="card-img-top" style="height: 210px; object-fit: cover;">
                            <span class="badge-terracotta position-absolute top-0 end-0 m-3 shadow-sm py-1.5 px-3 fw-bold small rounded-pill">
                                <?= htmlspecialchars($k['nama_kategori'] ?? 'Umum'); ?>
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.3px;"><?= htmlspecialchars($k['nama']); ?></h5>
                            <p class="card-text text-muted small mb-4">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= htmlspecialchars($k['alamat']); ?>
                            </p>

                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('jelajah/detail/' . $k['id']); ?>" class="btn btn-moka-action btn-sm fw-bold">
                                        <i class="bi bi-star-fill me-1 text-warning"></i> Lihat & Ulas Resto
                                    </a>

                                    <?php if (isset($k['harga_voucher']) && (int)$k['harga_voucher'] > 0): ?>
                                        <a href="<?= base_url('payment/beli/' . $k['id']); ?>" class="btn btn-terracotta-action btn-sm fw-bold">
                                            <i class="bi bi-ticket-perforated-fill me-1"></i> Beli Voucher (Rp<?= number_format($k['harga_voucher'], 0, ',', '.'); ?>)
                                        </a>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-light btn-sm fw-bold text-muted border py-1.5" disabled style="border-radius: 12px; font-size: 13px;">
                                            <i class="bi bi-patch-exclamation me-1 text-secondary"></i> Tidak Ada Voucher
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-light border text-center py-5 text-muted rounded-4">
                    <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i> Menu makanan belum tersedia di direktori.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function filterKategori(kategori) {
        const items = document.querySelectorAll('.kuliner-item');

        items.forEach(item => {
            const itemKategori = item.getAttribute('data-kategori').trim();
            if (kategori === 'all' || itemKategori === kategori) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-moka');
        });

        event.currentTarget.classList.remove('btn-outline-moka');
        event.currentTarget.classList.add('btn-primary');
    }
</script>

<style>
    .card-kuliner {
        border-radius: 20px !important;
        background-color: #FFFFFF;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 4px 18px rgba(140, 98, 57, 0.04) !important;
    }

    .card-kuliner:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(140, 98, 57, 0.1) !important;
    }

    .btn-primary,
    .btn-primary:active,
    .btn-primary:focus {
        background-color: #8C6239 !important;
        border-color: #8C6239 !important;
        color: #FFFFFF !important;
    }

    .btn-primary:hover {
        background-color: #734F2D !important;
        border-color: #734F2D !important;
    }

    .btn-outline-moka {
        border: 1px solid #E6D5CC;
        color: #8C6239;
        background-color: transparent;
        transition: 0.2s;
    }

    .btn-outline-moka:hover {
        background-color: #FDF5EE;
        color: #8C6239;
        border-color: #8C6239;
    }

    .btn-moka-action {
        background-color: #8C6239;
        color: #FFFFFF;
        border: none;
        border-radius: 12px;
        padding: 8px;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-moka-action:hover {
        background-color: #734F2D;
        color: #FFFFFF;
    }

    .btn-terracotta-action {
        background-color: #E6A15C;
        color: #FFFFFF;
        border: none;
        border-radius: 12px;
        padding: 8px;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-terracotta-action:hover {
        background-color: #CC8743;
        color: #FFFFFF;
    }

    .badge-terracotta {
        background-color: #FDF5EE;
        color: #CC8743;
        border: 1px solid #FADCC3;
    }
</style>

<?= $this->endSection(); ?>