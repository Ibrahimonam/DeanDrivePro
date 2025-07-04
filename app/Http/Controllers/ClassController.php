<?php
namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ClassModel::query();

        // Optional search by name or description
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Paginate results
        $classes = $query->latest()->paginate(10)->withQueryString();

        return view('classes.index', compact('classes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:100',
            'fee' => 'required|numeric|min:0',
        ]);

        ClassModel::create($validated);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassModel $class)
    {
        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassModel $class)
    {
        return view('classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:100',
            'fee' => 'required|numeric|min:0',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(ClassModel $class)
    {
        $class->deleted_by = Auth::id();
        $class->save();
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }

    /**
     * Show trashed classes (optional).
     */
    public function trashed()
    {
        $trashedClasses = ClassModel::onlyTrashed()->get();
        return view('classes.trashed', compact('trashedClasses'));
    }

    /**
     * Restore a soft deleted class (optional).
     */
    public function restore($id)
    {
        $class = ClassModel::onlyTrashed()->findOrFail($id);
        $class->restore();

        return redirect()->route('classes.index')->with('success', 'Class restored successfully.');
    }
}
