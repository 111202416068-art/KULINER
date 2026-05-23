<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Jelajah Resto & Kuliner</h1>
        <p class="text-muted small">Temukan tempat makan favoritmu dan bagikan ulasan terbaikmu </p>
    </div>

    <div class="mb-4 bg-white p-3 shadow-sm rounded-3">
        <h6 class="fw-bold text-secondary small mb-3 text-uppercase "><i class="bi bi-grid-fill text-primary"></i> Pilih Kategori Kuliner</h6>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 filter-btn fw-semibold" onclick="filterKategori('all')">
                <i class="bi bi-egg-fried me-1"></i> Semua Kuliner
            </button>

            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 filter-btn fw-semibold" onclick="filterKategori('Cafe')">
                <i class="bi bi-cup-hot-fill text-danger me-1"></i> Cafe & Kopi
            </button>

            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 filter-btn fw-semibold" onclick="filterKategori('Restoran')">
                <i class="bi bi-building-fill text-info me-1"></i> Restoran
            </button>

            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 filter-btn fw-semibold" onclick="filterKategori('Street Food')">
                <i class="bi bi-shop text-warning me-1"></i> Street Food
            </button>
        </div>
    </div>

    <div class="row" id="kuliner-container">
        <?php if (!empty($kuliner)): ?>
            <?php foreach ($kuliner as $k): ?>
                <div class="col-md-4 mb-4 kuliner-item" data-kategori="<?= htmlspecialchars($k['nama_kategori'] ?? '-'); ?>">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden" style="border-radius: 12px; transition: transform 0.2s;">
                        <div class="position-relative">
                            <img src="/uploads/<?= $k['foto'] ?? 'default.jpg'; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <span class="badge bg-info position-absolute top-0 end-0 m-3 shadow-sm py-2 px-3 fw-bold rounded-pill">
                                <?= htmlspecialchars($k['nama_kategori'] ?? 'Umum'); ?>
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-dark mb-1"><?= htmlspecialchars($k['nama']); ?></h5>
                            <p class="card-text text-muted small mb-3">
                                <i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($k['alamat']); ?>
                            </p>

                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('jelajah/detail/' . $k['id']); ?>" class="btn btn-primary btn-sm fw-bold rounded-3">
                                        <i class="bi bi-star-fill me-1"></i> Lihat & Tulis Ulasan
                                    </a>
                                    <a href="<?= base_url('payment/beli/' . $k['id']); ?>" class="btn btn-warning btn-sm text-dark fw-bold rounded-3">
                                        <i class="bi bi-ticket-perforated-fill me-1"></i> Beli Voucher Diskon
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-light border text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i> Data kuliner belum tersedia.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function filterKategori(kategori) {
        // 1. Ambil semua elemen kartu kuliner
        const items = document.querySelectorAll('.kuliner-item');

        // 2. Saring kartu berdasarkan atribut data-kategori
        items.forEach(item => {
            const itemKategori = item.getAttribute('data-kategori').trim();

            if (kategori === 'all' || itemKategori === kategori) {
                item.style.display = 'block'; // Tampilkan jika cocok
            } else {
                item.style.display = 'none'; // Sembunyikan jika tidak cocok
            }
        });

        // 3. Efek Variasi Tombol Aktif (Mengubah warna tombol yang diklik)
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-secondary');
        });

        // Set tombol yang aktif saat ini menjadi warna biru primary
        event.currentTarget.classList.remove('btn-outline-secondary');
        event.currentTarget.classList.add('btn-primary');
    }
</script>

<style>
    /* Efek Hover cantik saat kartu dilewati kursor mouse */
    .kuliner-item .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<?= $this->endSection(); ?>