# Sistem Autentikasi (Login & Register)

Zen PHP adalah *micro-framework* ringan. Karena itu, kami tidak menyertakan sistem *Auth* yang kaku secara bawaan (seperti halnya Laravel Breeze), melainkan memberi Anda fleksibilitas untuk membangun autentikasi menggunakan fitur standar `$_SESSION` PHP yang super cepat dan aman.

Berikut adalah contoh langkah demi langkah membuat sistem Login dan Register sederhana.

## 1. Persiapan Tabel Database

Pastikan Anda memiliki tabel `users` di database Anda dengan struktur berikut:

```sql
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 2. Membuat Model User

Buat file `User.php` di dalam folder `app/models/`:

```php
<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    // Method pembantu untuk mencari user berdasarkan email
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
```

## 3. Membuat AuthController

Buat controller baru untuk menangani logika pendaftaran dan login:

```php
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Menampilkan halaman Register
    public function registerForm()
    {
        App::Layout('main', 'auth/register');
    }

    // Proses Register
    public function register()
    {
        // Enkripsi password menggunakan algoritma bcrypt yang aman
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
        ];

        if ($this->userModel->create($data)) {
            // Langsung login setelah register berhasil (opsional)
            \App\Core\Auth::login($this->userModel->db->lastInsertId(), $data['name']);
            
            $this->redirect('/dashboard');
        }
    }

    // Menampilkan halaman Login
    public function loginForm()
    {
        App::Layout('main', 'auth/login');
    }

    // Proses Login
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->findByEmail($email);

        // Verifikasi keberadaan user dan kecocokan password
        if ($user && password_verify($password, $user['password'])) {
            // Gunakan Auth helper untuk login
            \App\Core\Auth::login($user['id'], $user['name']);
            
            $this->redirect('/dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login
            die("Email atau password salah!"); 
        }
    }

    // Proses Logout
    public function logout()
    {
        \App\Core\Auth::logout();
        $this->redirect('/login');
    }
}
```

## 4. Mendaftarkan Route

Buka `routes/web.php` dan tambahkan *route* untuk Autentikasi:

```php
use App\Core\Route;
use App\Controllers\AuthController;

// Route untuk Guest (Belum login)
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);

// Route Logout
Route::get('/logout', [AuthController::class, 'logout']);
```

## 5. Melindungi Halaman Tertentu (Middleware Manual)

Karena struktur Zen PHP dibuat sangat simpel, cara paling mudah untuk membatasi akses (melindungi halaman agar hanya bisa diakses user yang sudah login) adalah dengan menggunakan *helper* `Auth` di dalam _constructor_ atau awal fungsi Controller terkait. Anda juga dapat menggunakan method `$this->redirect()` bawaan base controller.

Contoh untuk `DashboardController`:

```php
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Core\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Cek apakah user sudah login dengan Auth::check()
        if (!Auth::check()) {
            // Jika belum login, tendang balik ke halaman login!
            $this->redirect('/login');
        }
    }

    public function index()
    {
        // Tampilkan halaman dashboard
        App::Layout('main', 'dashboard/index', [
            'name' => Auth::user()
        ]);
    }
}
```

Dan daftarkan *route* nya di `web.php`:
```php
Route::get('/dashboard', [\App\Controllers\DashboardController::class, 'index']);
```

Dengan langkah-langkah di atas, Anda telah membangun sistem Autentikasi komplit yang ringan dan aman di dalam Zen PHP. Anda bebas berkreasi untuk menambahkan fitur seperti *Lupa Password* atau *Remember Me* sesuai kebutuhan bisnis Anda!
