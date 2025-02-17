<?php

namespace App\Http\Controllers;

use App\Events\TagScanned;
use App\Models\Document;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $last_checked = Scan::latest()->first();

        return view('scan.index', compact('last_checked'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Scan $scan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scan $scan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scan $scan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scan $scan)
    {
        //
    }

    /**
     * Get API
     */
    public function scan(Request $request)
    {
        // Ambil data dan ubah menjadi array
        $tags = explode(',', $request->input('data'));

        // Pastikan data ada dan merupakan array
        if (empty($tags) || !is_array($tags)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid data format'
            ], 400);
        }

        // Validasi: Setiap elemen dalam array harus string
        $validated = ['data' => $tags]; // Menyesuaikan struktur request
        $request->merge($validated); // Update request sebelum validasi

        $request->validate([
            'data' => 'required|array',
            'data.*' => 'string'
        ]);

        $scannedTags = $tags;

        $allDocuments = Document::all();

        foreach ($allDocuments as $document) {
            if (in_array($document->rfid_number, $scannedTags)) {
                $document->is_there = true;
            } else {
                $document->is_there = false;
            }
            $document->save();
        }

        // Simpan log ke rfid_logs
        foreach ($request->data as $data) {
            $rfid = new Scan();
            $rfid->rfid_number = $data;
            $rfid->save();
        }

        TagScanned::dispatch($scannedTags);

        return response()->json([
            'message' => 'RFID sent successfully',
        ]);
    }
}
