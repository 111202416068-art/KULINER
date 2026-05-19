<?php $base = base_url('index.php'); ?>

<aside class="sidebar bg-white shadow-sm p-3" style="width:250px; min-height: 100vh;">
    <div class="mb-4 text-center">
        <h5 class="fw-bold text-primary">Sistem Kuliner</h5>
    </div>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="<?= $base ?>/kuliner" class="nav-link text-dark">
        <li><a href="http://localhost/kuliner-app/public/index.php/kuliner">Dashboard</a></li>
        </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= $base ?>/kategori" class="nav-link text-dark">
        <li><a href="http://localhost/kuliner-app/public/index.php/kategori">Kategori</a></li>
        </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= $base ?>/statistik" class="nav-link text-dark">
        <li><a href="http://localhost/kuliner-app/public/index.php/statistik">Statistik</a></li>
        </a>
        </li>

        <li class="nav-item mb-2">
            <a href="<?= $base ?>/profil" class="nav-link text-dark">
        <li><a href="http://localhost/kuliner-app/public/index.php/profil">Profil Saya</a></li>
        </a>
        </li>

        <?php if (session()->get('logged_in')): ?>

            <!-- MENU ADMIN -->
            <a href="index.php/statistik">Statistik</a>
            <a href="index.php/profil">Profil</a>

        <?php endif; ?>

    </ul>
</aside>