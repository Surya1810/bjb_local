<?php

use App\Http\Controllers\AgunanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();
Route::get('/password/change', [LoginController::class, 'password'])->name('password.change');
Route::post('/password/update', [LoginController::class, 'change_password'])->name('password.update');

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // User
    Route::resource('user', UserController::class);

    // Profile Section
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password/{id}', [ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile/delete/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Document
    Route::resource('document', DocumentController::class);
    Route::post('/document/import', [DocumentController::class, 'import'])->name('document.import');

    // Agunan
    Route::resource('agunan', AgunanController::class);
    Route::post('/agunan/import', [AgunanController::class, 'import'])->name('agunan.import');

    // Scan RFID
    Route::resource('scan', ScanController::class);

    // Tag RFID
    Route::resource('tag', TagController::class);
});
