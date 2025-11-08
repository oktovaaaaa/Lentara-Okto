<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IslandController;

// Halaman utama: animasi card seperti piforrr.html
Route::get('/', [IslandController::class, 'landing'])->name('landing');

// Halaman detail tiap pulau (Sumatera, Jawa, dll)
Route::get('/islands/{island:slug}', [IslandController::class, 'show'])
    ->name('islands.show');

// (Optional) CRUD admin sederhana (nanti bisa kamu bikin view-nya)
// php artisan make:controller Admin/IslandController --resource --model=Island
// Route::resource('/admin/islands', \App\Http\Controllers\Admin\IslandController::class);
