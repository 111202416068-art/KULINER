<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

                    <?php if (session()->getFlashdata('msg')): ?>
                        <div class="alert alert-danger small">
                            <?= session()->getFlashdata('msg') ?>
                        </div>
                    <?php endif; ?>

                    <form action="/auth/prosesLogin" method="post">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- LOGIN BUTTON -->
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Login
                        </button>

                        <!-- GUEST BUTTON (SUDAH FIX) -->
                        <a href="<?= base_url('pengunjung'); ?>" class="btn btn-secondary w-100 mt-2">
                            Masuk sebagai Pengunjung
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>