<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, #F5EBE6 0%, #E6D5CC 100%);">
        <span class="badge bg-moka mb-2 px-3 py-1.5 rounded-pill text-uppercase small" style="font-size: 11px; letter-spacing: 0.5px;">📋 Ringkasan Data Master</span>
        <h1 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;"><?= isset($kuliner['nama']) ? htmlspecialchars($kuliner['nama']) : 'Nama tidak tersedia'; ?></h1>
        <p class="text-muted small mb-0"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= isset($kuliner['alamat']) ? htmlspecialchars($kuliner['alamat']) : 'Alamat tidak tersedia'; ?></p>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="bi bi-info-circle-fill text-moka me-1"></i> Informasi Lengkap</h5>
                    <div class="mb-3">
                        <small class="text-secondary d-block fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Garis Lintang (Latitude)</small>
                        <span class="font-monospace text-dark fw-semibold"><?= $kuliner['lat'] ?? '-'; ?></span>
                    </div>
                    <div class="mb-3">
                        <small class="text-secondary d-block fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Garis Bujur (Longitude)</small>
                        <span class="font-monospace text-dark fw-semibold"><?= $kuliner['lng'] ?? '-'; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100">
                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                    <i class="bi bi-chat-square-heart-fill text-terracotta me-1"></i> Ulasan Rekam Jejak Pengunjung
                </h5>

                <div class="review-scroll-box" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                    <?php if (!empty($review)) : ?>
                        <?php foreach ($review as $r): ?>
                            <div class="card card-review mb-3 p-3 border-light-subtle">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark small"><i class="bi bi-person-circle text-moka me-1"></i> Pengguna #<?= $r['user_id']; ?></span>
                                    <span class="text-warning small">
                                        <?php 
                                        $rating = (int)$r['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '★';
                                            } else {
                                                echo '☆';
                                            }
                                        }
                                        ?>
                                        (<?= number_format($r['rating'], 0); ?>)
                                    </span>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.5;">"<?= htmlspecialchars($r['isi']); ?>"</p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-chat-left-text d-block fs-2 mb-2 text-muted"></i> Belum ada ulasan resmi untuk tempat ini.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="text-end border-top pt-3 mt-auto">
                    <a href="/kuliner" class="btn btn-outline-secondary px-4 fw-bold">
                        <i class="bi bi-arrow-left-short"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-moka { background-color: #8C6239 !important; color: white !important; }
    .text-moka { color: #8C6239 !important; }
    .text-terracotta { color: #E6A15C !important; }
    
    .card-review {
        border-radius: 14px !important;
        background-color: #FDFBF7;
        border: 1px solid #F5EBE6 !important;
        transition: 0.2s;
    }
    .card-review:hover {
        background-color: #FFFFFF;
        border-color: #E6D5CC !important;
        box-shadow: 0 4px 12px rgba(140, 98, 57, 0.03);
    }
</style>

<?= $this->endSection(); ?>