<?php

namespace App\Http\Controllers;

use App\Models\Payment;        // ← MODEL
use App\Models\FeeInvoice;     // if you need the invoice
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Zone;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SmsNotification;

class PaymentController extends Controller
{
  public function store(Request $request, FeeInvoice $invoice)
{
    $amount = $request->input('amount_paid');

    // 1️⃣ Prevent overpayment
    if ($amount > $invoice->balance) {
        return back()
            ->withInput()
            ->with('error', 'You cannot pay more than the remaining balance (KSh '
                . number_format($invoice->balance, 2) . ').');
    }

    // 2️⃣ Validate input
    $request->validate([
        'amount_paid'    => "required|numeric|min:0.01|max:{$invoice->balance}",
        'payment_method' => 'required|in:Mpesa,Cheque,Cash,Card',
        'tran_code'      => 'nullable|string',
    ]);

    // 3️⃣ Record the payment
    $payment = $invoice->payments()->create([
        'amount_paid'    => $amount,
        'payment_method' => $request->payment_method,
        'tran_code'      => $request->tran_code,
        'payment_date'   => now(),
    ]);

    // 4️⃣ Mark invoice as paid if fully settled
    if ($invoice->isPaid()) {
        $invoice->update(['status' => 'paid']);
    }

    // 5️⃣ Send the email receipt immediately
    Mail::to($invoice->student->email)
        ->send(new PaymentReceiptMail($payment));

    // 6️⃣ Send the SMS immediately
    $student   = $invoice->student;
    $amountFmt = number_format($payment->amount_paid, 2);
    $invoiceNo = $invoice->id;
    $message   = "Hello {$student->first_name}, we’ve received your payment of KSh {$amountFmt} "
               . "for Invoice #{$invoiceNo}. Thank you for your prompt payment!";

    // Use Notification::sendNow() for immediate delivery
    Notification::sendNow($student, new SmsNotification($message, 'payment'));

    return back()->with('success', 'Payment recorded, receipt emailed, and SMS acknowledgment sent immediately!');
}

    public function edit(FeeInvoice $invoice, Payment $payment)
    {
        return view('payments.edit', compact('invoice', 'payment'));
    }

    public function update(Request $request, FeeInvoice $invoice, Payment $payment)
    {
        $request->validate([
            'amount_paid'    => "required|numeric|min:0.01|max:" . ($invoice->amount_due - ($invoice->amount_paid - $payment->amount_paid)),
            'payment_method' => 'required|in:Mpesa,Cheque,Cash,Card',
            'tran_code'      => 'nullable|string',
        ]);

        $payment->update([
            'amount_paid'    => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'tran_code'      => $request->tran_code,
            'notes'          => $request->input('notes'),
        ]);

        // Re-evaluate invoice status
        if ($invoice->isPaid()) {
            $invoice->update(['status' => 'paid']);
        } else {
            $invoice->update(['status' => 'open']);
        }

        return redirect()->route('invoices.show', $invoice)
                         ->with('success', 'Payment updated successfully.');
    }

    public function destroy(FeeInvoice $invoice, Payment $payment)
    {
        $payment->delete();

        // If invoice was paid but now has balance, reopen it
        if (!$invoice->isPaid() && $invoice->status === 'paid') {
            $invoice->update(['status' => 'open']);
        }

        return back()->with('success', 'Payment deleted successfully.');
    }

    

    public function download(Payment $payment)
    {
        $invoice = $payment->invoice;
        $student = $invoice->student;
        $branch = $invoice->branch;

        $pdf = Pdf::loadView('payments.pdfs.payment_receipt', compact('payment', 'invoice', 'student', 'branch'));

        return $pdf->download("receipt_{$payment->id}.pdf");
    }

    // REPORTS

