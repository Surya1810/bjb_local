<?php

namespace App\Http\Controllers;

use App\Events\TagScanned;
use App\Models\Document;
use App\Models\Agunan;
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
        //
    }

    /**
     * Menampilkan halaman scan dokumen.
     */
    public function document()
    {
        $last_checked = Scan::where('category', 'dokumen')->latest()->first();
        return view('scan.document', compact('last_checked'));
    }

    /**
     * Menampilkan halaman scan agunan.
     */
    public function agunan()
    {
        $last_checked = Scan::where('category', 'agunan')->latest()->first();
        $agunans = Agunan::all(); // Ambil semua data agunan

        return view('scan.agunan', compact('last_checked', 'agunans'));
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
    public function show(Scan $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scan $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scan $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scan $role)
    {
        //
    }

    /**
     * Proses scan RFID untuk Dokumen.
     */
    public function scan_document(Request $request)
    {
        // Pastikan data RFID diterima
        if (!$request->has('data')) {
            return response()->json([
                'status' => 'error',
                'message' => 'No RFID data received'
            ], 400);
        }

        // Ubah data RFID menjadi array
        $tags = explode(',', $request->input('data'));

        if (empty($tags)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid data format'
            ], 400);
        }

        // Update status document berdasarkan RFID
        $this->updateRFIDStatus(Document::class, $tags);

        // Simpan log scan
        $scan = new Scan();
        $scan->total = count($tags);
        $scan->category = 'dokumen';
        $scan->save();


        // Kirim event jika diperlukan
        TagScanned::dispatch($tags);

        return response()->json([
            'message' => 'RFID scanned successfully',
            'category' => 'dokumen'
        ]);
    }

    public function scan_agunan(Request $request)
    {
        if (!$request->has('data')) {
            return response()->json([
                'status' => 'error',
                'message' => 'No RFID data received'
            ], 400);
        }

        $tags = explode(',', $request->input('data'));

        if (empty($tags)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid data format'
            ], 400);
        }

        // Update status agunan berdasarkan RFID
        $this->updateRFIDStatus(Agunan::class, $tags);

        // Simpan log scan
        $scan = new Scan();
        $scan->total = count($tags);
        $scan->category = 'agunan';
        $scan->save();

        // Kirim event jika diperlukan
        TagScanned::dispatch($tags);

        return response()->json([
            'message' => 'RFID agunan scanned successfully',
            'category' => 'agunan'
        ]);
    }

    /**
     * Memperbarui status `is_there` dalam model.
     */
    private function updateRFIDStatus($model, $tags)
    {
        // Ambil semua data terkait
        $allItems = $model::all();

        foreach ($allItems as $item) {
            if (in_array($item->rfid_number, $tags)) {
                $item->is_there = true;
            } else {
                $item->is_there = false;
            }
            $item->save();
        }
    }

    public function dashboard()
    {
        // Ambil data terakhir kali scan
        $lastScan = Scan::latest()->first();
        $lastTimeScan = $lastScan ? $lastScan->created_at->toDateTimeString() : 'kosong';

        // Hitung total data (Dokumen + Agunan)
        $totalDocuments = Document::count();
        $totalAgunan = Agunan::count();
        $totalData = $totalDocuments + $totalAgunan;

        // Hitung total value (sesuaikan dengan field yang menyimpan value)
        $totalvalue = Document::sum('pinjaman');

        // Dokumen yang ditemukan dan hilang
        $totalDocumentsFound = Document::where('is_there', true)->count();
        $totalDocumentsLost = Document::where('is_there', false)->count();

        // value dari dokumen yang hilang
        $valueLostDocument = Document::where('is_there', false)->sum('pinjaman');

        // List dokumen yang hilang (misal ambil berdasarkan no_dokumen)
        $listDocumentLost = Document::where('is_there', true)->pluck('no_dokumen')->toArray();

        return response()->json([
            'status' => 'success',
            'data' => [
                'overview' => [
                    'lastTimeScan' => $lastTimeScan,
                    'totalData' => $totalData,
                    'totalvalue' => $totalvalue,
                ],
                'totalDocuments' => $totalDocuments,
                'totalAgunan' => $totalAgunan,
                'dashboard' => [
                    'totalDocumentsFound' => $totalDocumentsFound,
                    'totalDocumentsLost' => $totalDocumentsLost,
                    'valueLostDocument' => $valueLostDocument,
                    'listDocumentLost' => $listDocumentLost,
                ],
            ],
        ]);
    }
}
