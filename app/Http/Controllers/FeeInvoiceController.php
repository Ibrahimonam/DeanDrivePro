<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Http\Controllers\Controller;

class FeeInvoiceController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $branch = $user->branch_id;
        $zone   = $user->zone_id;
        //$role   = $user->role->name;  // or $user->role_id if you prefer numeric checks
        $role = $user->getRoleNames()->join(', ');
    
        // Base query with eager loading
        $query = FeeInvoice::with(['student', 'branch']);
    
        // Apply branch/zone filters based on role
        if ($role === 'User') {
            // Only this user’s branch
            $query->where('branch_id', $branch);
    
        } elseif ($role === 'Management') {
            // Only invoices for branches in the manager’s zone
            $query->whereHas('branch', function($q) use ($zone) {
                $q->where('zone_id', $zone);
            });
        }
        // Admin sees all invoices
    
        // Finally paginate
        $invoices = $query->orderBy('created_at', 'desc')
                          ->paginate(15)
                          ->withQueryString();
    
        return view('invoices.index', compact('invoices'));
    }
    
    public function create(Request $request)
    {
        $branches = Branch::all();

        // If we passed ?student_id=123, load that student
        $student = null;
        if ($request->filled('student_id')) {
            $student = Student::findOrFail($request->student_id);
        }

        // If you still want to allow free student selection, also pass students:
        $students = $student ? [] : Student::all();

        return view('invoices.create', compact('branches', 'student','students'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'      => 'required|exists:students,id',
            'branch_id'       => 'required|exists:branches,id',
            'amount_original' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'due_date'        => 'required|date',
        ]);
        $data['discount_amount'] = $data['discount_amount'] ?? 0;
        $data['amount_due']      = $data['amount_original'] - $data['discount_amount'];
        $data['status']          = 'open';

        $invoice = FeeInvoice::create($data);

        return redirect()->route('invoices.show', $invoice)
                         ->with('success', 'Invoice created successfully.');
    }

    public function show(FeeInvoice $invoice)
    {
        $invoice->load('student', 'branch', 'payments');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(FeeInvoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, FeeInvoice $invoice)
    {
        $data = $request->validate([
            'student_id'      => 'required|exists:students,id',
            'branch_id'       => 'required|exists:branches,id',
            'amount_original' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'due_date'        => 'required|date',
        ]);
        $data['discount_amount'] = $data['discount_amount'] ?? 0;
        $data['amount_due']      = $data['amount_original'] - $data['discount_amount'];

        $invoice->update($data);

        // Re-check status if fully paid
        if ($invoice->isPaid()) {
            $invoice->update(['status' => 'paid']);
        } elseif ($invoice->status === 'paid') {
            $invoice->update(['status' => 'open']);
        }

        return redirect()->route('invoices.show', $invoice)
                         ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(FeeInvoice $invoice)
    {
        // Optionally: prevent deleting if payments exist
        if ($invoice->payments()->exists()) {
            return back()->with('error', 'Cannot delete invoice with payments.');
        }

        $invoice->delete();
        return redirect()->route('invoices.index')
                         ->with('success', 'Invoice deleted successfully.');
    }
    // Payments Dashboard

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Base query: branches + zone + payments count & sum
        $branchesQuery = Branch::with('zone')
            ->withCount('payments')
            ->withSum('payments', 'amount_paid');

        if ($user->hasRole('Management')) {
            $branchesQuery->where('zone_id', $user->zone_id);
        } elseif (!$user->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }

        $branches = $branchesQuery
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('invoices.dashboard', compact('branches'));
    }

    // Invoices by branch

    public function byBranch(Request $request, Branch $branch)
    {
        $user = Auth::user();

        // Authorization using Spatie roles
        if ($user->hasRole('Management') && $branch->zone_id !== $user->zone_id) {
            abort(403, 'Unauthorized');
        }

        if ($user->hasRole('User')) {
            abort(403, 'Unauthorized');
        }

        $search = $request->query('search');

        // Base query: invoices for that branch
        $query = FeeInvoice::with('student', 'branch')
            ->where('branch_id', $branch->id);

        // Optional search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            });
        }

        $invoices = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('invoices.index', [
            'invoices' => $invoices,
            'search'   => $search,
            'backUrl'  => route('invoices.dashboard'),
            'backText' => '← Back to Payments Dashboard',
            'pageTitle' => "Invoices for “{$branch->name}”",
        ]);
    }

}

