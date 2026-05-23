<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= (isset($title)) ? $title : 'Culinary'; ?> | Culinary</title>

  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png'); ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    body {
      background-color: #FDFBF7;
      /* Warna hangat off-white (Earth Tone Base) */
      font-family: "Plus Jakarta Sans", sans-serif;
      color: #4A3E3D;
      overflow-x: hidden;
    }

    .header {
      height: 65px;
      background: #FFFFFF;
      box-shadow: 0 2px 15px rgba(140, 98, 57, 0.05);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 25px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid #F5EBE6;
    }

    .toggle-sidebar-btn {
      font-size: 24px;
      cursor: pointer;
      color: #8C6239;
      margin-left: 15px;
      transition: 0.2s;
    }

    .toggle-sidebar-btn:hover {
      color: #734F2D;
    }

    .sidebar {
      width: 260px;
      height: 100vh;
      position: fixed;
      top: 65px;
      left: 0;
      background: #FFFFFF;
      box-shadow: 4px 0 15px rgba(140, 98, 57, 0.03) !important;
      padding: 25px 20px;
      transition: all 0.3s;
      border-right: 1px solid #F5EBE6;
    }

    #main {
      margin-left: 260px;
      padding: 95px 25px 25px;
      transition: all 0.3s;
    }

    body.toggle-sidebar .sidebar {
      left: -260px;
    }

    body.toggle-sidebar #main {
      margin-left: 0;
    }

    .sidebar-nav {
      list-style: none;
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      padding: 11px 15px;
      color: #615352;
      text-decoration: none;
      border-radius: 12px;
      font-weight: 500;
      font-size: 14px;
      transition: 0.2s;
    }

    .sidebar-nav .nav-link:hover {
      background: #F5EBE6;
      /* Krem hangat saat hover */
      color: #8C6239;
      /* Cokelat moka */
    }

    .sidebar-nav .nav-link i {
      font-size: 18px;
      margin-right: 12px;
      line-height: 0;
    }

    /* UTALITAS TEMA BUMI GLOBAL */
    .text-moka {
      color: #8C6239 !important;
    }

    .bg-moka {
      background-color: #8C6239 !important;
    }

    /* AUTOMATISASI TOMBOL TEMA BUMI */
    .btn-primary {
      background-color: #8C6239 !important;
      border-color: #8C6239 !important;
      color: #FFFFFF !important;
      border-radius: 10px;
      transition: all 0.2s ease;
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
      background-color: #734F2D !important;
      border-color: #734F2D !important;
      box-shadow: 0 4px 12px rgba(115, 79, 45, 0.25) !important;
    }

    .btn-outline-secondary {
      color: #8C6239 !important;
      border-color: #D6C5B3 !important;
      background-color: transparent !important;
      border-radius: 10px;
      transition: all 0.2s ease;
    }

    .btn-outline-secondary:hover,
    .btn-outline-secondary:focus,
    .btn-outline-secondary:active {
      background-color: #F5EBE6 !important;
      border-color: #8C6239 !important;
      color: #8C6239 !important;
    }

    .card {
      border-radius: 16px !important;
      border: none !important;
      box-shadow: 0 4px 18px rgba(140, 98, 57, 0.03) !important;
    }
  </style>
</head>

<body>

  <header class="header">
    <div class="d-flex align-items-center">
      <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo Culinary" class="me-2" style="height: 38px; width: 38px; object-fit: cover; border-radius: 50%;">
      <span class="fw-bold fs-4 text-moka" style="letter-spacing: -0.5px;">Culinary.</span>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="profile d-flex align-items-center bg-light px-3 py-1.5 rounded-pill border">
      <span class="fw-semibold me-2 text-dark small">
        <?= session()->get('role') === 'admin' ? 'Admin' : (session()->get('nama_lengkap') ?? session()->get('username')); ?>
      </span>
      <i class="bi bi-person-circle fs-5 text-moka"></i>
    </div>
  </header>

  <aside class="sidebar">
    <ul class="sidebar-nav">

      <li>
        <a class="nav-link" href="<?= base_url('kuliner'); ?>">
          <i class="bi bi-house-door"></i>Dashboard
        </a>
      </li>

      <li>
        <a class="nav-link" href="<?= base_url('jelajah'); ?>">
          <i class="bi bi-compass"></i>Jelajah Kuliner
        </a>
      </li>

      <li>
        <a class="nav-link" href="<?= base_url('payment/riwayat'); ?>">
          <i class="bi bi-ticket-perforated"></i>Riwayat Voucher
        </a>
      </li>

      <?php if (session()->get('role') === 'admin'): ?>
        <li class="mt-4 mb-1 text-muted px-3 small fw-bold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Manajemen</li>

        <li>
          <a class="nav-link" href="<?= base_url('kuliner/create'); ?>">
            <i class="bi bi-plus-circle"></i>Tambah Kuliner
          </a>
        </li>

        <li>
          <a class="nav-link" href="<?= base_url('kategori'); ?>">
            <i class="bi bi-tags"></i>Kategori
          </a>
        </li>

        <li>
          <a class="nav-link" href="<?= base_url('statistik'); ?>">
            <i class="bi bi-bar-chart-line"></i>Statistik
          </a>
        </li>
      <?php endif; ?>

      <li class="mt-4 mb-1 text-muted px-3 small fw-bold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Pengaturan</li>

      <li>
        <a class="nav-link" href="<?= base_url('profil'); ?>">
          <i class="bi bi-person"></i>Profil
        </a>
      </li>

      <li>
        <a class="nav-link text-danger" href="<?= base_url('auth/logout'); ?>">
          <i class="bi bi-box-arrow-right"></i>Logout
        </a>
      </li>

    </ul>
  </aside>

  <main id="main">
    <div class="container-fluid">
      <?= $this->renderSection('content'); ?>
    </div>
  </main>

  <script>
    document.querySelector('.toggle-sidebar-btn').onclick = function() {
      document.body.classList.toggle('toggle-sidebar');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>