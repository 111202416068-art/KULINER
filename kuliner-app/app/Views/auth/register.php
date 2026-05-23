<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Culinary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Open Sans', sans-serif; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card shadow border-0 p-4" style="width: 400px; border-radius: 12px;">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary mb-1">Culinary</h3>
        <p class="text-muted small">Buat akun untuk mulai mengulas kuliner</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <form action="<?= base_url('auth/saveRegister'); ?>" method="post">
        <div class="mb-3">
            <label class="form-label small fw-bold">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required placeholder="Nama lengkap Anda">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="username_baru">
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="******">
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold my-2">Daftar Akun</button>
        <div class="text-center mt-3">
            <small class="text-muted">Sudah punya akun? <a href="<?= base_url('auth/login'); ?>" class="text-decoration-none fw-bold">Login</a></small>
        </div>
    </form>
</div>

</body>
</html>