<?php

namespace App\Http\Controllers;

use App\Models\Agunan;
use App\Models\Document;
use App\Models\Tag;
use Illuminate\Http\Request;

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
            'dokumen' => 'required',

            'agunans' => 'required|array',
            'agunans.*.rfid_number' => 'required|exists:tags,rfid_number|distinct',
            'agunans.*.name' => 'required|string',
            'agunans.*.number' => 'required'
        ]);

        $old = session()->getOldInput();

        $tag_agunans = collect($request->agunans)->pluck('rfid_number');
        $tags = Tag::whereIn('rfid_number', $tag_agunans)->get();

        foreach ($tags as $tag) {
            $tag->status = 'used';
            $tag->save();
        }
        foreach ($request->agunans as $agunan) {
            $dok_agunan = new Agunan();
            $dok_agunan->document_id = $request->dokumen;
            $dok_agunan->rfid_number = $agunan['rfid_number'];
            $dok_agunan->name = $agunan['name'];
            $dok_agunan->number = $agunan['number'];
            $dok_agunan->save();
        }

        return redirect()->route('agunan.index')->with(['pesan' => 'Agunan created successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agunan $agunan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agunan $agunan)
    {
        //
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

        $old = session()->getOldInput();

        $agunan->name = $request->name;
        $agunan->number = $request->number;
        $agunan->update();

        return redirect()->route('agunan.index')->with(['pesan' => 'Agunan updated successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agunan $agunan)
    {
        $tag = Tag::where('rfid_number', $agunan->rfid_number)->first();
        $tag->status = 'available';
        $tag->save();

        $agunan->delete();

        return redirect()->route('agunan.index')->with(['pesan' => 'Agunan deleted successfully', 'level-alert' => 'alert-success']);
    }
}
