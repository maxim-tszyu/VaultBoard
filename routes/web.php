<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('/tasks')->name('tasks.')->group(function () {
        Route::delete('/destroy', [TaskController::class, 'destroy'])->name('destroy');
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('edit');
        Route::patch('/update_status/{task}', TaskStatusController::class)->name('update.status');
        Route::post('/store', [TaskController::class, 'store'])->name('store');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('update');
    });
    Route::prefix('/notes')->name('notes.')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('index');
        Route::post('/store', [NoteController::class, 'store'])->name('store');
    });
    Route::prefix('/entries')->name('entries.')->group(function () {
        Route::get('/', [EntryController::class, 'index'])->name('index');
    });
    Route::prefix('/finances')->name('finances.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
    });
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
    });
    Route::prefix('/logs')->name('logs.')->group(function () {
        Route::post('/store', [ActivityLogController::class, 'store'])->name('store');
    });
    Route::get('/analysis/{task}', AnalysisController::class)->name('analysis');
    Route::get('/report', [ReportController::class])->name('report');
});

Broadcast::routes();

require __DIR__ . '/auth.php';
