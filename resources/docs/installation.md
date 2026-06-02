# Instalasi Zen PHP

Selamat datang di dokumentasi resmi Zen PHP! Framework ini dirancang untuk memberikan pengalaman pengembangan yang cepat, ekspresif, dan elegan seperti Laravel, namun dengan fondasi yang ringan (MVC murni).

## Persyaratan Sistem

Sebelum menginstal Zen PHP, pastikan server Anda memenuhi persyaratan berikut:
- PHP >= 8.0
- Ekstensi PDO PHP
- Ekstensi Mbstring PHP
- Composer
- Server Database (MySQL/MariaDB)

## Cara Menginstal

Langkah termudah untuk menginstal Zen PHP adalah dengan menggunakan Git untuk meng-clone repositori Zen PHP:

```bash
git clone https://github.com/razenry/zen-framework.git my-app
cd my-app
```

Setelah berhasil di-clone, install dependensi via Composer:

```bash
composer install
```

## Konfigurasi Environment

Duplikat file `.env.example` dan ubah namanya menjadi `.env`:

```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan koneksi database Anda:

```env
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

## Menjalankan Aplikasi

Jika Anda menggunakan XAMPP/MAMP/Laragon, Anda bisa menaruh proyek ini di dalam folder `htdocs` atau `www`.
Sebagai alternatif, Anda juga bisa menggunakan built-in server PHP di terminal:

```bash
php -S localhost:8000
```

Buka `http://localhost:8000` di browser Anda untuk melihat halaman beranda Zen PHP.
