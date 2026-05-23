<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Statistik Kuliner</h1>
        <p class="text-muted small">Visualisasi data grafik distribusi menu tempat makan berdasarkan kategori yang terdaftar</p>
    </div>

    <?php if (!empty($kategoriData)): ?>

        <script>
            const kategoriLabels = [
                <?php foreach ($kategoriData as $k): ?> "<?= $k['nama']; ?>",
                <?php endforeach; ?>
            ];

            const kategoriJumlah = [
                <?php foreach ($kategoriData as $k): ?>
                    <?= $k['jumlah']; ?>,
                <?php endforeach; ?>
            ];
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-bar-chart-line-fill text-terracotta me-1"></i> Grafik Jumlah Kuliner Per Kategori</h5>
            <canvas id="myChart"></canvas>
        </div>

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pie-chart-fill text-terracotta me-1"></i> Distribusi Kategori Kuliner</h5>
            <div class="canvas-pie-box" style="max-width: 360px; margin: auto;">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <script>
            // KOLEKSI PALET WARNA BUMI (EARTH TONE COMPONENT)
            // 1. #8C6239 -> Cokelat Moka Utama
            // 2. #BE9B7B -> Cokelat Susu Lembut
            // 3. #E6A15C -> Terracotta / Oranye Tembikar Warm
            // 4. #D6C5B3 -> Krem Semen Adem
            // 5. #A78364 -> Latte Matte
            const earthTonePalette = ['#8C6239', '#BE9B7B', '#E6A15C', '#D6C5B3', '#A78364', '#4A3E3D'];

            // 📊 1. KONFIGURASI DIAGRAM BATANG (BAR CHART)
            const ctxBar = document.getElementById('myChart');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: kategoriLabels,
                    datasets: [{
                        label: 'Jumlah Tempat Kuliner',
                        data: kategoriJumlah,
                        backgroundColor: '#8C6239', // Menggunakan Cokelat Moka Utama
                        borderRadius: 8, // Membuat ujung tiang batang sedikit tumpul estetik
                        borderWidth: 0
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                font: { family: 'Plus Jakarta Sans', weight: '600' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 } // Skala naik per 1 angka bulat (cocok untuk jumlah data)
                        }
                    }
                }
            });

            // 📊 2. KONFIGURASI DIAGRAM LINGKARAN (PIE CHART)
            const ctxPie = document.getElementById('pieChart');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: kategoriLabels,
                    datasets: [{
                        data: kategoriJumlah,
                        backgroundColor: earthTonePalette, // Inject variasi warna bumi serasi
                        borderWidth: 2,
                        borderColor: '#FFFFFF' // Garis pembatas putih bersih biar kontras mewah
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom', // Pindahkan label keterangan ke bawah biar rapi ala GoFood
                            labels: {
                                padding: 20,
                                font: { family: 'Plus Jakarta Sans', size: 12, weight: '500' }
                            }
                        }
                    }
                }
            });
        </script>

    <?php else: ?>
        <div class="alert alert-light border text-center py-5 text-muted rounded-4">
            <i class="bi bi-bar-chart-steps fs-2 d-block mb-2 text-muted"></i> Data rekapitulasi statistik kategori belum tersedia.
        </div>
    <?php endif; ?>
</div>

<style>
    .text-moka { color: #8C6239 !important; }
    .text-terracotta { color: #E6A15C !important; }
</style>

<?= $this->endSection(); ?>