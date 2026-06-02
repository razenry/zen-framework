<?php

use App\Core\Route;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\PostController;

use App\Controllers\CommentController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Post Routes (CRUD)
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::post('/posts/{id}/delete', [PostController::class, 'delete'])->name('posts.delete');

// Comments
Route::post('/posts/{id}/comment', [CommentController::class, 'store'])->name('comments.store');

// Documentation
use App\Controllers\DocsController;
Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
Route::get('/docs/{page}', [DocsController::class, 'show'])->name('docs.show');
