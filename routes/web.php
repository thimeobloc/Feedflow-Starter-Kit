<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/organization', [OrganizationController::class, 'index'])
        ->name('organizations.index');

    Route::get('/organization/create', [OrganizationController::class, 'create'])
        ->name('organizations.create');

    Route::post('/organization', [OrganizationController::class, 'store'])
        ->name('organizations.store');

    Route::delete('/organization/{organization}', [OrganizationController::class, 'destroy'])
        ->name('organizations.destroy');
});

// Survey Routes
    Route::get('/survey', [SurveyController::class, 'index'])->name('survey');
    Route::post('/survey/add', [SurveyController::class, 'add'])->name('survey.add');
    Route::patch('/survey/edit', [SurveyController::class, 'update'])->name('survey.edit');
    Route::delete('/survey/destroy', [SurveyController::class, 'destroy'])->name('survey.destroy');


require __DIR__.'/auth.php';
