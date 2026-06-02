# Models

Setiap tabel di database memiliki class "Model" padanannya untuk memudahkan proses interaksi dengan tabel tersebut. Models diletakkan pada folder `app/models/`.

## Mendefinisikan Model

Model secara bawaan meng-extend `App\Core\Model`. Nama class pada model haruslah dalam bentuk tunggal (Singular), misalnya `Post`, maka model akan berasumsi tabelnya bernama jamak (Plural) yaitu `posts`.

```php
namespace App\Models;

use App\Core\Model;

class Post extends Model
{
    protected $table = 'posts'; // Opsional, model akan menebak namanya jika tidak ada
}
```

## Operasi CRUD Dasar

### Insert (Membuat Record Baru)

```php
$post = new Post();
$post->create([
    'title' => 'Judul Artikel',
    'body' => 'Isi artikel...',
    'user_id' => 1
]);
```

### Select (Mengambil Data)

Untuk mengambil semua data:
```php
$posts = (new Post())->all();
```

Untuk mengambil satu data berdasarkan ID:
```php
$post = (new Post())->find(1);
```

Atau mengambil data dengan kriteria WHERE:
```php
$activePosts = (new Post())->where('status', 'active')->get();
```

### Update (Mengubah Data)

```php
$postModel = new Post();
// Update status menjadi 'published' untuk post dengan id 1
$postModel->update(1, [
    'status' => 'published'
]);
```

### Delete (Menghapus Data)

```php
$postModel = new Post();
$postModel->delete(1); // Akan menghapus record post dengan id = 1
```
