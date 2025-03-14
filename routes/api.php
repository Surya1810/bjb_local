<?php

use App\Http\Controllers\ScanController;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/scan-document', [ScanController::class, 'scan_document']);
Route::post('/scan-agunan', [ScanController::class, 'scan_agunan']);
Route::get('/dashboard', [ScanController::class, 'dashboard']);

Route::get('/documents', function () {
    return response()->json(
        Document::with(['tag:rfid_number,rfid_number', 'agunans'])->get()
    );
});

Route::get('/last-scan', function () {
    return response()->json([
        'lastTimeScan' => now()->format('d/m/Y H:i:s')
    ]);
});
