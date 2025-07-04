<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // or however you alias your PDF facade

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource, with optional search.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Expense::with('branch');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('recept_ref_number', 'like', "%{$search}%")
                  ->orWhereHas('branch', function($qb) use ($search) {
                      $qb->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $expenses = $query
            ->orderBy('expense_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('expenses.index', compact('expenses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $categories = [
            'Repairs/Maintainance','Office Supplies','Travel/Communication',
            'Admin Expenses','Miscellenous','Commisions','Fuel','Marketing'
        ];
        return view('expenses.create', compact('branches','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category'           => 'required|in:Repairs/Maintainance,Office Supplies,Travel/Communication,Admin Expenses,Miscellenous,Commisions,Fuel,Marketing',
            'description'        => 'required|string|max:255',
            'branch_id'          => 'required|exists:branches,id',
            'quantity'           => 'required|string|max:100',
            'expense_date'       => 'required|date',
            'amount'             => 'required|numeric|min:0',
            'recept_ref_number'  => 'nullable|string|max:100',
        ]);

        Expense::create($data);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expense->load('branch');
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $branches = Branch::orderBy('name')->get();
        $categories = [
            'Repairs/Maintainance','Office Supplies','Travel/Communication',
            'Admin Expenses','Miscellenous','Commisions','Fuel','Marketing'
        ];
        return view('expenses.edit', compact('expense','branches','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'category'           => 'required|in:Repairs/Maintainance,Office Supplies,Travel/Communication,Admin Expenses,Miscellenous,Commisions,Fuel,Marketing',
            'description'        => 'required|string|max:255',
            'branch_id'          => 'required|exists:branches,id',
            'quantity'           => 'required|string|max:100',
            'expense_date'       => 'required|date',
            'amount'             => 'required|numeric|min:0',
            'recept_ref_number'  => 'nullable|string|max:100',
        ]);

        $expense->update($data);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Expense $expense)
    {
        $expense->deleted_by = Auth::id();
        $expense->save();
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }


    /**
     * Show expenses report with optional branch & date filters.
     */
    public function expensesReport(Request $request)
    {
        $request->validate([
            'branch_id'  => ['nullable', 'integer', 'exists:branches,id'],
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // 1️⃣ Build branch list for dropdown, scoped by role
        $user = Auth::user();
        //$role = $user->role->name;
        $branchesQuery = Branch::orderBy('name');
        if ($user->hasRole('Management')) {
            $branchesQuery->where('zone_id', $user->zone_id);
        } elseif ($user->hasRole('User')) {
            $branchesQuery->where('id', $user->branch_id);
        }
        $branches = $branchesQuery->get();

        // 2️⃣ Only run expenses query if dates given
        $expenses    = collect();
        $totalAmount = 0;
        if ($request->filled(['start_date', 'end_date'])) {
            $expensesQuery = Expense::with('branch')
                ->whereBetween('expense_date', [
                    "{$request->start_date} 00:00:00",
                    "{$request->end_date} 23:59:59",
                ]);

            // 3️⃣ Optional branch filter
            if ($request->filled('branch_id')) {
                $expensesQuery->where('branch_id', $request->branch_id);
            }

            $expenses    = $expensesQuery->orderBy('expense_date', 'desc')->get();
            $totalAmount = $expenses->sum('amount');
        }

        return view('expenses.reports.expenses_report', [
            'branches'       => $branches,
            'expenses'       => $expenses,
            'totalAmount'    => $totalAmount,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'selectedBranch' => $request->branch_id,
        ]);
    }

    /**
     * Download expenses report PDF with same filters.
     */
    public function expensesReportDownload(Request $request)
    {
        $request->validate([
            'branch_id'  => ['nullable', 'integer', 'exists:branches,id'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $expensesQuery = Expense::with('branch')
            ->whereBetween('expense_date', [
                "{$request->start_date} 00:00:00",
                "{$request->end_date} 23:59:59",
            ]);

        if ($request->filled('branch_id')) {
            $expensesQuery->where('branch_id', $request->branch_id);
            $branchName = Branch::find($request->branch_id)->name;
        } else {
            $branchName = 'All Branches';
        }

        $expenses    = $expensesQuery->orderBy('expense_date', 'desc')->get();
        $totalAmount = $expenses->sum('amount');

        $pdf = Pdf::loadView('expenses.reports.pdfs.expenses_report_pdf', [
            'expenses'    => $expenses,
            'totalAmount' => $totalAmount,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'branchName'  => $branchName,
        ])->setPaper('a4', 'landscape');

        $filename = "expenses_report_{$request->start_date}_{$request->end_date}.pdf";
        return $pdf->download($filename);
    }
}
