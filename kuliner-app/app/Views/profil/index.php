<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Profil Saya</h1>
</div>

<section class="section profile">
    <div class="row">

        <!-- FOTO PROFIL -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center pt-4">
                    <img src="<?= base_url('assets/img/profile-img.jpg'); ?>" 
                         alt="Profile" class="rounded-circle" width="120">
                    
                    <h4 class="mt-3"><?= $nama ?? 'Tidak ada nama'; ?></h4>
                    <p class="text-muted"><?= $role ?? '-'; ?></p>
                </div>
            </div>
        </div>

        <!-- DETAIL PROFIL -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">

                    <h5 class="card-title">Detail Profil</h5>

                    <div class="row mb-3">
                        <div class="col-lg-3 fw-bold">Nama</div>
                        <div class="col-lg-9"><?= $nama ?? '-' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3 fw-bold">Email</div>
                        <div class="col-lg-9"><?= $email ?? '-' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3 fw-bold">Role</div>
                        <div class="col-lg-9"><?= $role ?? '-' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3 fw-bold">Bio</div>
                        <div class="col-lg-9"><?= $bio ?? '-' ?></div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection(); ?>