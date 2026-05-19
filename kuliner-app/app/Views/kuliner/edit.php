<?php

/** @var array $kuliner */
/** @var array|null $kategori */
$kategori = $kategori ?? [];
?>
<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-2 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0">Edit Data Kuliner</h4>
        </div>
        <div class="card-body p-4">
            <<form action="/kuliner/update/<?= $kuliner['id']; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <!-- Nama Kuliner -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kuliner</label>
                    <input type="text" name="nama" class="form-control" value="<?= $kuliner['nama']; ?>" required>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k['id_kategori']; ?>" <?= ($k['id_kategori'] == $kuliner['kategori_id']) ? 'selected' : ''; ?>>
                                <?= $k['nama_kategori']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Alamat + Tombol Cari Koordinat -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <div class="input-group">
                        <input type="text" id="alamat_input" name="alamat" class="form-control"
                            value="<?= $kuliner['alamat']; ?>" placeholder="Contoh: Jl. Ahmad Yani Semarang" required>
                        <button class="btn btn-primary" type="button" onclick="cariLokasi()">
                            <i class="bi bi-search"></i> Cari Koordinat
                        </button>
                    </div>
                </div>

                <!-- Latitude & Longitude -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Latitude</label>
                        <input type="text" id="lat_input" name="lat" class="form-control" value="<?= $kuliner['lat']; ?>" readonly required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Longitude</label>
                        <input type="text" id="lng_input" name="lng" class="form-control" value="<?= $kuliner['lng']; ?>" readonly required>
                    </div>
                </div>

                <!-- Rating & Review -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Rating (1-5)</label>
                    <input type="number" name="rating" class="form-control" min="1" max="5" value="<?= $kuliner['rating'] ?? 5; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Review</label>
                    <textarea name="review" class="form-control" rows="3"><?= $kuliner['review_text'] ?? ''; ?></textarea>
                </div>

                <div class="text-end mt-3">
                    <a href="/kuliner" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
                </form>

                <!-- SCRIPT UNTUK MENCARI KOORDINAT -->
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
        </div>
    </div>
</div>

<script>
    function cariKoordinat() {
        const alamat = document.getElementById('alamat').value;
        const latInput = document.getElementById('lat');
        const lngInput = document.getElementById('lng');

        if (alamat === "") {
            alert("Tolong isi alamat dulu ya!");
            return;
        }

        latInput.value = "Mencari...";
        lngInput.value = "Mencari...";

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamat)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    latInput.value = data[0].lat;
                    lngInput.value = data[0].lon;
                } else {
                    alert("Alamat tidak ditemukan!");
                    latInput.value = "";
                    lngInput.value = "";
                }
            })
            .catch(error => {
                alert("Gagal mengambil data. Cek koneksi internet.");
            });
    }
</script>
<?= $this->endSection(); ?>