# Controllers

Alih-alih mendefinisikan semua logika `request-handling` sebagai Closure di file route, Anda bisa mengorganisasikan logika tersebut menggunakan class **Controller**. Semua controller disimpan di folder `app/controllers/`.

## Controller Dasar

Berikut adalah contoh Controller dasar. Perhatikan bahwa controller ini mewarisi (extend) `App\Core\Controller`.

```php
namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller
{
    public function show($id)
    {
        return $this->view('users/profile', [
            'user_id' => $id
        ]);
    }
}
```

Kemudian Anda daftarkan rutenya di `routes/web.php`:

```php
use App\Controllers\UserController;

Route::get('/user/{id}', [UserController::class, 'show']);
```

## Memanggil View

Method `$this->view()` digunakan untuk me-render file tampilan. Parameter pertama adalah path ke file view relatif dari folder `app/views/` (tanpa ekstensi `.php`), dan parameter kedua adalah array data yang akan diteruskan ke view tersebut.

## Menghandle Form Input (POST)

Anda dapat membuat method khusus untuk menangani form submission (HTTP POST):

```php
public function store()
{
    // Mengambil data $_POST dengan utilitas request() bawaan
    $name = request('name');
    $email = request('email');

    // Lakukan operasi simpan ke database...

    // Redirect ke rute lain setelah selesai
    redirect(route('home'));
}
```