    /**
     * Show the payments report form and results.
     */
    /**
     * Show payments report with optional branch & date filters.
     */
    public function paymentsReport(Request $request)
    {
        $request->validate([
            'branch_id'  => ['nullable','integer','exists:branches,id'],
            'start_date' => ['nullable','date'],
            'end_date'   => ['nullable','date','after_or_equal:start_date'],
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

        // 2️⃣ Only run payments query if dates given
        $payments  = collect();
        $totalPaid = 0;
        if ($request->filled(['start_date','end_date'])) {
            $paymentsQuery = Payment::with(['invoice.student','invoice.branch'])
                ->whereBetween('payment_date', [
                    "{$request->start_date} 00:00:00",
                    "{$request->end_date} 23:59:59",
                ]);

            // 3️⃣ Optional branch filter
            if ($request->filled('branch_id')) {
                $paymentsQuery->whereHas('invoice', function($q) use ($request) {
                    $q->where('branch_id', $request->branch_id);
                });
            }

            $payments  = $paymentsQuery->orderBy('payment_date','desc')->get();
            $totalPaid = $payments->sum('amount_paid');
        }

        return view('payments.reports.payments_report', [
            'branches'      => $branches,
            'payments'      => $payments,
            'totalPaid'     => $totalPaid,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'selectedBranch'=> $request->branch_id,
        ]);
    }

    /**
     * Download payments report PDF with same filters.
     */
    public function paymentsReportDownload(Request $request)
    {
        $request->validate([
            'branch_id'  => ['nullable','integer','exists:branches,id'],
            'start_date' => ['required','date'],
            'end_date'   => ['required','date','after_or_equal:start_date'],
        ]);

        $paymentsQuery = Payment::with(['invoice.student','invoice.branch'])
            ->whereBetween('payment_date', [
                "{$request->start_date} 00:00:00",
                "{$request->end_date} 23:59:59",
            ]);

        if ($request->filled('branch_id')) {
            $paymentsQuery->whereHas('invoice', function($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
            $branchName = Branch::find($request->branch_id)->name;
        } else {
            $branchName = 'All Branches';
        }

        $payments  = $paymentsQuery->orderBy('payment_date','desc')->get();
        $totalPaid = $payments->sum('amount_paid');

        $pdf = Pdf::loadView('payments.pdfs.payments_report', [
            'payments'   => $payments,
            'totalPaid'  => $totalPaid,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'branchName' => $branchName,
        ])->setPaper('a4','landscape');

        $filename = "payments_report_{$request->start_date}_{$request->end_date}.pdf";
        return $pdf->download($filename);
    }

    // Zonal Payments report

    public function paymentsZoneReport(Request $request)
{
    $request->validate([
        'zone_id'    => ['nullable', 'integer', 'exists:zones,id'],
        'start_date' => ['nullable', 'date'],
        'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
    ]);

    $user = Auth::user();
    $ownZone = $user->zone_id;

    // 👤 Handle zone access based on role
    if ($user->hasRole('Admin')) {
        $zones = Zone::orderBy('name')->get();
        $selectedZone = $request->zone_id;
    } elseif ($user->hasRole('Management')) {
        $zones = Zone::where('id', $ownZone)->get();
        $selectedZone = $ownZone; // restrict to own zone
    } else {
        abort(403, 'Unauthorized');
    }

    // 💵 Prepare payments query
    $payments = collect();
    $totalPaid = 0;

    if ($request->filled(['start_date', 'end_date'])) {
        $q = Payment::with(['invoice.student', 'invoice.branch.zone'])
            ->whereBetween('payment_date', [
                "{$request->start_date} 00:00:00",
                "{$request->end_date} 23:59:59",
            ]);

        // 🌍 Filter by zone if selected
        if ($selectedZone) {
            $q->whereHas('invoice.branch', function ($b) use ($selectedZone) {
                $b->where('zone_id', $selectedZone);
            });
        }

        $payments = $q->orderBy('payment_date', 'desc')->get();
        $totalPaid = $payments->sum('amount_paid');
    }

    return view('payments.reports.payments_zone_report', [
        'zones'        => $zones,
        'payments'     => $payments,
        'totalPaid'    => $totalPaid,
        'start_date'   => $request->start_date,
        'end_date'     => $request->end_date,
        'selectedZone' => $selectedZone,
        'isAdmin'      => $user->hasRole('Admin'),
        'isManager'    => $user->hasRole('Management'),
    ]);
}


    public function paymentsZoneReportDownload(Request $request)
    {
        $request->validate([
            'zone_id'    => ['nullable','integer','exists:zones,id'],
            'start_date' => ['required','date'],
            'end_date'   => ['required','date','after_or_equal:start_date'],
        ]);

        $user = Auth::user();
       //$role = $user->role->name;
        $ownZone = $user->zone_id;

        // Determine the effective zone filter
        if ($user->hasRole('Admin')) {
            $selectedZone = $request->zone_id;
        } elseif ($user->hasRole('Management')) {
            $selectedZone = $ownZone;
        } else {
            abort(403, 'Unauthorized');
        }

        // Pull dates from request
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        // Build payments query
        $q = Payment::with(['invoice.student','invoice.branch.zone'])
            ->whereBetween('payment_date', [
                "{$start_date} 00:00:00",
                "{$end_date} 23:59:59",
            ]);

        if ($selectedZone) {
            $q->whereHas('invoice.branch', fn($b) => $b->where('zone_id', $selectedZone));
            $zoneName = Zone::find($selectedZone)->name;
        } else {
            $zoneName = 'All Zones';
        }

        $payments  = $q->orderBy('payment_date','desc')->get();
        $totalPaid = $payments->sum('amount_paid');

        $pdf = Pdf::loadView('payments.pdfs.payments_zone_report', [
            'payments'   => $payments,
            'totalPaid'  => $totalPaid,
            'zoneName'   => $zoneName,
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ])->setPaper('a4','landscape');

        $filename = "payments_zone_{$start_date}_{$end_date}.pdf";
        return $pdf->download($filename);
    }

}
