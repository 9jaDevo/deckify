<?php

use App\Http\Controllers\GenerationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresentationController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/planning/phases-checklist', 'planning.phases-checklist')
    ->name('planning.phases-checklist');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [GenerationController::class, 'index'])->name('dashboard');
    Route::post('/generations', [GenerationController::class, 'store'])->name('generations.store');
    Route::get('/generations/{generation}', [GenerationController::class, 'show'])->name('generations.show');
    Route::get('/generations/{generation}/progress', [GenerationController::class, 'progress'])->name('generations.progress');
    Route::get('/generations/{generation}/status', [GenerationController::class, 'status'])->name('generations.status');
    Route::patch('/generations/{generation}/slide', [GenerationController::class, 'updateSlide'])->name('generations.slide.update');
    Route::patch('/generations/{generation}/refine', [GenerationController::class, 'refineSlide'])->name('generations.slide.refine');
    Route::get('/generations/{generation}/export', [GenerationController::class, 'export'])->name('generations.export');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





require __DIR__.'/auth.php';
