<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Tag;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::all();
        $tags = Tag::where('status', 'available')->get();

        return view('document.index', compact('documents', 'tags'));
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
        $request->validate([
            'rfid_number' => 'required',
            'cif' => 'required',
            'nik' => 'required|max:16',
            'nama' => 'required',
            'rekening' => 'required|numeric',
            'telepon' => 'required|min:10',
            'instansi' => 'required',
            'pekerjaan' => 'required',
            'alamat' => 'required',

            'dokumen' => 'required|max:255',
            'cabang' => 'required|max:255',
            'akad' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'lama' => 'required|max:255',
            'nilai' => 'required|max:255',

            'ruangan' => 'required|max:255',
            'baris' => 'required|max:255',
            'rak' => 'required|max:255',
            'box' => 'required|max:255',

            'agunans' => 'required|array',
            'agunans.*.rfid_number' => 'required',
            'agunans.*.name' => 'required|max:255',
            'agunans.*.number' => 'required|max:255',
        ]);

        $old = session()->getOldInput();

        dd($request);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
