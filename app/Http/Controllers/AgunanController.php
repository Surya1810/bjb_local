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
        $documents = Document::orderBy('created_at', 'desc')->get();
        $tags = Tag::where('status', 'available')->get();

        return view('agunan.index', compact('documents', 'tags'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agunan $agunan)
    {
        //
    }
}
