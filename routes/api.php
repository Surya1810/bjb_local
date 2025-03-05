<?php

use App\Http\Controllers\ScanController;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/data', [ScanController::class, 'scan']);

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

Route::post('/compare-rfid', [ScanController::class, 'compareRFID']);
