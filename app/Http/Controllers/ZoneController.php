<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // 1. Grab the "search" query parameter (e.g. ?search=Central)
    $search = $request->query('search');

    // 2. Build the base query with eager loading
    $query = Zone::with('branches');

    // 3. If the user is searching, apply a name filter
    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    // 4. Order, paginate, and keep the search string in pagination links
    $zones = $query
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

    // 5. Get the total number of zones (unfiltered)
    $total_zones = Zone::count();

    // 6. Return the view
    return view('zones.index', [
        'zones'        => $zones,
        'total_zones'  => $total_zones,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Zone::create($data);
        return redirect()->route('zones.index')->with('success', 'Zone created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        $zone->load('branches');
        return view('zones.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        return view('zones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $zone->update($data);
        return redirect()->route('zones.index')->with('success', 'Zone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->deleted_by = auth()->id();
        $zone->save();
        $zone->delete();
        return redirect()->route('zones.index')->with('success', 'Zone deleted successfully.');
    }
}
