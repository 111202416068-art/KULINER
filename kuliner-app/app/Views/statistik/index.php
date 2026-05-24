<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, #F5EBE6 0%, #E6D5CC 100%);">
        <h1 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Dashboard Statistik Kuliner 📊</h1>
        <p class="text-muted small mb-0">Rangkuman data digital, akumulasi ulasan pelanggan, serta grafik persebaran kategori kuliner.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card p-4 text-center border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="text-moka mb-2"><i class="bi bi-shop fs-1"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Total Kuliner</h6>
                <h2 class="fw-bold text-dark mb-0"><?= $totalKuliner; ?></h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-4 text-center border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="text-warning mb-2"><i class="bi bi-star-fill fs-1"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Rata-rata Rating</h6>
                <h2 class="fw-bold text-dark mb-0"><?= $rataRating; ?> <span class="fs-6 text-muted">/ 5.0</span></h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-4 text-center border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="text-info mb-2"><i class="bi bi-chat-left-heart-fill fs-1"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Total Ulasan</h6>
                <h2 class="fw-bold text-dark mb-0"><?= $totalReview; ?></h2>
            </div>
        </div>
    </div>

    <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-5">
        <h5 class="fw-bold text-dark mb-4"><i class="bi bi-bar-chart-line-fill text-moka me-2"></i>Grafik Jumlah Kuliner Per Kategori</h5>
        <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="chartStatistik"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('chartStatistik').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                // 🔥 SINKRONISASI LABEL: Sekarang melooping nama_kategori, bukan nama toko!
                labels: [
                    <?php if (!empty($kategoriData)): ?>
                        <?php foreach ($kategoriData as $kd) : ?>
                            "<?= addslashes(htmlspecialchars_decode($kd['nama_kategori'])); ?>",
                        <?php endforeach; ?>
                    <?php endif; ?>
                ],
                datasets: [{
                    label: 'Jumlah Tempat Kuliner',
                    // 🔥 SINKRONISASI DATA: Mengambil kolom akumulasi jumlah totalnya
                    data: [
                        <?php if (!empty($kategoriData)): ?>
                            <?php foreach ($kategoriData as $kd) : ?>
                                <?= $kd['jumlah']; ?>,
                            <?php endforeach; ?>
                        <?php endif; ?>
                    ],
                    backgroundColor: '#8C6239', // Warna moka hangat khas tema bumi kamu
                    borderColor: '#734F2D',
                    borderWidth: 0,
                    borderRadius: 10,
                    borderSkipped: false,
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                weight: '500'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12
                            },
                            color: '#4A3E3D'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F5EBE6'
                        },
                        ticks: {
                            stepSize: 1, // Memaksa skala sumbu Y naik per angka bulat (1, 2, 3...)
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            color: '#4A3E3D'
                        }
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection(); ?>