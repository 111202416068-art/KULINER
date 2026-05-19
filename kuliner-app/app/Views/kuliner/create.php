<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="pagetitle">
    <h1>Tambah Data Kuliner</h1>
</div>

<section class="section">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Form Tambah Kuliner</h5>

            <form action="/kuliner/save" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Kuliner</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori ?? [] as $k): ?>
                            <option value="<?= $k['id_kategori']; ?>">
                                <?= $k['nama_kategori']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Tempat</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama tempat..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <div class="input-group">
                            <input type="text" id="alamat_input" name="alamat" class="form-control" placeholder="Contoh: Jl. Ahmad Yani Semarang" required>
                            <button class="btn btn-primary" type="button" onclick="cariLokasi()">
                                <i class="bi bi-search"></i> Cari Koordinat
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Latitude</label>
                            <input type="text" id="lat_input" name="lat" class="form-control" readonly required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Longitude</label>
                            <input type="text" id="lng_input" name="lng" class="form-control" readonly required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Review</label>
                        <textarea name="review" class="form-control" rows="3" placeholder="Berikan ulasan singkat..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Rating (1-5)</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5" value="5">
                    </div>

                    <div class="text-end mt-3">
                        <a href="/kuliner" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
            </form>
        </div>
    </div>
</section>

<script>
    function cariLokasi() {
        const alamat = document.getElementById('alamat_input').value;
        const inputLat = document.getElementById('lat_input');
        const inputLng = document.getElementById('lng_input');

        if (!alamat) {
            alert("Tolong isi alamatnya dulu!");
            return;
        }

        inputLat.value = "Mencari...";
        inputLng.value = "Mencari...";

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamat)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    inputLat.value = data[0].lat;
                    inputLng.value = data[0].lon;
                } else {
                    alert("Alamat tidak ditemukan!");
                    inputLat.value = "";
                    inputLng.value = "";
                }
            })
            .catch(error => {
                alert("Gagal mengambil data koordinat.");
            });
    }
</script>
<?= $this->endSection(); ?>