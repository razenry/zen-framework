# Views

Views memisahkan logika aplikasi (Controller) dari logika presentasi. View menyimpan kode HTML yang dirender untuk browser. Dalam Zen PHP, view disimpan di dalam direktori `app/views/`.

## Menggunakan Views

Untuk me-return sebuah view dari Controller, gunakan method `view()` dari parent Controller:

```php
public function index()
{
    return $this->view('home');
}
```

Jika Anda memiliki sub-folder, pisahkan dengan garis miring `/`:

```php
return $this->view('users/profile'); // Akan merender app/views/users/profile.php
```

## Passing Data ke View

Anda dapat memberikan data berbentuk array asosiatif sebagai argumen kedua ke method `view()`:

```php
return $this->view('greetings', ['name' => 'John Doe']);
```

Di dalam view `greetings.php`, Anda dapat langsung mengakses variabel `$name`:

```html
<h1>Halo, <?= htmlspecialchars($name) ?>!</h1>
```

Selalu pastikan untuk menggunakan fungsi `htmlspecialchars()` ketika me-render data dari user agar aplikasi Anda terlindungi dari serangan XSS (Cross-Site Scripting).

## Layouts

Seringkali banyak halaman dalam aplikasi yang membagi desain antarmuka dasar yang sama (seperti navigasi header dan footer). Zen PHP menyediakan mekanisme **Layout** terpusat agar Anda tidak perlu menulis kode HTML berulang-ulang.

File *master layout* disimpan di folder `app/views/layouts/`. Untuk memanggil view menggunakan layout, alih-alih menggunakan `$this->view()`, Anda harus memanggil method statis `Layout()` dari kelas `App\Core\App`.

Contoh pemanggilan di Controller:

```php
use App\Core\App;

public function index()
{
    $data = ['title' => 'Halaman Beranda'];
    // Format: App::Layout(nama_layout, nama_view, array_data)
    App::Layout('main', 'home', $data);
}
```

Di dalam file `layouts/main.php`, Anda memanggil bagian view utama (`home.php`) menggunakan properti `$content_view` yang disisipkan secara otomatis:

```html
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'Aplikasi Saya' ?></title>
</head>
<body>
    <header>My Website Nav</header>

    <div class="main-content">
        <!-- Render view spesifik (contoh: home.php) -->
        <?php \App\Core\App::View($content_view ?? '', $data ?? []); ?>
    </div>
</body>
</html>
```

## Komponen (Components)

Selain Layout, Zen PHP juga mendukung pemecahan UI menjadi kepingan-kepingan kecil yang dapat digunakan kembali, yang disebut **Komponen**. Komponen diletakkan di dalam folder `app/views/components/`.

Misalnya, Anda membuat komponen untuk header di `app/views/components/header.php`. Anda dapat menyertakan (include) komponen tersebut ke dalam view atau layout mana saja menggunakan method `App::Component()`:

```php
<!-- Memanggil komponen header tanpa data tambahan -->
<?php \App\Core\App::Component('header'); ?>

<!-- Memanggil komponen dengan melempar data variabel -->
<?php \App\Core\App::Component('card', ['title' => 'Produk A', 'price' => 50000]); ?>
```

Metode berbasis komponen ini akan membuat susunan kode HTML Anda menjadi sangat rapi, terstruktur, dan elegan.
