<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Riwayat Voucher & Aktivitas</h1>
        <p class="text-muted small">Pantau semua daftar voucher makanan digital yang telah kamu klaim dari database direktori</p>
    </div>

    <div class="card shadow-sm border-0 card-estetik p-4">
        <div class="card-body">
            <h5 class="fw-bold text-dark mb-4"><i class="bi bi-ticket-perforated-fill text-moka me-1"></i> Daftar Voucher Aktif Kamu</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th width="5%">No</th>
                            <th>ID Transaksi</th>
                            <th>Kemitraan Kuliner</th>
                            <th>Total Bayar</th>
                            <th>Status Klaim</th>
                            <th>Tanggal Pembelian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark small fw-semibold">
                        <?php if (!empty($transaksi)): ?>
                            <?php $no = 1; foreach ($transaksi as $t): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><span class="badge bg-light text-dark border font-monospace"><?= $t['order_id']; ?></span></td>
                                    <td>Voucher Diskon - <?= htmlspecialchars($t['nama_kuliner']); ?></td>
                                    <td class="text-moka">Rp <?= number_format($t['nominal'], 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border px-2 py-1 rounded-pill text-uppercase">
                                            <?= $t['status_bayar']; ?>
                                        </span>
                                    </td>
                                    <td class="text-muted small"><?= date('d M Y H:i', strtotime($t['created_at'])); ?> WIB</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm py-1 px-3 fs-7 text-white shadow-sm" onclick="alert('Kode QR Keamanan: <?= $t['order_id']; ?>\n\nSilakan tunjukkan layar HP ini ke kasir outlet <?= htmlspecialchars($t['nama_kuliner']); ?> untuk penukaran diskon makanan!')">
                                      <i class="bi bi-qr-code me-1"></i> Gunakan
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-ticket-detailed d-block fs-3 mb-2"></i> Kamu belum memiliki riwayat pembelian voucher saat ini.
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
    .card-estetik {
        border-radius: 20px !important;
        background-color: #FFFFFF;
        box-shadow: 0 4px 18px rgba(140, 98, 57, 0.04) !important;
    }
    .text-moka { color: #8C6239 !important; }
    .fs-7 { font-size: 12px !important; }
</style>

<?= $this->endSection(); ?>