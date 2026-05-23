<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
$sessionNama  = session()->get('nama_lengkap') ?? session()->get('username') ?? 'User Culinary';
$sessionEmail = session()->get('email') ?? (session()->get('username') . '@student.dinus.ac.id');
$sessionRole  = session()->get('role') === 'admin' ? 'Administrator' : 'Pengguna Kontributor';
$sessionBio   = session()->get('role') === 'admin' ? 'Pengelola pusat data direktori kuliner nusantara.' : 'Pencinta kuliner aktif pemburu voucher diskon hemat.';
?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Pusat Akun & Pengaturan</h1>
        <p class="text-muted small">Kelola informasi data diri, perbarui sandi, atau atur preferensi akun kulinermu</p>
    </div>

    <div class="row">
        <div class="col-xl-4 mb-4">
            <div class="card shadow-sm border-0 card-estetik text-center p-4">
                <div class="card-body pt-3">
                    <div class="avatar-lingkaran mx-auto mb-3 shadow-sm d-flex align-items-center justify-content-center bg-moka text-white fw-bold fs-2">
                        <?= strtoupper(substr($sessionNama, 0, 1)); ?>
                    </div>
                    
                    <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.3px;"><?= htmlspecialchars($sessionNama); ?></h4>
                    <span class="badge badge-terracotta px-3 py-1.5 rounded-pill small fw-semibold mb-3">
                        <?= $sessionRole; ?>
                    </span>
                    <p class="text-muted small mb-0">Terdaftar sejak: Mei 2026</p>
                </div>
            </div>
        </div>

        <div class="col-xl-8 mb-4">
            <div class="card shadow-sm border-0 card-estetik p-4">
                <div class="card-body pt-2">
                    
                    <ul class="nav nav-tabs nav-tabs-bordered mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold small text-uppercase" id="overview-tab" data-bs-toggle="tab" data-bs-target="#profile-overview" type="button" role="tab" aria-selected="true">
                                <i class="bi bi-person-badge me-1"></i> Detail
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold small text-uppercase" id="edit-tab" data-bs-toggle="tab" data-bs-target="#profile-edit" type="button" role="tab" aria-selected="false">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profil
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold small text-uppercase" id="settings-tab" data-bs-toggle="tab" data-bs-target="#profile-settings" type="button" role="tab" aria-selected="false">
                                <i class="bi bi-gear me-1"></i> Pengaturan
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="profileTabContent">
                        
                        <div class="tab-pane fade show active" id="profile-overview" role="tabpanel" aria-labelledby="overview-tab">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-moka me-1"></i> Informasi Akun Terdaftar</h6>
                            
                            <div class="row align-items-center mb-3 py-2 border-bottom border-light">
                                <div class="col-lg-3 text-secondary small fw-bold text-uppercase">Nama Lengkap</div>
                                <div class="col-lg-9 text-dark fw-semibold"><?= htmlspecialchars($sessionNama); ?></div>
                            </div>

                            <div class="row align-items-center mb-3 py-2 border-bottom border-light">
                                <div class="col-lg-3 text-secondary small fw-bold text-uppercase">Alamat Email</div>
                                <div class="col-lg-9 text-dark fw-semibold"><?= htmlspecialchars($sessionEmail); ?></div>
                            </div>

                            <div class="row align-items-center mb-3 py-2 border-bottom border-light">
                                <div class="col-lg-3 text-secondary small fw-bold text-uppercase">Bio Singkat</div>
                                <div class="col-lg-9 text-muted small">"<?= htmlspecialchars($sessionBio); ?>"</div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile-edit" role="tabpanel" aria-labelledby="edit-tab">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders text-moka me-1"></i> Perbarui Data Diri</h6>
                            
                            <form action="<?= base_url('profil/update'); ?>" method="post">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control rounded-3" value="<?= htmlspecialchars($sessionNama); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Ubah Email</label>
                                    <input type="email" name="email" class="form-control rounded-3" value="<?= htmlspecialchars($sessionEmail); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary">Password Baru (Kosongkan jika tidak diubah)</label>
                                    <input type="password" name="password" class="form-control rounded-3" placeholder="••••••••">
                                </div>
                                <button type="submit" class="btn btn-moka-action px-4 fw-bold shadow-sm" onclick="alert('Simpan Perubahan Profil Berhasil!')">
                                    <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                                </button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="profile-settings" role="tabpanel" aria-labelledby="settings-tab">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock text-danger me-1"></i> Area Sensitif Akun</h6>
                            
                            <div class="alert alert-warning border-0 rounded-4 p-3 mb-4 small">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> <strong>Peringatan Keamanan:</strong> Menghapus akun akan menghapus seluruh riwayat ulasan kuliner, klaim voucher, serta data transaksi sandbox permanen dari database.
                            </div>

                            <div class="d-flex align-items-center justify-content-between p-3 border rounded-4 bg-light">
                                <div>
                                    <strong class="text-dark d-block small">Tutup / Deaktivasi Akun Permanen</strong>
                                    <span class="text-muted style" style="font-size: 11px;">Hapus seluruh data pendaftaran kamu dari instansi server.</span>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm fw-bold px-3 rounded-3" onclick="if(confirm('Apakah Anda yakin 100% ingin menghapus akun ini secara permanen dari database?')) { alert('Akun berhasil dihapus. Anda akan dialihkan ke halaman register.'); window.location.href='<?= base_url('auth/logout'); ?>'; }">
                                    <i class="bi bi-trash3-fill me-1"></i> Hapus Akun
                                </button>
                            </div>
                        </div>

                    </div> </div>
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
    
    .avatar-lingkaran {
        width: 95px;
        height: 95px;
        border-radius: 50%;
        border: 4px solid #F5EBE6;
    }

    /* Kustomisasi Tampilan Nav Tabs agar Selaras Moka */
    .nav-tabs-bordered .nav-link {
        margin-bottom: -1px;
        border: none;
        color: #615352;
        background: transparent;
        padding: 10px 20px;
        font-size: 13px;
        transition: 0.2s;
    }
    .nav-tabs-bordered .nav-link.active {
        color: #8C6239;
        border-bottom: 2px solid #8C6239;
    }
    .nav-tabs-bordered .nav-link:hover {
        color: #8C6239;
    }

    .text-moka { color: #8C6239 !important; }
    .bg-moka { background-color: #8C6239 !important; }

    .badge-terracotta {
        background-color: #FDF5EE;
        color: #CC8743;
        border: 1px solid #FADCC3;
        font-size: 12px;
    }

    .btn-moka-action {
        background-color: #8C6239;
        color: #FFFFFF;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-size: 14px;
        transition: 0.2s;
    }
    .btn-moka-action:hover {
        background-color: #734F2D;
        color: #FFFFFF;
    }
</style>

<?= $this->endSection(); ?>