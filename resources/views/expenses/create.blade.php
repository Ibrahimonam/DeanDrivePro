@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Create Expense</h3>
        </div>
        <div class="card-body">

        <!-- Back Button -->
          <div class="mb-3">
            <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-outline-light">
              <i class="mdi mdi-arrow-left-circle-outline"></i> Back to Expenses
            </a>
          </div>
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('expenses.store') }}" method="POST">
            @csrf

            <div class="form-group row mb-3">
              <label for="category" class="col-sm-3 col-form-label">Category</label>
              <div class="col-sm-9">
                <select name="category" id="category" class="form-control bg-secondary text-light">
                  <option value="">-- Select --</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category')==$cat?'selected':'' }}>
                      {{ $cat }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="description" class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                <input name="description" id="description" class="form-control bg-secondary text-light"
                       value="{{ old('description') }}" placeholder="Expense description">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="branch_id" class="col-sm-3 col-form-label">Branch</label>
              <div class="col-sm-9">
                <select name="branch_id" id="branch_id" class="form-control bg-secondary text-light">
                  <option value="">-- Select Branch --</option>
                  @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ old('branch_id')==$b->id?'selected':'' }}>
                      {{ $b->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="quantity" class="col-sm-3 col-form-label">Quantity</label>
              <div class="col-sm-9">
                <input name="quantity" id="quantity" class="form-control bg-secondary text-light"
                       value="{{ old('quantity') }}" placeholder="e.g. 5 units">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="expense_date" class="col-sm-3 col-form-label">Date</label>
              <div class="col-sm-9">
                <input type="date" name="expense_date" id="expense_date"
                       class="form-control bg-secondary text-light"
                       value="{{ old('expense_date') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="amount" class="col-sm-3 col-form-label">Amount</label>
              <div class="col-sm-9">
                <input type="number" step="0.01" name="amount" id="amount"
                       class="form-control bg-secondary text-light"
                       value="{{ old('amount') }}" placeholder="KES">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="recept_ref_number" class="col-sm-3 col-form-label">Receipt #</label>
              <div class="col-sm-9">
                <input name="recept_ref_number" id="recept_ref_number"
                       class="form-control bg-secondary text-light"
                       value="{{ old('recept_ref_number') }}" placeholder="Optional">
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button type="submit" class="btn btn-outline-primary">
                  <i class="mdi mdi-check-circle-outline"></i> Create Expense
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
