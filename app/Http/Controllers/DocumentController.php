<?php

namespace App\Http\Controllers;

use App\Exports\DocumentsExport;
use App\Imports\DocumentsImport;
use App\Models\Agunan;
use App\Models\Document;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
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

            'agunans' => 'sometimes|array', // Agunans bisa kosong saat update
            'agunans.*.id' => 'sometimes|exists:agunans,id', // Validasi ID agunan jika ada
            'agunans.*.rfid_number' => 'required|exists:tags,rfid_number',
            'agunans.*.name' => 'required|string',
            'agunans.*.number' => 'required',
        ]);

        // Update data dokumen
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

        // Proses data agunan
        if ($request->has('agunans')) {
            $agunanData = $request->input('agunans');

            // Iterasi melalui setiap data agunan yang dikirim dari form
            foreach ($agunanData as $index => $data) {
                // Jika ada ID, berarti agunan sudah ada dan perlu diupdate
                if (isset($data['id'])) {
                    $agunan = Agunan::find($data['id']);

                    // Jika agunan ditemukan, update datanya
                    if ($agunan) {
                        $agunan->rfid_number = $data['rfid_number'];
                        $agunan->name = $data['name'];
                        $agunan->number = $data['number'];
                        $agunan->save();
                    }
                }
                // Jika tidak ada ID, berarti agunan baru dan perlu dibuat
                else {
                    $agunan = new Agunan();
                    $agunan->document_id = $document->id;
                    $agunan->rfid_number = $data['rfid_number'];
                    $agunan->name = $data['name'];
                    $agunan->number = $data['number'];
                    $agunan->save();
                }
            }
        }

        // Redirect dengan pesan sukses
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
        return Excel::download(new DocumentsExport, 'documents.xlsx');
    }
}
