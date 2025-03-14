<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $tags = Tag::all();
        $rows = Location::where('for', 'baris')->get();
        $racks = Location::where('for', 'rak')->get();


        return view('location.index', compact('locations', 'tags', 'rows', 'racks'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_from' => 'required|integer',
            'number_until' => 'required|integer|gte:number_from',
            'for' => 'required|string'
        ]);

        $existingNumbers = Location::where('for', $request->for)->whereIn('number', range($request->number_from, $request->number_until))
            ->pluck('number')
            ->toArray();

        if (!empty($existingNumbers)) {
            return redirect()->back()->with([
                'pesan' => 'Beberapa nomor sudah ada',
                'level-alert' => 'alert-danger'
            ])->withInput();
        }

        $locations = [];
        for ($i = (int) $request->number_from; $i <= (int) $request->number_until; $i++) {
            $locations[] = [
                'number' => $i,
                'for' => $request->for,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Location::insert($locations);

        return redirect()->route('location.index')->with([
            'pesan' => 'Location created successfully',
            'level-alert' => 'alert-success'
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('location.index')->with(['pesan' => 'Location deleted successfully', 'level-alert' => 'alert-success']);
    }
}
