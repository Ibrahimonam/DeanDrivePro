<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
//use PDF; // Make sure to import the PDF facade

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Grab the “search” input
    $search = $request->query('search');

    // Build the base query, eager‐loading the zone relationship
    $query = Branch::with('zone');

    // Apply a “name contains” filter if a search term was given
    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    // Optionally: you could also search by zone name or other fields
    // $query->when($search, function($q, $s) {
    //     $q->where('name', 'like', "%{$s}%")
    //       ->orWhereHas('zone', fn($z) => $z->where('name', 'like', "%{$s}%"));
    // });

    // Order and paginate, preserving query string (so “search” stays in links)
    $branches = $query
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

    // Get overall total independently (you could also use $branches->total())
    $total_branches = Branch::count();

    // Render view
    return view('branches.index', [
        'branches'       => $branches,
        'total_branches' => $total_branches,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all();
        return view('branches.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'nullable|string',
            'paybill_number' => 'nullable|string',
        ]);

        Branch::create($data);
        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $branch->load('zone');
        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        
        $zones = Zone::all();
        return view('branches.edit', compact('branch', 'zones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'nullable|string',
            'paybill_number' => 'nullable|string',
        ]);

        $branch->update($data);
        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
       
        $branch->deleted_by = auth()->id();
        $branch->save();
        $branch->delete();
        return to_route('branches.index')->with('success', 'Branch deleted successfully.');
    }
    /**
     * Download a list of branches to pdf.
     */
    public function exportPDF()
    {
        $branches = Branch::all();
        $pdf = PDF::loadView('branches.pdf', compact('branches'));
        return $pdf->download('branches_list.pdf');
    }



    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $branchesQuery = Branch::with('zone')
            ->withCount(['students as active_students_count' => function($q) {
                $q->where('student_status', 'active');
            }]);

        if ($user->hasRole('Management')) {
            $branchesQuery->where('zone_id', $user->zone_id);
        } elseif (!$user->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }

        $branches = $branchesQuery
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('branches.dashboard', compact('branches'));
    }




}
