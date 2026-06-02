# Membuat CRUD Sederhana

Salah satu fitur paling umum dalam aplikasi web adalah *Create, Read, Update, Delete* (CRUD). Di panduan ini, kita akan membuat sistem CRUD untuk entitas `Product`.

## 1. Membuat Model

Pertama, buat file `Product.php` di dalam folder `app/models/`:

```php
<?php
namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    // Tentukan nama tabel
    protected $table = 'products';
}
```

Pastikan Anda juga telah membuat tabel `products` di database Anda dengan kolom `id`, `name`, `price`, dan `description`.

## 2. Membuat Controller

Gunakan Zen CLI untuk membuat controller dengan cepat:

```bash
php zen make:controller ProductController
```

Lalu, buka file `app/controllers/ProductController.php` dan buat metode untuk setiap aksi CRUD:

```php
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Models\Product;

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    // READ: Menampilkan semua produk
    public function index()
    {
        $products = $this->productModel->all();
        App::Layout('main', 'products/index', ['products' => $products]);
    }

    // CREATE: Menampilkan form tambah
    public function create()
    {
        App::Layout('main', 'products/create');
    }

    // CREATE: Proses simpan data
    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];
        
        if ($this->productModel->create($data)) {
            $this->redirect(route('products.index'));
        }
    }

    // UPDATE: Menampilkan form edit
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        App::Layout('main', 'products/edit', ['product' => $product]);
    }

    // UPDATE: Proses update data
    public function update($id)
    {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];

        $this->productModel->update($id, $data);
        $this->redirect(route('products.index'));
    }

    // DELETE: Menghapus data
    public function destroy($id)
    {
        $this->productModel->delete($id);
        $this->redirect(route('products.index'));
    }
}
```

## 3. Mendaftarkan Route

Buka `routes/web.php` dan tambahkan rute untuk aksi-aksi di atas:

```php
use App\Core\Route;
use App\Controllers\ProductController;

// Menampilkan daftar produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Membuat produk baru
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store']);

// Mengubah produk
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/{id}/update', [ProductController::class, 'update']);

// Menghapus produk
Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
```

## 4. Membuat View

Buat folder `app/views/products/` dan tambahkan file-file view berikut.

### `index.php` (Daftar Produk)
```html
<h1>Daftar Produk</h1>
<a href="<?= route('products.create') ?>">Tambah Produk Baru</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td><?= $product['name'] ?></td>
        <td><?= $product['price'] ?></td>
        <td>
            <a href="<?= route('products.edit', ['id' => $product['id']]) ?>">Edit</a>
            <form action="<?= route('products.destroy', ['id' => $product['id']]) ?>" method="POST" style="display:inline;">
                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
```

### `create.php` (Form Tambah)
```html
<h1>Tambah Produk</h1>
<form action="/products" method="POST">
    <label>Nama:</label><br>
    <input type="text" name="name" required><br><br>
    
    <label>Harga:</label><br>
    <input type="number" name="price" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="description"></textarea><br><br>
    
    <button type="submit">Simpan</button>
</form>
```

### `edit.php` (Form Edit)
```html
<h1>Edit Produk</h1>
<form action="/products/<?= $product['id'] ?>/update" method="POST">
    <label>Nama:</label><br>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>
    
    <label>Harga:</label><br>
    <input type="number" name="price" value="<?= $product['price'] ?>" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="description"><?= $product['description'] ?></textarea><br><br>
    
    <button type="submit">Update</button>
</form>
```

Selesai! Sekarang jika Anda membuka `http://localhost/zen-php/products`, Anda sudah memiliki sistem CRUD lengkap.
