# Zen PHP Framework

Zen PHP ini adalah sebuah framework PHP MVC (Model-View-Controller) sederhana yang dirancang mirip dengan Laravel untuk membantu siswa SMK mempelajari konsep MVC, Routing, Database Query Builder, CLI Migrations, serta pengembangan web modern secara mudah.

---

## 🚀 Fitur Utama
1. **Laravel-like Routing**: Mendukung pendefinisian rute dinamis (contoh: `/posts/{id}`) dengan name routing di `routes/web.php`.
2. **Database Query Builder & ORM Sederhana**: Mendukung query database terintegrasi dan relasi model dasar.
3. **CLI Script `zen`**: Alat bantu baris perintah (CLI) untuk membuat file controller, model, migrasi, dan menjalankan migrasi secara otomatis.
4. **Sistem Template Layout & Komponen**: Struktur halaman yang rapi dengan pemisahan header, footer, layout utama, dan view konten.
5. **Error Handling Global**: Penanganan error yang elegan yang menangkap error PHP & database dan menampilkannya dalam halaman error (404/500) yang interaktif dan informatif.

---

## 🛠️ Kebutuhan Sistem
- **PHP** versi 7.4 atau 8.0 ke atas.
- **MySQL / MariaDB** (bisa menggunakan XAMPP).
- **Composer** terinstall di komputer.

---

## ⚙️ Instalasi & Konfigurasi

1. **Unduh/Clone Repositori**:
   Letakkan folder project ini di dalam direktori server Anda (misalnya `C:/xampp/htdocs/zen-php`).

2. **Install Dependensi Composer**:
   Buka terminal di direktori project ini, lalu jalankan:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (`.env`)**:
   Salin file `.env.example` dan ubah namanya menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan konfigurasinya dengan database lokal Anda:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=
   DB_NAME=db_bp
   BASE_URL=http://localhost/zen-php
   ```
   *Catatan: Pastikan `BASE_URL` sesuai dengan alamat akses di browser Anda.*

---

## 💻 Penggunaan Alat CLI `zen`

Project ini memiliki CLI helper bernama `zen` yang dijalankan menggunakan PHP di terminal Anda.

### 1. Menampilkan Bantuan Perintah
```bash
php zen
```

### 2. Membuat File Migrasi Baru
Untuk membuat file struktur tabel database baru dengan penamaan timestamp (tahun, tanggal, jam lokal):
```bash
php zen make:migration nama_tabel_table
```
*Contoh:* `php zen make:migration create_products_table`  
Ini akan membuat file di `database/migrations/YYYY_MM_DD_HHMMSS_create_products_table.php`.

### 3. Menjalankan Migrasi (Membuat Tabel di Database)
Untuk membuat semua tabel di dalam database secara otomatis:
```bash
php zen migrate
```
*Catatan: Database akan dibuat secara otomatis jika belum ada.*

### 4. Mereset & Menjalankan Ulang Migrasi (Refresh)
Untuk menghapus semua tabel dan membangunnya kembali dari awal:
```bash
php zen migrate:refresh
```

### 5. Membuat Model Baru
Untuk membuat kelas representasi tabel database di `app/models/`:
```bash
php zen make:model Product
```

### 6. Membuat Controller Baru
Untuk membuat kelas pengatur logika di `app/controllers/`:
```bash
php zen make:controller ProductController
```

---

## 📁 Struktur Direktori Project

```text
zen-php/
├── app/
│   ├── controllers/      # Logika aplikasi (Controller)
│   ├── core/             # Sistem inti framework (App, Route, Model, Database, dll)
│   ├── helpers/          # Fungsi pembantu tambahan
│   ├── models/           # Struktur data/representasi tabel (Model)
│   ├── views/            # File tampilan HTML/PHP (View)
│   │   ├── auth/         # View halaman login & register
│   │   ├── components/   # Komponen re-usable (header, footer)
│   │   ├── errors/       # Halaman error 404 & 500
│   │   ├── home/         # View halaman beranda
│   │   ├── layouts/      # Layout utama HTML (main.php)
│   │   └── post/         # View halaman pengelolaan postingan
│   └── init.php          # Inisialisasi awal sistem
├── database/
│   ├── migrations/       # File skrip pembentuk tabel database
│   ├── Blueprint.php     # Helper pendefinisi kolom tabel
│   ├── Database.php      # Koneksi & Query Builder PDO
│   └── Schema.php        # Helper pembuat tabel
├── public/
│   ├── css/              # File stylesheet (style.css)
│   ├── uploads/          # Folder penyimpanan file gambar postingan
│   └── index.php         # Entry point utama web server
├── routes/
│   └── web.php           # Daftar rute URL aplikasi
├── .env                  # Konfigurasi basis data & environment
├── index.php             # Bootloader halaman utama
├── composer.json         # Konfigurasi Composer Autoload
└── zen                   # Skrip utilitas CLI zen
```

---

## 📝 Panduan Dasar Menambahkan Fitur Baru

### Langkah 1: Tambahkan Rute Baru
Buka berkas `routes/web.php` dan tambahkan URL baru Anda:
```php
use App\Controllers\ProductController;

// Rute untuk melihat katalog produk
Route::get('/products', [ProductController::class, 'index'])->name('products');
```

### Langkah 2: Buat Controller
Jalankan perintah `php zen make:controller ProductController`. Kemudian edit file `app/controllers/ProductController.php`:
```php
<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua data produk dari database
        $products = Product::all();

        $data['title'] = 'Katalog Produk';
        $data['products'] = $products;

        // Render view dengan layout utama 'main'
        App::Layout('main', 'product/index', $data);
    }
}
```

### Langkah 3: Buat Model
Jalankan perintah `php zen make:model Product`. File `app/models/Product.php` akan terbuat secara otomatis dan siap berinteraksi dengan tabel `products`.

### Langkah 4: Buat Tampilan (View)
Buat folder `product` di dalam `app/views/` dan buat file `index.php` di dalamnya (`app/views/product/index.php`):
```html
<div class="row mt-4">
    <div class="col-md-12">
        <h2 class="fw-bold mb-3"><?= $title ?></h2>
        
        <?php if(empty($products)): ?>
            <p class="text-muted">Tidak ada produk tersedia.</p>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach($products as $product): ?>
                    <div class="col">
                        <div class="card card-premium h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-dark"><?= htmlspecialchars($product->name) ?></h5>
                                <p class="text-secondary"><?= htmlspecialchars($product->description) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
```
