<?php

use App\Http\Controllers\ProfileController;
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
});

    // Survey Routes
    Route::get('/survey/{survey?}', [SurveyController::class, 'index'])->name('survey');

    Route::post('/survey/store', [SurveyController::class, 'store'])->name('survey.store');
    Route::put('/survey/update/{survey}', [SurveyController::class, 'update'])->name('survey.update');
    Route::delete('/survey/delete/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');



require __DIR__.'/auth.php';
