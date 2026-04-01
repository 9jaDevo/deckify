<?php

use App\Http\Controllers\GenerationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/planning/phases-checklist', 'planning.phases-checklist')
    ->name('planning.phases-checklist');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [GenerationController::class, 'index'])->name('dashboard');
    Route::post('/generations', [GenerationController::class, 'store'])->name('generations.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
