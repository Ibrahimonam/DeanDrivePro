@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
  <!-- Title -->
  <div class="text-center mb-4">
    <h3 class="blockquote text-light text-uppercase">{{ $expense->category }}</h3>
  </div>

  <!-- Go Back -->
  <div class="mb-3">
    <a class="btn btn-outline-primary" href="{{ route('expenses.index') }}">
      <i class="mdi mdi-arrow-left"></i> Go Back
    </a>
  </div>

 <!-- Details Card -->
<div class="card bg-dark text-light shadow-sm">
  <div class="card-body">
    <h5 class="card-title text-primary mb-4">Expense Details</h5>

    <!-- Row 1: Description, Branch, Quantity -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <strong>Description:</strong>
        <p class="text-primary mb-0">{{ $expense->description }}</p>
      </div>
      <div class="col-md-4">
        <strong>Branch:</strong>
        <p class="text-primary mb-0">{{ $expense->branch->name }}</p>
      </div>
      <div class="col-md-4">
        <strong>Quantity:</strong>
        <p class="text-primary mb-0">{{ $expense->quantity }}</p>
      </div>
    </div>

    <!-- Row 2: Date, Amount, Receipt # -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <strong>Date:</strong>
        <p class="text-primary mb-0">{{ $expense->expense_date->format('jS F Y') }}</p>
      </div>
      <div class="col-md-4">
        <strong>Amount:</strong>
        <p class="text-primary mb-0">KES {{ number_format($expense->amount, 2) }}</p>
      </div>
      <div class="col-md-4">
        <strong>Receipt #:</strong>
        <p class="text-primary mb-0">{{ $expense->recept_ref_number ?? '—' }}</p>
      </div>
    </div>

    <!-- Row 3: Created On (and two empty cols to balance) -->
    <div class="row g-3">
      <div class="col-md-4">
        <strong>Created On:</strong>
        <p class="text-primary mb-0">{{ $expense->created_at->format('jS F Y') }}</p>
      </div>
      <div class="col-md-4"><!-- empty --></div>
      <div class="col-md-4"><!-- empty --></div>
    </div>
  </div>
</div>


  <!-- Delete Form -->
   @role('Admin')
  <div class="card bg-dark text-light shadow-sm mt-4">
    <div class="card-body">
      <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
        @csrf @method('DELETE')
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-danger">
            <i class="mdi mdi-alert"></i> Deleting this expense is irreversible.
          </span>
          <button class="btn btn-outline-danger" onclick="return confirm('Delete this expense?')">
            <i class="mdi mdi-delete"></i> Delete Expense
          </button>
        </div>
      </form>
    </div>
  </div>
  @endrole()
</div>
@endsection
