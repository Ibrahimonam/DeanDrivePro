@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">

  {{-- Title --}}
  <div class="text-center mb-4">
    <h3 class="blockquote text-light text-uppercase">{{ $student->full_name }} <small>(Expired)</small></h3>
  </div>

  {{-- Back --}}
  <div class="mb-3">
    <a class="btn btn-outline-primary" href="{{ route('students.expired.index') }}">
      <i class="mdi mdi-arrow-left"></i> Back to Expired List
    </a>
  </div>

  {{-- Student Details --}}
  <div class="card bg-dark text-light shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title text-primary mb-3">Student Details</h5>
      <div class="row">
        <div class="col-md-4 mb-2"><strong>ID Number:</strong> <span class="text-primary">{{ $student->id_number }}</span></div>
        <div class="col-md-4 mb-2"><strong>Email:</strong> <span class="text-primary">{{ $student->email }}</span></div>
        <div class="col-md-4 mb-2"><strong>Phone:</strong> <span class="text-primary">{{ $student->phone_number }}</span></div>
        <div class="col-md-4 mb-2"><strong>Branch:</strong> <span class="text-primary">{{ $student->branch->name }}</span></div>
        <div class="col-md-4 mb-2"><strong>Zone:</strong> <span class="text-primary">{{ $student->branch->zone->name ?? '—' }}</span></div>
        <div class="col-md-4 mb-2"><strong>Class:</strong> <span class="text-primary">{{ $student->class->name }}</span></div>
        <div class="col-md-4 mb-2"><strong>PDL Status:</strong> <span class="text-primary">{{ $student->pdl_status }}</span></div>
        <div class="col-md-4 mb-2"><strong>Exam Status:</strong> <span class="text-primary">{{ $student->exam_status }}</span></div>
        <div class="col-md-4 mb-2"><strong>T-Shirt:</strong> <span class="text-primary">{{ $student->tshirt_status }}</span></div>
        <div class="col-md-4 mb-2"><strong>Status:</strong> <span class="text-primary">{{ ucfirst($student->student_status) }}</span></div>
      </div>
    </div>
  </div>

  {{-- Invoices & Payments --}}
  @forelse($student->invoices as $invoice)
    <div class="card bg-dark text-light shadow-sm mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Invoice #{{ $invoice->id }}
          <small class="text-muted">({{ $invoice->status }})</small>
        </h5>
        <div>
          <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-info me-1">
            Details
          </a>
          @if(auth()->user()->role->name === 'Admin')
            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this invoice?')">
                Delete
              </button>
            </form>
          @endif
        </div>
      </div>
      <div class="card-body">
        {{-- Invoice summary --}}
        <table class="table table-dark table-striped mb-3">
          <tr><th>Original Amount</th><td>KSh {{ number_format($invoice->amount_original,2) }}</td></tr>
          <tr><th>Discount</th><td>KSh {{ number_format($invoice->discount_amount,2) }}</td></tr>
          <tr><th>Amount Due</th><td>KSh {{ number_format($invoice->amount_due,2) }}</td></tr>
          <tr><th>Paid</th><td>KSh {{ number_format($invoice->amount_paid,2) }}</td></tr>
          <tr><th>Balance</th><td>KSh {{ number_format($invoice->balance,2) }}</td></tr>
          <tr><th>Due Date</th><td>{{ $invoice->due_date->format('Y-m-d') }}</td></tr>
        </table>

        {{-- Payments table --}}
        <h6 class="text-primary">Payments</h6>
        <div class="table-responsive">
          <table class="table table-dark table-hover mb-0">
            <thead>
              <tr>
                <th>Date</th>
                <th>Method</th>
                <th class="text-end">Amount</th>
                <th>Tran Code</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($invoice->payments as $pay)
              <tr>
                <td>{{ $pay->payment_date->format('Y-m-d') }}</td>
                <td>{{ $pay->payment_method }}</td>
                <td class="text-end">KSh {{ number_format($pay->amount_paid,2) }}</td>
                <td>{{ $pay->tran_code }}</td>
                <td>
                  <a href="#" class="btn btn-sm btn-outline-secondary me-1"
                     data-bs-toggle="modal"
                     data-bs-target="#receiptModal{{ $pay->id }}">
                    View
                  </a>
                  <a href="{{ route('payments.download', $pay) }}"
                     class="btn btn-sm btn-outline-success me-1">
                    Download
                  </a>
                 <!--  <a href="{{ route('invoices.payments.edit', [$invoice, $pay]) }}"
                     class="btn btn-sm btn-outline-info me-1">
                    Edit
                  </a> -->
                  @if(auth()->user()->role->name === 'Admin')
                  <form action="{{ route('invoices.payments.destroy', [$invoice, $pay]) }}"
                        method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete payment?')">Del</button>
                  </form>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">No payments recorded.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-light text-center">
      No invoices found for this Expired Student.
    </div>
  @endforelse

  {{-- Delete Student (Admins only) --}}
  @if(auth()->user()->role->name === 'Admin')
  <div class="text-center mt-4">
    <form action="{{ route('students.destroy', $student) }}" method="POST">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger" onclick="return confirm('Delete this student?')">
        <i class="mdi mdi-delete"></i> Delete Student
      </button>
    </form>
  </div>
  @endif

</div>

{{-- Receipt Modals (outside loops) --}}
@foreach($student->invoices as $invoice)
  @foreach($invoice->payments as $pay)
    @include('students.partials.receipt_modal', ['payment' => $pay, 'invoice' => $invoice])
  @endforeach
@endforeach
@endsection
