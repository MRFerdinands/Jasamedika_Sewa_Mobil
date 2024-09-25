# Proyek Laravel Filament Sewa Mobil Jasamedika

## Prasyarat

Sebelum memulai, pastikan Anda memenuhi prasyarat berikut:

- **Laravel** versi 11
- **Database**: MySQL (gunakan XAMPP atau Laragon)
- **Composer**: Pastikan Composer telah terinstal di sistem Anda

## Langkah-langkah Setup

### 1. Clone Repository

Unduh atau clone proyek ini dengan perintah berikut:

```bash
git clone https://github.com/MRFerdinands/Jasamedika_Sewa_Mobil
```

### 2. Akses Folder Proyek

Masuk ke direktori proyek yang telah di-clone:

```bash
cd Jasamedika_Sewa_Mobil
```

### 3. Instalasi Dependency

Instal semua dependency yang diperlukan dengan menjalankan perintah berikut:

```bash
composer install
```

### 4. Konfigurasi Database

Buka file `.env` dan sesuaikan pengaturan database dengan informasi berikut:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jasamedika_persewaan_mobil
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration

Jalankan perintah di bawah ini untuk menjalankan migrasi database:

```bash
php artisan migrate
```

### 6. Jalankan Seeder

Isi database dengan data awal menggunakan seeder:

```bash
php artisan db:seed
```

### 7. Jalankan Server

Mulai server lokal dengan perintah berikut:

```bash
php artisan serve
```

### 8. Akses Aplikasi

Buka aplikasi Anda di browser dengan mengunjungi URL:

```
http://localhost:8000
```

## Informasi Tambahan

- Pastikan Anda telah menginstal Laravel dan Composer sebelum menjalankan perintah di atas.
- Jika menggunakan XAMPP, pastikan modul MySQL telah diaktifkan.
- Jika menggunakan Laragon, pastikan layanan MySQL aktif.

## Lisensi

Proyek ini menggunakan **Lisensi MIT**.

## Terima Kasih 😊
