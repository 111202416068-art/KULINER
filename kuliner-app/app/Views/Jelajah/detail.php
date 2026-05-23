<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-3">
    <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 12px;">
        <h2 class="fw-bold text-primary mb-1"><?= isset($kuliner['nama']) ? htmlspecialchars($kuliner['nama']) : 'Nama Kuliner'; ?></h2>
        <p class="text-muted mb-0"><i class="bi bi-geo-alt-fill text-danger"></i> <?= isset($kuliner['alamat']) ? htmlspecialchars($kuliner['alamat']) : 'Alamat tidak tersedia'; ?></p>
    </div>

    <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 12px;">
        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-chat-left-text-fill text-primary me-1"></i> Ulasan Komunitas</h5>
        <hr class="mt-0">

        <?php if (isset($review) && !empty($review)): ?>
            <div class="row">
                <?php foreach ($review as $r): ?>
                    <div class="col-12 mb-2">
                        <div class="bg-light p-3 rounded shadow-sm border-start border-warning border-3">
                            <div class="text-warning mb-1">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi <?= $i <= $r['rating'] ? 'bi-star-fill' : 'bi-star'; ?>"></i>
                                <?php endfor; ?>
                                <span class="text-dark small fw-bold ms-1">(<?= $r['rating']; ?>.0)</span>
                            </div>
                            <p class="text-dark mb-0 small fw-semibold">"<?= htmlspecialchars($r['isi']); ?>"</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center text-muted py-3 mb-0">
                <i class="bi bi-chat-square-dots fs-3 d-block mb-1"></i> Belum ada ulasan untuk tempat ini.
            </div>
        <?php endif; ?>
    </div>

    <?php if (session()->get('role') === 'user'): ?>
        <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-success me-1"></i> Berikan Ulasan Anda</h5>
            <hr class="mt-0">

            <form action="<?= base_url('review/save'); ?>" method="post">
                <input type="hidden" name="kuliner_id" value="<?= isset($kuliner['id']) ? $kuliner['id'] : ''; ?>">

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Pilih Penilaian Bintang</label>
                    <select name="rating" class="form-select" style="max-width: 250px;" required>
                        <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                        <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                        <option value="3">⭐⭐⭐ (Biasa Saja)</option>
                        <option value="2">⭐⭐ (Kurang Puas)</option>
                        <option value="1">⭐ (Buruk)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Tuliskan Komentar / Review</label>
                    <textarea name="isi" class="form-control" rows="3" required placeholder="Ceritakan ulasan rasa hidangan atau suasana pelayanan tempat ini..."></textarea>
                </div>

                <button type="submit" class="btn btn-success fw-bold px-4 shadow-sm">
                    <i class="bi bi-send-fill me-1"></i> Terbitkan Ulasan
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>