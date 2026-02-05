<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/search', [UserSearchController::class, 'index'])->name('users.search');
});
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::post('/profile/experiences', [ExperienceController::class, 'store'])->name('experiences.store');
    Route::patch('/profile/experiences/{experience}', [ExperienceController::class, 'update'])->name('experiences.update');
    Route::delete('/profile/experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');

    Route::post('/profile/educations', [EducationController::class, 'store'])->name('educations.store');
    Route::patch('/profile/educations/{education}', [EducationController::class, 'update'])->name('educations.update');
    Route::delete('/profile/educations/{education}', [EducationController::class, 'destroy'])->name('educations.destroy');
});


require __DIR__.'/auth.php';
