<?php echo $this->extend('layout/template'); ?>
<?php echo $this->section('content'); ?>

<div class="row justify-content-center py-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white fw-bold text-primary py-3 border-bottom">
                <i class="bi bi-cart-check-fill me-1"></i> Konfirmasi Pembelian Voucher
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4 bg-light p-3 rounded">
                    <img src="/uploads/<?php echo $kuliner['foto'] ?? 'default.jpg'; ?>" width="80" height="60" style="object-fit:cover; border-radius:6px;" class="me-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1"><?php echo $kuliner['nama']; ?></h5>
                        <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger"></i> <?php echo $kuliner['alamat']; ?></small>
                    </div>
                </div>

                <form action="/payment/proses/<?php echo $kuliner['id']; ?>" mercantile-id="form-konfirmasi" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Pilih Paket Voucher</label>
                        <select name="nominal" class="form-select">
                            <option value="50000">Voucher Makan Hemat - Rp 50.000</option>
                            <option value="100000">Voucher Makan Puas - Rp 100.000</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">Jumlah Voucher</label>
                        <input type="number" name="jumlah" class="form-control" value="1" min="1" max="5">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong kirim kode unik cepat ya..."></textarea>
                    </div>

                    <div class="alert alert-warning py-2 small border-0 mb-4">
                        <i class="bi bi-shield-lock-fill me-1"></i> Pembayaran akan diproses aman melalui Midtrans Sandbox Simulator.
                    </div>

                    <div class="d-flex gap-2">
                        <a href="/kuliner" class="btn btn-light w-50 fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary w-50 fw-semibold">Lanjut Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>