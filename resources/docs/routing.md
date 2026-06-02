# Routing

Routing pada Zen PHP sangat terpusat dan mudah diatur. Semua definisi route untuk web Anda terletak di file `routes/web.php`.

## Basic Routing

Route paling dasar menggunakan method HTTP dan closure atau memanggil method pada Controller. File rute mendukung method `GET`, `POST`, `PUT`, `DELETE`.

### Route dengan Closure:

```php
Route::get('/hello', function() {
    echo "Hello World!";
});
```

### Route ke Controller:

Sangat disarankan untuk memisahkan logika Anda ke dalam Controller.

```php
use App\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
```

## Route Parameters

Anda dapat menangkap segmen URL dengan mendefinisikan parameter pada URI rute.

```php
use App\Controllers\UserController;

// URL: /user/123
Route::get('/user/{id}', [UserController::class, 'show']);
```

Parameter `{id}` ini otomatis akan di-passing sebagai argumen ke method `show($id)` yang ada di `UserController`.

## Named Routes

Zen PHP mendukung pemberian nama (name) untuk rute Anda. Named routes memudahkan saat menggenerate URL atau redirect:

```php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
```

Untuk memanggil named route di Controller:
```php
redirect(route('dashboard'));
```

Di dalam View:
```html
<a href="<?= route('dashboard') ?>">Ke Dashboard</a>
```
