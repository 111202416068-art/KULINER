<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h3 class="mb-4">Statistik Kuliner</h3>

<?php if (!empty($kategoriData)): ?>

    <!-- DATA DARI PHP -->
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

    <!-- CHART JS WAJIB DI ATAS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- BAR CHART -->
    <div class="card p-4 mb-4">
        <canvas id="myChart"></canvas>
    </div>

    <!-- PIE CHART -->
    <div class="card p-4">
        <h5 class="mb-3">Distribusi Kategori Kuliner</h5>
        <div style="width: 400px; margin:auto;">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <!-- SCRIPT CHART -->
    <script>
        // BAR CHART
        const ctxBar = document.getElementById('myChart');

        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    label: 'Jumlah Kuliner',
                    data: kategoriJumlah,
                    backgroundColor: '#4e73df'
                }]
            }
        });

        // PIE CHART
        const ctxPie = document.getElementById('pieChart');

        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    data: kategoriJumlah,
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796'
                    ]
                }]
            }
        });
    </script>

<?php else: ?>
    <p>Data kategori belum ada</p>
<?php endif; ?>

<?= $this->endSection(); ?>