<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', fn() => view('welcome'));

// Dashboard (auth + verified)
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Organizations
    Route::get('/organization', [OrganizationController::class, 'index'])->name('organizations.index');
    Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('/organization/store', [OrganizationController::class, 'store'])->name('organizations.store');
    Route::get('/organization/{organization}/update', [OrganizationController::class, 'updateForm'])->name('organizations.updateForm');
    Route::patch('/organization/update/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organization/destroy/{organization}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');

    // Surveys
    Route::prefix('survey')->group(function () {
        Route::get('/{organization}', [SurveyController::class, 'index'])->name('survey');
        Route::post('/store/{organization}', [SurveyController::class, 'store'])->name('survey.store');
        Route::patch('/update/{survey}', [SurveyController::class, 'update'])->name('survey.update');
        Route::delete('/delete/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');
    });
});

// Public survey
Route::get('/question/{token}', [SurveyController::class, 'showPublic'])->name('question');

// Store survey answers
Route::post('/answers/store', [QuestionsController::class, 'store'])->name('answers.store');

// Auth routes
require __DIR__.'/auth.php';
