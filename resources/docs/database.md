# Database & Migrations

Zen PHP menggunakan **PDO (PHP Data Objects)** di belakang layar, sehingga mampu mendukung banyak tipe driver SQL (MySQL, PostgreSQL, SQLite).

## Konfigurasi

Semua pengaturan koneksi database didefinisikan dalam file `.env` di root project Anda:

```env
DB_HOST=localhost
DB_DATABASE=nama_db
DB_USERNAME=root
DB_PASSWORD=
```

## Migrasi Database (Migrations)

Migrasi bagaikan `version control` untuk struktur tabel database Anda, memudahkan tim memodifikasi dan membagikan skema database aplikasi.

Semua file migrasi disimpan di dalam folder `database/migrations/`.

### Membuat Migrasi

Gunakan alat **Zen CLI** untuk mengenerate file migrasi baru:

```bash
php zen make:migration create_users_table
```

Perintah di atas akan membuat class migrasi dengan *up* dan *down* method. Di dalam method `up`, Anda menulis definisi tabel yang ingin dibuat.

```php
use App\Core\Blueprint;

public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name', 100);
        $table->string('email', 100)->unique();
        $table->string('password', 255);
        $table->timestamps();
    });
}
```

### Menjalankan Migrasi

Untuk menjalankan semua migrasi (mengeksekusi SQL ke database):

```bash
php zen migrate
```

Perintah ini akan membaca file migrasi yang belum dijalankan dan membuat tabel tersebut di database yang terhubung pada file `.env` Anda.
