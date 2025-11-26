<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionsController;

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
    Route::get('/survey/{survey?}', [SurveyController::class, 'index'])->name('survey');

    Route::post('/survey/store', [SurveyController::class, 'store'])->name('survey.store');
    Route::patch('/survey/update/{survey}', [SurveyController::class, 'update'])->name('survey.update');
    Route::delete('/survey/delete/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');

    // Question Routes
    Route ::get('/question/{token}', [SurveyController::class, 'showPublic'])->name('question');

    // Answer Routes
    Route::get('/answer/test', [AnswerController::class, 'index'])->name('answer.test');
    Route::post('/answer/store', [AnswerController::class, 'store'])->name('answer.store');

require __DIR__.'/auth.php';
