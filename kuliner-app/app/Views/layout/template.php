<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= (isset($title)) ? $title : 'Culinary'; ?> | Culinary</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    body {
      background-color: #f0f2f5;
      font-family: "Open Sans", sans-serif;
      overflow-x: hidden;
    }

    .header {
      height: 60px;
      background: #fff;
      box-shadow: 0 2px 20px rgba(1, 41, 112, 0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }

    .toggle-sidebar-btn {
      font-size: 26px;
      cursor: pointer;
      margin-left: 15px;
    }

    .sidebar {
      width: 260px;
      height: 100vh;
      position: fixed;
      top: 60px;
      left: 0;
      background: #fff;
      box-shadow: 0 0 20px rgba(1, 41, 112, 0.1);
      padding: 20px;
      transition: all 0.3s;
    }

    #main {
      margin-left: 260px;
      padding: 80px 20px 20px;
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
    }

    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      padding: 10px;
      color: #012970;
      text-decoration: none;
      border-radius: 5px;
      transition: 0.3s;
    }

    .sidebar-nav .nav-link:hover {
      background: #f6f9ff;
      color: #4154f1;
    }

    .sidebar-nav i {
      margin-right: 10px;
    }
  </style>
</head>

<body>

  <header class="header">
    <div class="d-flex align-items-center">
      <span class="fw-bold fs-4 text-primary">Culinary</span>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="profile d-flex align-items-center">
      <span class="fw-bold me-2 text-dark">
        <?= session()->get('role') === 'admin' ? 'Admin' : (session()->get('nama_lengkap') ?? session()->get('username')); ?>
      </span>
      <i class="bi bi-person-circle fs-4 text-primary"></i>
    </div>
  </header>

  <aside class="sidebar">
    <ul class="sidebar-nav">

      <li>
        <a class="nav-link" href="<?= base_url('kuliner'); ?>">
          <i class="bi bi-house"></i>Dashboard
        </a>
      </li>

      <li>
        <a class="nav-link" href="<?= base_url('jelajah'); ?>">
          <i class="bi bi-geo-alt"></i>Jelajah Kuliner
        </a>
      </li>

      <?php if (session()->get('role') === 'admin'): ?>

        <li class="mt-3 text-muted small">Manajemen</li>

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
            <i class="bi bi-bar-chart"></i>Statistik
          </a>
        </li>

      <?php endif; ?>

      <li class="mt-3 text-muted small">Pengaturan</li>

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

</body>

</html>