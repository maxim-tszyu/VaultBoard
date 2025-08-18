<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
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
    Route::prefix('/tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
    });
    Route::prefix('/notes')->name('notes.')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('index');
    });
    Route::prefix('/entries')->name('entries.')->group(function () {
        Route::get('/', [EntryController::class, 'index'])->name('index');
    });
    Route::prefix('/finances')->name('finances.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
    });
    Route::get('/analysis', [AnalysisController::class])->name('analysis');
    Route::get('/report', [ReportController::class])->name('report');
});

require __DIR__.'/auth.php';
