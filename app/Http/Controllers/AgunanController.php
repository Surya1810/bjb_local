<?php

namespace App\Http\Controllers;

use App\Models\Agunan;
use App\Models\Document;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Imports\AgunansImport;
use App\Exports\AgunansExport;
use Maatwebsite\Excel\Facades\Excel;

class AgunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agunans = Agunan::all();
        $documents = Document::orderBy('created_at', 'desc')->get();
        $tags = Tag::where('status', 'available')->get();

        return view('agunan.index', compact('documents', 'tags', 'agunans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dokumen' => 'required',
            'agunans' => 'required|array',
            'agunans.*.rfid_number' => 'required|exists:tags,rfid_number|distinct',
            'agunans.*.name' => 'required|string',
            'agunans.*.number' => 'required'
        ]);

        $tag_agunans = collect($request->agunans)->pluck('rfid_number');
        $tags = Tag::whereIn('rfid_number', $tag_agunans)->get();

        foreach ($tags as $tag) {
            $tag->status = 'used';
            $tag->save();
        }

        foreach ($request->agunans as $agunan) {
            Agunan::create([
                'document_id' => $request->dokumen,
                'rfid_number' => $agunan['rfid_number'],
                'name' => $agunan['name'],
                'number' => $agunan['number'],
            ]);
        }

        return redirect()->route('agunan.index')->with(['pesan' => 'Agunan created successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agunan $agunan)
    {
        $request->validate([
            'name' => 'required|string',
            'number' => 'required',
        ]);

        $agunan->update([
            'name' => $request->name,
            'number' => $request->number,
        ]);

        return redirect()->route('agunan.index')->with(['pesan' => 'Agunan updated successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agunan $agunan)
    {
        $tag = Tag::where('rfid_number', $agunan->rfid_number)->first();
        if ($tag) {
            $tag->status = 'available';
            $tag->save();
        }

        $agunan->delete();

        return redirect()->route('agunan.index')->with(['pesan' => 'Agunan deleted successfully', 'level-alert' => 'alert-success']);
    }

    public function show($id)
    {
        $agunan = Agunan::findOrFail($id);
        return view('agunan.show', compact('agunan'));
    }


    /**
     * Import Agunan from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Import data agunan dari file Excel
            Excel::import(new AgunansImport, $request->file('file'));

            // Ambil semua rfid_number dari tabel agunans yang baru diimport
            $rfidNumbers = Agunan::pluck('rfid_number')->toArray();

            // Update status tag RFID menjadi "used"
            $tags = Tag::whereIn('rfid_number', $rfidNumbers)->get();
            foreach ($tags as $tag) {
                $tag->status = 'used';
                $tag->save();
            }


            Tag::whereIn('rfid_number', $rfidNumbers)->update(['status' => 'used']);

            return back()->with(['pesan' => 'Data Agunan berhasil diimport!', 'level-alert' => 'alert-success']);
        } catch (\Exception $e) {
            return back()->with(['pesan' => 'Gagal mengimport data: ' . $e->getMessage(), 'level-alert' => 'alert-danger']);
        }
    }


    public function export()
    {

        $date = date('Y-m-d');
        $fileName = "agunan-$date.xlsx";

        return Excel::download(new AgunansExport, $fileName);
    }
}
