@extends('layouts.main_layout')

@section('content')
<div class="container-fluid mt-4">

  {{-- Receipt Modal Styles --}}
  <style>
    .receipt-modal .modal-content {
      background-color: #2c2f33;
      color: #eee;
      border-radius: 0.5rem;
      overflow: hidden;
    }
    .receipt-modal .modal-header {
      background-color: #23272a;
      border-bottom: 2px solid #7289da;
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .receipt-modal .modal-header img {
      height: 40px;
      margin-right: 10px;
    }
    .receipt-modal .modal-title {
      flex: 1;
      text-align: center;
      font-weight: bold;
      color: #7289da;
    }
    .receipt-modal .btn-close {
      filter: invert(1);
    }
    .receipt-modal .modal-body {
      padding: 1.5rem;
    }
    .receipt-modal .receipt-details {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }
    .receipt-modal .receipt-details td {
      padding: 0.5rem 0.75rem;
      vertical-align: top;
    }
    .receipt-modal .receipt-details .label {
      font-weight: 600;
      color: #99aab5;
      width: 30%;
    }
    .receipt-modal .receipt-details .value {
      color: #ffffff;
    }
    .receipt-modal .amount-box {
      background-color: #7289da;
      color: #2c2f33;
      padding: 0.75rem 1rem;
      border-radius: 0.25rem;
      font-size: 1.1rem;
      font-weight: bold;
      text-align: right;
      margin-bottom: 1rem;
    }
    .receipt-modal .modal-footer {
      background-color: #23272a;
      border-top: 2px solid #7289da;
      padding: 1rem 1.5rem;
    }
    .receipt-modal .modal-footer .btn {
      min-width: 100px;
    }
  </style>

  <!-- Dashboard Summary Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card bg-secondary text-light shadow-sm p-3">
        <h6>Total Due</h6>
        <h4>KSh {{ number_format($invoice->amount_due,2) }}</h4>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-secondary text-light shadow-sm p-3">
        <h6>Total Paid</h6>
        <h4>KSh {{ number_format($invoice->amount_paid,2) }}</h4>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-secondary text-light shadow-sm p-3">
        <h6>Balance</h6>
        <h4>KSh {{ number_format($invoice->balance,2) }}</h4>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-secondary text-light shadow-sm p-3">
        <h6>Status</h6>
        <h4>{{ ucfirst($invoice->status) }}</h4>
      </div>
    </div>
  </div>

  <!-- Invoice Details Table & Actions -->
  <div class="card bg-dark text-light shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Invoice #{{ $invoice->id }}</h3>
      <div>
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-warning me-2">Edit</a>
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete invoice?')">Delete</button>
        </form>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-dark table-striped mb-0">
        <tbody>
          <tr><th>Student</th><td class="text-primary">{{ $invoice->student->full_name }}</td></tr>
          <tr><th>Branch</th><td class="text-primary">{{ $invoice->branch->name }}</td></tr>
          <tr><th>Original Amount</th><td class="text-primary">KSh {{ number_format($invoice->amount_original,2) }}</td></tr>
          <tr><th>Discount</th><td class="text-primary">KSh {{ number_format($invoice->discount_amount,2) }}</td></tr>
          <tr><th>Amount Due</th><td class="text-primary">KSh {{ number_format($invoice->amount_due,2) }}</td></tr>
          <tr><th>Due Date</th><td class="text-primary">{{ $invoice->due_date->format('jS F Y') }}</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Payments Section -->
  <div class="card bg-dark text-light shadow mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Payments</h5>
      @if($invoice->balance > 0)
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
          + Add Payment
        </button>
      @endif
    </div>

    <div class="card-body p-0">
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
            <td>{{ $pay->payment_date->format('jS F Y') }}</td>
            <td>{{ $pay->payment_method }}</td>
            <td class="text-end">KSh {{ number_format($pay->amount_paid, 2) }}</td>
            <td>{{ $pay->tran_code }}</td>
            <td>
              <button class="btn btn-sm btn-outline-secondary me-1"
                      data-bs-toggle="modal"
                      data-bs-target="#receiptModal{{ $pay->id }}">
                View
              </button>
              <a href="{{ route('payments.download', $pay) }}" class="btn btn-sm btn-outline-success me-1">
                Download
              </a>
             <!--  <a href="{{ route('invoices.payments.edit', [$invoice, $pay]) }}" class="btn btn-sm btn-outline-info me-1">
                Edit
              </a> -->
              <form action="{{ route('invoices.payments.destroy', [$invoice, $pay]) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete payment?')">
                  Del
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">No payments recorded yet.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Receipt Modals (moved outside table) -->
  @foreach($invoice->payments as $pay)
  <div class="modal fade receipt-modal" id="receiptModal{{ $pay->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <img src="{{ asset('assets/images/school_logo.png') }}" alt="Logo">
          <h5 class="modal-title">Receipt #{{ $pay->id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <table class="receipt-details mb-3">
            <tr>
              <td class="label">Student:</td>
              <td class="value">{{ $invoice->student->full_name }}</td>
              <td class="label">Date:</td>
              <td class="value">{{ $pay->payment_date->format('jS F Y') }}</td>
            </tr>
            <tr>
              <td class="label">Branch:</td>
              <td class="value">{{ $invoice->branch->name }}</td>
              <td class="label">Method:</td>
              <td class="value">{{ $pay->payment_method }}</td>
            </tr>
            @if($pay->tran_code)
            <tr>
              <td class="label">Transaction Code:</td>
              <td class="value">{{ $pay->tran_code }}</td>
              <td class="label">Invoice #:</td>
              <td class="value">{{ $invoice->id }}</td>
            </tr>
            @else
            <tr>
              <td class="label">Invoice #:</td>
              <td class="value">{{ $invoice->id }}</td>
              <td></td><td></td>
            </tr>
            @endif
          </table>
          <div class="amount-box">
            Total Paid: KSh {{ number_format($pay->amount_paid, 2) }}
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <a href="{{ route('payments.download', $pay) }}" class="btn btn-outline-success">
            <i class="mdi mdi-download"></i> Download PDF
          </a>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
        </div>

      </div>
    </div>
  </div>
  @endforeach

  <!-- Add Payment Modal -->
  <div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('invoices.payments.store', $invoice) }}" method="POST" class="modal-content bg-dark text-light">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Payment</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" name="amount_paid" class="form-control bg-secondary text-light"
                   step="0.01" max="{{ $invoice->balance }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Method</label>
            <select name="payment_method" class="form-control bg-secondary text-light">
              <option>Mpesa</option>
              <option>Cheque</option>
              <option>Cash</option>
              <option>Card</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tran Code</label>
            <input name="tran_code" class="form-control bg-secondary text-light">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-outline-primary">Save Payment</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
