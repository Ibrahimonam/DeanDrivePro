<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource, with search & pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Teacher::with('branch');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name',   'like', "%{$search}%")
                  ->orWhere('last_name',  'like', "%{$search}%")
                  ->orWhere('email',      'like', "%{$search}%")
                  ->orWhere('phone_number','like', "%{$search}%")
                  ->orWhere('id_number',  'like', "%{$search}%")
                  ->orWhereHas('branch', function($qb) use ($search) {
                      $qb->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $teachers = $query
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('teachers.index', compact('teachers', 'search'));
    }

    /**
     * Show form for creating a new Teacher.
     */
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        return view('teachers.create', compact('branches'));
    }

    /**
     * Store a newly created Teacher.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'email'        => 'required|email|unique:teachers,email',
            'phone_number' => 'required|string|max:20',
            'id_number'    => 'required|string|max:20|unique:teachers,id_number',
            'branch_id'    => 'required|exists:branches,id',
        ]);

        Teacher::create($data);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified Teacher.
     */
    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show form for editing the specified Teacher.
     */
    public function edit(Teacher $teacher)
    {
        $branches = Branch::orderBy('name')->get();
        return view('teachers.edit', compact('teacher', 'branches'));
    }

    /**
     * Update the specified Teacher.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'email'        => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone_number' => 'required|string|max:20',
            'id_number'    => 'required|string|max:20|unique:teachers,id_number,' . $teacher->id,
            'branch_id'    => 'required|exists:branches,id',
        ]);

        $teacher->update($data);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Soft-delete the specified Teacher, capturing who deleted it.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->deleted_by = Auth::id();
        $teacher->save();
        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
