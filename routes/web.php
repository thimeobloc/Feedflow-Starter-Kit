<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Organisations
    Route::get('/organization', [OrganizationController::class, 'index'])->name('organizations.index');
    Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('/organization/store', [OrganizationController::class, 'store'])->name('organizations.store');

    Route::get('/organization/{organization}/update', [OrganizationController::class, 'updateForm'])->name('organizations.updateForm');
    Route::patch('/organization/update/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organization/destroy/{organization}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');
});

require __DIR__.'/auth.php';
