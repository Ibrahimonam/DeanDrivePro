<?php

namespace App\Http\Controllers;

use App\Models\Practical;
use Illuminate\Http\Request;

class PracticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $practicals = Practical::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%")
                             ->orWhere('duration', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('practicals.index', compact('practicals', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('practicals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
        ]);

        Practical::create($request->only('name', 'description', 'duration'));

        return redirect()->route('practicals.index')->with('success', 'Practical created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Practical $practical)
    {
        return view('practicals.show', compact('practical'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Practical $practical)
    {
        return view('practicals.edit', compact('practical'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Practical $practical)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
        ]);

        $practical->update($request->only('name', 'description', 'duration'));

        return redirect()->route('practicals.index')->with('success', 'Practical updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Practical $practical)
    {
        $practical->deleted_by = auth()->id();
        $practical->save();
        $practical->delete();

        return redirect()->route('practicals.index')->with('success', 'Practical deleted successfully.');
    }
}
