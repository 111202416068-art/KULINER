<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>Login - Culinary Admin</title>
    <style>
        body {
            background-color: #f6f9ff;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0 20px rgba(1, 41, 112, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Culinary</h3>
                        <p class="text-muted small">Masukkan username & password</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger small py-2">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success small py-2">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/prosesLogin'); ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">Belum punya akun? </small>
                            <a href="<?= base_url('auth/register'); ?>" class="btn btn-outline-secondary btn-sm w-100 mt-2 fw-semibold">
                                <i class="bi bi-pencil-square"></i> Buat Akun Baru (Register)
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>