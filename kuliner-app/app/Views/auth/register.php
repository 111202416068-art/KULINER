<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>Register - Culinary</title>
    
    <style>
        body {
            background-color: #FDFBF7; /* Warna hangat off-white (Earth Tone Base) */
            font-family: "Plus Jakarta Sans", sans-serif;
            color: #4A3E3D;
        }

        .card-register {
            border: none !important;
            border-radius: 24px !important; /* Membuat sudut box tumpul manis */
            background-color: #FFFFFF;
            box-shadow: 0 10px 30px rgba(140, 98, 57, 0.06) !important;
        }

        .form-control:focus {
            border-color: #8C6239 !important;
            box-shadow: 0 0 0 0.25rem rgba(140, 98, 57, 0.15) !important;
        }

        /* 🎨 CUSTOM BUTTONS TEMA BUMI HANGAT */
        .btn-moka {
            background-color: #8C6239 !important;
            border-color: #8C6239 !important;
            color: #FFFFFF !important;
            border-radius: 12px;
            padding: 10px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-moka:hover {
            background-color: #734F2D !important;
            box-shadow: 0 4px 12px rgba(115, 79, 45, 0.2) !important;
        }

        /* 🍳 ANIMASI MAKANAN BERGERAK (FLOATING ANIMATION) */
        .animated-food-box {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 24px;
            color: #E6A15C; /* Warna Terracotta Pastel */
        }

        .food-icon-1 { animation: floatAnim 3s ease-in-out infinite; }
        .food-icon-2 { animation: floatAnim 3s ease-in-out infinite 0.7s; }
        .food-icon-3 { animation: floatAnim 3s ease-in-out infinite 1.4s; }

        @keyframes floatAnim {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .text-moka {
            color: #8C6239 !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4 px-4">
                <div class="card card-register p-4 my-4">
                    
                    <div class="text-center mb-4">
                        <div class="animated-food-box">
                            <i class="bi bi-egg-fried food-icon-1"></i>
                            <i class="bi bi-cup-hot-fill food-icon-2"></i>
                            <i class="bi bi-cake2-fill food-icon-3"></i>
                        </div>
                        <h2 class="fw-bold text-moka mb-1" style="letter-spacing: -1px;">Culinary.</h2>
                        <p class="text-muted small">Buat akun untuk mulai mengulas kuliner</p>
                    </div>

                    <form action="<?= base_url('auth/prosesRegister'); ?>" method="post">
                        <?= csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-card-text"></i></span>
                                <input type="text" name="nama_lengkap" class="form-control" style="border-radius: 0 12px 12px 0;" placeholder="Nama lengkap Anda" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control" style="border-radius: 0 12px 12px 0;" placeholder="username_baru" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" style="border-radius: 0 12px 12px 0;" placeholder="******" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-moka w-100 mb-2 shadow-sm">
                            <i class="bi bi-person-plus me-1"></i> Daftar Akun
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">Sudah punya akun? </small>
                            <a href="<?= base_url('auth/login'); ?>" class="fw-bold text-moka text-decoration-none small">Login</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>