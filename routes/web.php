<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Recruiter\JobOfferController as RecruiterJobOfferController;
use App\Http\Controllers\ConnectionsController;




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
Route::middleware(['auth'])->group(function () {

    // offres (employee + recruiter peuvent consulter)
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');

    // profil public interne
    Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');

    // postuler (employee فقط)
    Route::middleware(['role:employee'])->group(function () {
        Route::post('/offers/{offer}/apply', [ApplicationController::class, 'store'])->name('offers.apply');
    });

    // recruteur (CRUD offres + candidatures)
    Route::prefix('recruiter')->name('recruiter.')->middleware(['role:recruiter'])->group(function () {
        Route::get('/offers', [RecruiterJobOfferController::class, 'index'])->name('offers.index');
        Route::get('/offers/create', [RecruiterJobOfferController::class, 'create'])->name('offers.create');
        Route::post('/offers', [RecruiterJobOfferController::class, 'store'])->name('offers.store');

        Route::get('/offers/{offer}/edit', [RecruiterJobOfferController::class, 'edit'])->name('offers.edit');
        Route::put('/offers/{offer}', [RecruiterJobOfferController::class, 'update'])->name('offers.update');

        Route::post('/offers/{offer}/close', [RecruiterJobOfferController::class, 'close'])->name('offers.close');
        Route::get('/offers/{offer}/applications', [RecruiterJobOfferController::class, 'applications'])->name('offers.applications');
    });

});
Route::get('/connections', [ConnectionsController::class, 'index'])->name('connections.index');
Route::post('/connections/{user}/request', [ConnectionsController::class, 'send'])->name('connections.request');
Route::post('/connections/requests/{friendRequest}/accept', [ConnectionsController::class, 'accept'])->name('connections.accept');
Route::post('/connections/requests/{friendRequest}/decline', [ConnectionsController::class, 'decline'])->name('connections.decline');


require __DIR__.'/auth.php';
