<?php

namespace App\Http\Controllers;

use App\Exports\DocumentsExport;
use App\Exports\MissingDocExport;
use App\Exports\FoundDocExport;
use App\Imports\DocumentsImport;
use App\Models\Agunan;
use App\Models\ChangeHistory;
use App\Models\Document;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::orderBy('created_at', 'desc')->get();
        $tags = Tag::where('status', 'available')->get();
        $rows = Location::where('for', 'baris')->get();
        $racks = Location::where('for', 'rak')->get();

        return view('document.index', compact('documents', 'tags', 'rows', 'racks'));
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
        // dd($request);
        $request->validate([
            'tag' => 'required|exists:tags,rfid_number',
            'cif' => 'required',
            'nik' => 'required|max:16',
            'nama' => 'required|string',
            'rekening' => 'required|numeric',
            'telepon' => 'required|min:10',
            'instansi' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',

            'dokumen' => 'required|max:255',
            'segmen' => 'required',
            'cabang' => 'required',
            'akad' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'lama' => 'required|integer|min:1',
            'nilai' => 'required|numeric|min:0',

            'ruangan' => 'required',
            'baris' => 'required',
            'rak' => 'required',
            'box' => 'required',

            'agunans' => 'required|array',
            'agunans.*.rfid_number' => 'required|exists:tags,rfid_number|distinct',
            'agunans.*.name' => 'required|string',
            'agunans.*.number' => 'required',
        ]);

        $old = session()->getOldInput();

        // Update Tag Status
        $tag_document = collect($request->tag)->toArray();
        $tag_agunans = collect($request->agunans)->pluck('rfid_number');
        if ($tag_agunans->contains($request->tag)) {
            throw ValidationException::withMessages([
                'agunans.*.tag' => 'Tag agunan tidak boleh sama dengan tag dokumen.'
            ]);
        }
        $merged = array_merge($tag_document, $tag_agunans->toArray());
        $tags = Tag::whereIn('rfid_number', $merged)->get();

        foreach ($tags as $tag) {
            $tag->status = 'used';
            $tag->save();
        }

        $document = new Document();
        $document->rfid_number = $request->tag;
        $document->cif = $request->cif;
        $document->nik_nasabah = $request->nik;
        $document->nama_nasabah = $request->nama;
        $document->alamat_nasabah = $request->alamat;
        $document->telp_nasabah = $request->telepon;
        $document->pekerjaan_nasabah = $request->pekerjaan;
        $document->rekening_nasabah = $request->rekening;
        $document->instansi = $request->instansi;

        $document->no_dokumen = $request->dokumen;
        $document->segmen = $request->segmen;
        $document->cabang = $request->cabang;
        $document->akad = $request->akad;
        $document->jatuh_tempo = $request->jatuh_tempo;
        $document->lama = $request->lama;
        $document->pinjaman = $request->nilai;

        $document->room = $request->ruangan;
        $document->row = $request->baris;
        $document->rack = $request->rak;
        $document->box = $request->box;

        $document->save();

        // Simpan agunan
        foreach ($request->agunans as $agunan) {
            $dok_agunan = new Agunan();
            $dok_agunan->document_id = $document->id;
            $dok_agunan->rfid_number = $agunan['rfid_number'];
            $dok_agunan->name = $agunan['name'];
            $dok_agunan->number = $agunan['number'];

            $dok_agunan->save();
        }

        return redirect()->route('document.index')->with(['pesan' => 'Document & Agunan created successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $rows = Location::where('for', 'baris')->orderBy('number', 'asc')->get();
        $racks = Location::where('for', 'rak')->orderBy('number', 'asc')->get();

        return view('document.edit', compact('document', 'rows', 'racks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        // Validasi input
        $request->validate([
            'cif' => 'required',
            'nik' => 'required|max:16',
            'nama' => 'required|string',
            'rekening' => 'required|numeric',
            'telepon' => 'required|min:10',
            'instansi' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',

            'segmen' => 'required',
            'cabang' => 'required',
            'akad' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'lama' => 'required|integer|min:1',
            'nilai' => 'required|numeric|min:0',

            'ruangan' => 'required',
            'baris' => 'required',
            'rak' => 'required',
            'box' => 'required',
        ]);

        // Update data dokumen
        $document->cif = $request->cif;
        $document->nik_nasabah = $request->nik;
        $document->nama_nasabah = $request->nama;
        $document->alamat_nasabah = $request->alamat;
        $document->telp_nasabah = $request->telepon;
        $document->pekerjaan_nasabah = $request->pekerjaan;
        $document->rekening_nasabah = $request->rekening;
        $document->instansi = $request->instansi;
        $document->segmen = $request->segmen;
        $document->cabang = $request->cabang;
        $document->akad = $request->akad;
        $document->jatuh_tempo = $request->jatuh_tempo;
        $document->lama = $request->lama;
        $document->pinjaman = $request->nilai;
        $document->room = $request->ruangan;
        $document->row = $request->baris;
        $document->rack = $request->rak;
        $document->box = $request->box;
        $document->save();

        return redirect()->route('document.index')->with(['pesan' => 'Document updated successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $agunans = $document->agunans;

        // Update Tag Status
        $tag_document = collect($document->rfid_number)->toArray();
        $tag_agunans = collect($agunans)->pluck('rfid_number')->toArray();
        $merged = array_merge($tag_document, $tag_agunans);
        $tags = Tag::whereIn('rfid_number', $merged)->get();

        foreach ($tags as $tag) {
            $tag->status = 'available';
            $tag->save();
        }
        foreach ($agunans as $agunan) {
            $agunan->delete();
        }
        $document->delete();

        return redirect()->route('document.index')->with(['pesan' => 'Document & Agunan deleted successfully', 'level-alert' => 'alert-success']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new DocumentsImport, $request->file('file'));
            return back()->with(['pesan' => 'Assets imported successfully', 'level-alert' => 'alert-success']);
        } catch (\Exception $e) {
            return back()->with(['pesan' => $e->getMessage(), 'level-alert' => 'alert-danger']);
        }
    }

    public function export()
    {
        $date = date('Y-m-d');
        $fileName = "document-$date.xlsx";

        return Excel::download(new DocumentsExport, $fileName);
    }



    public function exportMissing($type)
    {
        $data = Document::where('is_there', false)->get();
        $date = Carbon::now()->format('Ymd');

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('exports.document-pdf', compact('data'))
                ->setPaper('a4', 'landscape');

            return $pdf->download("Berita_Acara_Kehilangan_{$date}.pdf");
        } else {
            return Excel::download(new MissingDocExport, "Berita_Acara_Kehilangan_{$date}.xlsx");
        }
    }

    public function exportFound($type)
    {
        $date = Carbon::now()->format('Ymd');

        if ($type === 'pdf') {
            return Excel::download(new FoundDocExport, "Berita_Acara_Ditemukan_{$date}.pdf", \Maatwebsite\Excel\Excel::DOMPDF);
        } else {
            return Excel::download(new FoundDocExport, "Berita_Acara_Ditemukan_{$date}.xlsx");
        }
    }



    public function borrowForm($id)
    {
        $document = Document::findOrFail($id);
        $document->borrowed_by = $document->status && str_starts_with($document->status, 'Dipinjam oleh')
            ? str_replace('Dipinjam oleh ', '', $document->status)
            : '';
        return view('document.borrow', compact('document'));
    }

    public function borrowStore(Request $request, $id)
    {
        $request->validate([
            'borrowed_by' => 'required|string|max:255',
        ]);

        $document = Document::findOrFail($id);
        $document->status = 'Dipinjam oleh ' . $request->borrowed_by;
        $document->save();

        // Simpan ke Change History (hanya peminjaman, tanpa "Data telah diedit")
        ChangeHistory::create([
            'entity_type' => 'document',
            'no_dokumen' => $document->no_dokumen,
            'user_id' => Auth::user()->id,
            'changes' => json_encode([
                'status' => 'Data dipinjam oleh ' . $request->borrowed_by,
            ], JSON_PRETTY_PRINT),
        ]);

        return redirect()->route('document.index')->with('success', 'Dokumen berhasil dipinjam!');
    }

    public function return($id)
    {
        $document = Document::findOrFail($id);

        $document->status = '-';
        $document->save();

        ChangeHistory::create([
            'entity_type' => 'document',
            'no_dokumen' => $document->no_dokumen,
            'user_id' => Auth::user()->id,
            'changes' => json_encode([
                'status' => 'Document telah dikembalikan',
            ], JSON_PRETTY_PRINT),
        ]);

        return redirect()->route('document.index')->with('success', 'Peminjaman dikembalikan.');
    }
}
