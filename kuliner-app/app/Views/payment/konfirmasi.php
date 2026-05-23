<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Konfirmasi Pesanan Voucher</h1>
        <p class="text-muted small">Tinjau kembali detail item kuliner dan lengkapi data pengiriman kode voucher digital</p>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <img src="/uploads/<?= $kuliner['foto'] ?? 'default.jpg'; ?>" class="card-img-top" style="height: 220px; object-fit: cover;">
                <div class="card-body p-4">
                    <span class="badge-kategori mb-2 d-inline-block">Voucher Pilihan</span>
                    <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($kuliner['nama']); ?></h4>
                    <p class="text-muted small mb-0"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= htmlspecialchars($kuliner['alamat']); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="bi bi-shield-check text-moka me-1"></i> Formulir Klaim Keamanan</h5>

                <form action="/payment/proses/<?= $kuliner['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nominal Per Voucher (Rp)</label>
                        <input type="number" name="nominal" class="form-control rounded-3 bg-light font-monospace fw-bold text-moka" value="<?= $kuliner['harga_voucher'] ?? 50000; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Jumlah Kupon Belanja</label>
                        <select name="jumlah" class="form-select rounded-3 font-monospace fw-bold" required>
                            <option value="1">1 Lembar Kupon</option>
                            <option value="2">2 Lembar Kupon</option>
                            <option value="3">3 Lembar Kupon</option>
                            <option value="4">4 Lembar Kupon</option>
                            <option value="5">5 Lembar Kupon</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">Nomor WhatsApp Aktif Notifikasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-whatsapp text-success fw-bold"></i></span>
                            <input type="text" name="whatsapp" class="form-control font-monospace fw-bold" style="border-radius: 0 12px 12px 0;" placeholder="Contoh: 0812xxxxxxx" required>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">*Kode QR keamanan tiket belanja akan langsung ditembakkan ke nomor WA ini setelah bayar lunas.</small>
                    </div>

                    <div class="text-end border-top pt-3">
                        <a href="/jelajah" class="btn btn-outline-secondary px-4 fw-bold me-2">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                            <i class="bi bi-wallet2 me-1"></i> Amankan & Bayar Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .text-moka { color: #8C6239 !important; }
    .badge-kategori {
        background-color: #F5EBE6;
        color: #8C6239;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid #E6D5CC;
    }
    .form-control:focus, .form-select:focus {
        border-color: #8C6239 !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 98, 57, 0.15) !important;
    }
</style>

<?= $this->endSection(); ?>