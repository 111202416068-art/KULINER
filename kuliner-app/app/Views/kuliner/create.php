<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="py-2">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-moka" style="letter-spacing: -0.5px;">Tambah Data Kuliner</h1>
        <p class="text-muted small">Daftarkan lokasi kuliner baru sekaligus kelola nominal voucher diskon kemitraannya</p>
    </div>

    <section class="section">
        <div class="card shadow-sm border-0 rounded-4 p-3">
            <div class="card-body">
                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="bi bi-plus-circle-fill text-moka me-1"></i> Form Input Data Master</h5>

                <form action="/kuliner/save" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Foto Kuliner</label>
                            <input type="file" name="gambar" class="form-control rounded-3" accept="image/*" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Kategori Tempat</label>
                            <select name="kategori_id" class="form-select rounded-3" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori ?? [] as $k): ?>
                                    <option value="<?= $k['id_kategori']; ?>">
                                        <?= $k['nama_kategori']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Tempat Kuliner</label>
                            <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: Sate Madura Pak Jhon" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Harga Voucher Belanja (Rp) <span class="text-muted fw-normal">(Opsional)</span></label>
                            <input type="number" name="harga_voucher" class="form-control rounded-3 font-monospace fw-bold text-moka" placeholder="Kosongkan / isi 0 jika tidak ada voucher" min="0" step="1000" value="0">
                            <small class="text-muted" style="font-size: 11px;">*Kosongkan atau biarkan 0 jika warung ini tidak menerbitkan voucher kupon digital.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Alamat Lokasi Resmi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" id="alamat_input" name="alamat" class="form-control" placeholder="Masukkan nama jalan atau wilayah kota..." required>
                            <button class="btn btn-primary fw-bold px-3" type="button" onclick="cariLokasi()">
                                <i class="bi bi-search me-1"></i> Cari Koordinat Peta
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Titik Koordinat Latitude</label>
                            <input type="text" id="lat_input" name="lat" class="form-control rounded-3 bg-light font-monospace fw-semibold" readonly required placeholder="-7.xxxxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Titik Koordinat Longitude</label>
                            <input type="text" id="lng_input" name="lng" class="form-control rounded-3 bg-light font-monospace fw-semibold" readonly required placeholder="110.xxxxxx">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Catatan / Review Singkat Awal</label>
                        <textarea name="review" class="form-control rounded-3" rows="3" placeholder="Tuliskan ulasan pembuka mengenai menu andalan tempat ini..."></textarea>
                    </div>

                    <div class="mb-4" style="max-width: 200px;">
                        <label class="form-label small fw-bold text-secondary">Rating Awal</label>
                        <input type="number" name="rating" class="form-control rounded-3" min="1" max="5" value="5">
                    </div>

                    <div class="text-end border-top pt-3">
                        <a href="/kuliner" class="btn btn-outline-secondary px-4 fw-bold me-2">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Terbitkan Data & Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    function cariLokasi() {
        const alamat = document.getElementById('alamat_input').value;
        const inputLat = document.getElementById('lat_input');
        const inputLng = document.getElementById('lng_input');

        if (!alamat) {
            alert("Tolong isi kolom alamatnya terlebih dahulu!");
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
                    alert("Alamat tidak ditemukan! Silakan perjelas input nama jalan/wilayah.");
                    inputLat.value = "";
                    inputLng.value = "";
                }
            })
            .catch(error => {
                alert("Gagal mengambil data koordinat. Cek koneksi internet server.");
            });
    }
</script>

<style>
    .text-moka { color: #8C6239 !important; }
    .form-control:focus, .form-select:focus {
        border-color: #8C6239 !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 98, 57, 0.15) !important;
    }
</style>

<?= $this->endSection(); ?>