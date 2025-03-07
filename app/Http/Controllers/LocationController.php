<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();

        return view('location.index', compact('locations'));
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

        return redirect()->route('location.index')->with(['pesan' => 'Location added successfully', 'level-alert' => 'alert-success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'baris' => 'required|string|max:255',
            'rak' => 'required|string|max:255',

        ]);

        $location = Location::findOrFail($location);
        $location->update($request->all());

        return redirect()->route('location.index')->with('success', 'Location updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location = Location::findOrFail($location);
        $location->delete();

        return redirect()->route('location.index')->with('success', 'Location deleted successfully!');
    }
}
