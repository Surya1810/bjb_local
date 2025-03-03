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
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_from' => 'required|integer',
            'number_until' => 'required|integer|gte:number_from',
            'for' => 'required|string'
        ]);

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

        return redirect()->route('location.index')->with(['pesan' => 'Location created successfully', 'level-alert' => 'alert-success']);
    }



    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return response()->json($location);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'baris' => 'required|string|max:255',
            'rak' => 'required|string|max:255',

        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());

        return redirect()->route('location.index')->with('success', 'Location updated successfully!');
    }


    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('location.index')->with('success', 'Location deleted successfully!');
    }
}
