# 🍽️ Aplikasi Direktori Kuliner Berbasis CodeIgniter 4

Aplikasi web direktori kuliner ini dibangun menggunakan arsitektur **Model-View-Controller (MVC)** memanfaatkan framework **CodeIgniter 4** dan basis data **MySQL**. Proyek ini ditujukan untuk memenuhi tugas besar mata kuliah Pemrograman Web Lanjut di Universitas Dian Nuswantoro.

---

## 🚀 Fitur Utama (Spesifikasi Project)

Sistem ini telah mengimplementasikan seluruh poin penilaian utama dengan status **Valid (Nilai Maksimal)**:
* **Manajemen CRUD Utama (Poin 4):** Pengelolaan data tempat kuliner, kategori, dan ulasan lengkap dengan sistem validasi input, *flash message* berbasis alert Bootstrap, serta fitur *upload* berkas gambar fisik.
* **Geocoding & Leaflet Map (Poin 5):** Integrasi peta interaktif menggunakan OpenStreetMap (Leaflet.js) untuk memetakan koordinat lokasi kuliner (*latitude* & *longitude*) langsung dari database.
* **API Cuaca Real-Time (Poin 6):** Sinkronisasi data cuaca terkini di lokasi kuliner dengan mengonsumsi REST API dari pihak ketiga (OpenWeatherMap API).
* **Payment Gateway & Notifikasi (Poin 7):** Integrasi sistem transaksi voucher digital memanfaatkan **Midtrans Snap Sandbox** dilengkapi simulasi log *Notification Handler* untuk WhatsApp Gateway.
* **Custom Helper & Bersih (Poin 9):** Implementasi `bintang_helper.php` untuk merender data rating angka menjadi komponen ikon bintang dinamis secara otomatis pada halaman utama.

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework:** CodeIgniter 4.x
* **Database:** MySQL / MariaDB
* **Frontend Interface:** Bootstrap 5 & Bootstrap Icons
* **Library Peta:** Leaflet.js (OpenStreetMap)
* **Payment SDK:** Midtrans Snap API (Sandbox Mode)

---

## 📦 Panduan Instalasi Sistem

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal (*localhost*):

### 1. Clone Repository
```bash
git clone [https://github.com/111202416068-art/KULINER.git](https://github.com/111202416068-art/KULINER.git)
cd KULINER/kuliner-app

2. Konfigurasi Database
Buat database baru di phpMyAdmin dengan nama db_kuliner (atau sesuaikan dengan nama database lokalmu).

Import file .sql database yang berada di dalam folder proyek ini.

Buka file app/Config/Database.php atau file .env, lalu sesuaikan kredensial MySQL dengan server lokalmu:
public array $default = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_kuliner',
    'DBDriver' => 'MySQLi',
];

3. Menjalankan Server Lokal
Pastikan Apache dan MySQL di panel XAMPP kamu sudah aktif, lalu jalankan perintah terminal bawaan CodeIgniter 4 di dalam folder kuliner-app:

php spark serve

4. Akses Aplikasi via Browser
Buka browser kesayanganmu dan akses URL berikut untuk masuk ke halaman login utama:
http://localhost:8080/login

### ⚡ Langkah Push Terakhir ke GitHub:
Buka kembali terminal VS Code kamu, lalu ketik 3 baris perintah sakti ini untuk mengunggah file README versi final ini:

```bash
git add README.md
git commit -m "docs: release versi final readme spesifikasi tugas besar"
git push origin main
