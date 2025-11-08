<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IslandController;
use App\Http\Controllers\Admin\IslandStatController;

Route::get('/', [IslandController::class, 'landing'])->name('home');

Route::get('/islands/{island:slug}', [IslandController::class, 'show'])->name('islands.show');



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('stats', [IslandStatController::class, 'index'])->name('stats.index');
    Route::post('stats/population/{island}', [IslandStatController::class, 'updatePopulation'])->name('stats.population.update');

    Route::post('stats/{island}/demographics', [IslandStatController::class, 'storeDemographic'])->name('stats.demographics.store');
    Route::delete('stats/{island}/demographics/{demographic}', [IslandStatController::class, 'destroyDemographic'])->name('stats.demographics.destroy');

    // (updateDemographic bisa dipakai nanti kalau kamu mau form edit)
});

// Halaman utama: animasi card seperti piforrr.html
// Route::get('/', [IslandController::class, 'landing'])->name('landing');

// Halaman detail tiap pulau (Sumatera, Jawa, dll)
// Route::get('/islands/{island:slug}', [IslandController::class, 'show'])
//     ->name('islands.show');

// (Optional) CRUD admin sederhana (nanti bisa kamu bikin view-nya)
// php artisan make:controller Admin/IslandController --resource --model=Island
// Route::resource('/admin/islands', \App\Http\Controllers\Admin\IslandController::class);
