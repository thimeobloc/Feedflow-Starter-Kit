<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Survey Routes
    Route::post('/survey/store', [SurveyController::class, 'add'])->name('survey.store');
    Route::patch('/survey/store', [SurveyController::class, 'update'])->name('survey.store');
    Route::delete('/survey/store', [SurveyController::class, 'destroy'])->name('survey.store');


Route::get('/survey/test', function() {return view('test_survey');});

require __DIR__.'/auth.php';
