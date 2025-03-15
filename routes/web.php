<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\AgunanController;
use App\Http\Controllers\ChangeHistoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('report.index');
});

Auth::routes();
Route::get('/password/change', [LoginController::class, 'password'])->name('password.change');
Route::post('/password/updated', [LoginController::class, 'change_password'])->name('password.updated');

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', function () {
        return redirect()->route('report.index');
    })->name('home');
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
    Route::get('/export/documents', [DocumentController::class, 'export'])->name('document.export');
    Route::get('/document/{id}/borrow', [DocumentController::class, 'borrowForm'])->name('document.borrow');
    Route::post('/document/{id}/borrow', [DocumentController::class, 'borrowStore'])->name('document.borrow.store');
    Route::delete('/document/{id}/return', [DocumentController::class, 'return'])->name('document.return');

    // Agunan
    Route::resource('agunan', AgunanController::class);
    Route::post('/agunan/import', [AgunanController::class, 'import'])->name('agunan.import');
    Route::get('/export/agunan', [AgunanController::class, 'export'])->name('agunan.export');


    // Scan RFID
    Route::resource('scan', ScanController::class);
    Route::get('/scan-document', [ScanController::class, 'document'])->name('scan.index_document');
    Route::get('/scan-agunan', [ScanController::class, 'agunan'])->name('scan.index_agunan');

    // Tag RFID
    Route::resource('tag', TagController::class);
    Route::get('/export/tag', [TagController::class, 'export'])->name('tag.export');

    // Location
    Route::resource('location', LocationController::class);

    // Report
    Route::get('report', [ReportController::class, 'index'])->name('report.index');

    // History
    Route::get('history', [ChangeHistoryController::class, 'index'])->name('history.index');
});
