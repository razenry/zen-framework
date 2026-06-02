# Zen CLI (Command Line Interface)

Zen PHP dilengkapi dengan alat command-line bawaan yang dinamakan **Zen**. Alat ini mirip dengan Artisan pada Laravel. Zen CLI akan sangat membantu mempercepat produktivitas Anda dalam membuat berkas, migrasi database, dan lain-lain.

## Menjalankan Zen

Untuk melihat daftar semua perintah yang tersedia, jalankan perintah ini di root folder proyek:

```bash
php zen
```

## Membuat Controller

Untuk membuat controller baru dengan cepat:

```bash
php zen make:controller UserController
```

Perintah di atas akan menghasilkan file `UserController.php` di dalam folder `app/controllers/`.

## Membuat Model

Untuk membuat model baru:

```bash
php zen make:model User
```

File model akan dibuat di `app/models/User.php`.

## Membuat File Migrasi

Anda dapat membuat file migrasi baru untuk memodifikasi struktur database Anda menggunakan perintah:

```bash
php zen make:migration create_users_table
```

File migrasi yang dihasilkan akan diletakkan di dalam folder `database/migrations/` dengan timestamp yang akurat (Zona waktu otomatis di-set ke Asia/Jakarta).

## Menjalankan Migrasi Database

Setelah menulis skema migrasi Anda, jalankan migrasi dengan:

```bash
php zen migrate
```

Perintah ini akan mengeksekusi semua file migrasi yang ada di folder `database/migrations/` dan membuat tabel di database Anda.
