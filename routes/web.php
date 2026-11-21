<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('categories', CategoryController::class)->except('show');
});

// Productos: el administrador y el vendedor pueden consultar la lista
Route::middleware(['auth', 'role:administrador,vendedor'])->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
});

// Productos: solo el administrador crea, edita y elimina
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('products', ProductController::class)->except(['index', 'show']);
});

require __DIR__.'/auth.php';
