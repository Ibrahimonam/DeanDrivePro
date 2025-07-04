@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">

<!-- Success Message -->
@if (session()->has('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
  <!-- Title -->
  <div class="text-center mb-4">
    <h3 class="blockquote text-light text-uppercase">{{ $student->full_name }}</h3>
  </div>

  <!-- Back -->
  <div class="mb-3">
    <a class="btn btn-outline-primary" href="{{ route('students.index') }}">
      <i class="mdi mdi-arrow-left"></i> Go Back
    </a>
  </div>

  <!-- Details Card -->
  <div class="card bg-dark text-light shadow-sm">
    <div class="card-body">
      <h5 class="card-title text-white mb-4">Student Details</h5>

      <div class="row">
        <div class="col-md-6 mb-3">
          <strong>Name:</strong> <span class="text-primary">{{ $student->full_name }}</span>
        </div>
        <div class="col-md-6 mb-3">
          <strong>ID Number:</strong> <span class="text-primary">{{ $student->id_number }}</span>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <strong>Email:</strong> <span class="text-primary">{{ $student->email }}</span>
        </div>
        <div class="col-md-6 mb-3">
          <strong>Phone:</strong> <span class="text-primary">{{ $student->phone_number }}</span>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <strong>Branch:</strong> <span class="text-primary">{{ $student->branch->name }}</span>
        </div>
        <div class="col-md-6 mb-3">
          <strong>Class:</strong> <span class="text-primary">{{ $student->class->name }}</span>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 mb-3">
          <strong>PDL Status:</strong> <span class="text-primary">{{ $student->pdl_status }}</span>
        </div>
        <div class="col-md-3 mb-3">
          <strong>Exam Status:</strong> <span class="text-primary">{{ $student->exam_status }}</span>
        </div>
        <div class="col-md-3 mb-3">
          <strong>T-Shirt:</strong> <span class="text-primary">{{ $student->tshirt_status }}</span>
        </div>
        <div class="col-md-3 mb-3">
          <strong>Status:</strong> <span class="text-primary">{{ $student->student_status }}</span>
        </div>
      </div>
    </div>
  </div>
  {{--  only show if no invoice/payment exists yet  --}}
  @if($student->invoices->isEmpty())
  <div class="card bg-dark text-light shadow-sm mt-4">
    <div class="card-body text-center">
      <a href="{{ route('invoices.create', ['student_id' => $student->id]) }}"
         class="btn btn-outline-success btn-lg">
        <i class="mdi mdi-cash-multiple"></i> Make Payment
      </a>
    </div>
  </div>
  @endif
<!--  Practical Issueing Form-->

<div class="card bg-dark text-light mt-4">
  <div class="card-body">
    <h5 class="text-white mb-3">Practical Lessons</h5>

    <!-- Already issued practicals -->
  

    @if($student->practicals->isEmpty())
        <p class="text-muted">No practicals issued yet.</p>
    @else

  

        <table class="table table-bordered table-dark">
            <thead class="text-uppercase">
                <tr>
                    <th class="text-info">Lesson</th>
                    <th class="text-info">Description</th>
                    <th class="text-info">Duration</th>
                    <th class="text-info">Issued At</th>
                </tr>
            </thead>
            <tbody>
            @foreach($student->practicals as $practical)
              <tr>
                <td class="text-white">{{ $practical->name }}</td>
                <td class="text-white">{{ $practical->description }}</td>
                <td class="text-white">{{ $practical->duration }} mins</td>
                <td class="text-white">
                  {{ $practical->pivot->issued_at
                      ? \Carbon\Carbon::parse($practical->pivot->issued_at)
                          ->format('d M Y H:i')
                      : '-' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    @endif

    <!-- Issue new practical -->
    

    @role('User')
        <!-- Only Users can issue new practicals -->
        <form action="{{ route('students.issue-practical', $student) }}" method="POST" class="mt-3">
            @csrf
            <div class="form-group">
                <label for="practical_id" class="text-info">Issue New Practical</label>
                <select name="practical_id" id="practical_id" class="form-control text-info">
                    @foreach(\App\Models\Practical::all() as $practical)
                        @unless($student->practicals->contains($practical->id))
                            <option value="{{ $practical->id }}">
                                {{ $practical->name }} ({{ $practical->duration }} mins)
                            </option>
                        @endunless
                    @endforeach
                </select>
            </div>
            <button class="btn btn-outline-success mt-2">Issue Practical</button>
        </form>
    @else
        <div class="alert alert-danger mt-3">
            <i class="mdi mdi-alert-circle-outline"></i>
            You are not authorized to issue lessons.
        </div>
    @endrole

      </div>
    </div>

                  <!-- Fee Payments Section -->
                  {{-- Fee Invoices & Payments --}}
  @if($student->invoices->isNotEmpty())
    <div class="card bg-dark text-light shadow-sm mt-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="mdi mdi-file-document-box"></i> Fee Invoices & Payments</h5>
      </div>
      <div class="card-body">
        @foreach($student->invoices as $invoice)
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Invoice #{{ $invoice->id }} <small>({{ ucfirst($invoice->status) }})</small></span>
              <span class="text-light">
                Due: KSh {{ number_format($invoice->amount_due,2) }} |
                Paid: KSh {{ number_format($invoice->amount_paid,2) }} |
                Balance: KSh {{ number_format($invoice->balance,2) }}
              </span>
            </div>
            <div class="card-body p-3">
              {{-- Invoice Details --}}
              <table class="table table-dark table-borderless mb-3">
                <tr>
                  <th class="w-25 text-info">Original</th>
                  <td class="text-white">KSh {{ number_format($invoice->amount_original,2) }}</td>
                  <th class="w-25 text-info">Discount</th>
                  <td class="text-white">KSh {{ number_format($invoice->discount_amount,2) }}</td>
                </tr>
                <tr>
                  <th class="text-info">Amount Due</th>
                  <td class="text-white">KSh {{ number_format($invoice->amount_due,2) }}</td>
                  <th class="text-info">Due Date</th>
                  <td class="text-white">{{ $invoice->due_date->format('d M Y ') }}</td>
                </tr>
              </table>

              {{-- Payments Table --}}
              <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                  <thead>
                    <tr>
                      <th class="text-info">Date</th>
                      <th class="text-info">Method</th>
                      <th class=" text-info text-end">Amount</th>
                      <th class="text-info">Tran Code</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($invoice->payments as $pay)
                    <tr>
                      <td class="text-white">{{ $pay->payment_date->format('d M Y ') }}</td>
                      <td class="text-white">{{ $pay->payment_method }}</td>
                      <td class="text-end text-white">KSh {{ number_format($pay->amount_paid,2) }}</td>
                      <td class="text-white">{{ $pay->tran_code }}</td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="4" class="text-center">No payments recorded.</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif


  <!-- Delete Form -->
  @role('Admin')
  <div class="card bg-dark text-light shadow-sm mt-4">
    <div class="card-body">
      <form action="{{ route('students.destroy', $student) }}" method="POST">
        @csrf @method('DELETE')
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-danger">
            <i class="mdi mdi-alert"></i> Deleting this student is irreversible.
          </span>
          <button class="btn btn-outline-danger" onclick="return confirm('Delete this student?')">
            <i class="mdi mdi-delete"></i> Delete Student
          </button>
        </div>
      </form>
    </div>
  </div>
  @endrole()
</div>
@endsection
