<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

    // Sondages
        Route::prefix('survey')->group(function () {
        Route::get('/{organization?}/{survey?}', [SurveyController::class, 'index'])->name('survey');
        Route::post('/store/{organization}', [SurveyController::class, 'store'])->name('survey.store');
        Route::patch('/update/{survey}', [SurveyController::class, 'update'])->name('survey.update');
        Route::delete('/delete/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');
    });
});

        // Sondage public accessible sans login
        Route::get('/question/{token}', [SurveyController::class, 'showPublic'])->name('question');
        Route::patch('/survey/{survey}/question/{question}', [QuestionsController::class, 'update'])->name('question.update');
        Route ::post('/question/{survey}', [QuestionsController::class, 'store'])->name('question.store');

Route::post('/answers/store', [QuestionsController::class, 'store'])->name('answers.store');

require __DIR__.'/auth.php';
