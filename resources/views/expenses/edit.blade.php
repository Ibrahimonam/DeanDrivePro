@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Edit Expense</h3>
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

          <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Category</label>
              <div class="col-sm-9">
                <select name="category" class="form-control bg-secondary text-light">
                  @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $expense->category)==$cat?'selected':'' }}>
                      {{ $cat }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                <input name="description" class="form-control bg-secondary text-light"
                       value="{{ old('description', $expense->description) }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Branch</label>
              <div class="col-sm-9">
                <select name="branch_id" class="form-control bg-secondary text-light">
                  @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ old('branch_id', $expense->branch_id)==$b->id?'selected':'' }}>
                      {{ $b->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Quantity</label>
              <div class="col-sm-9">
                <input name="quantity" class="form-control bg-secondary text-light"
                       value="{{ old('quantity', $expense->quantity) }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Date</label>
              <div class="col-sm-9">
                <input type="date" name="expense_date" class="form-control bg-secondary text-light"
                       value="{{ old('expense_date', $expense->expense_date->toDateString()) }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Amount</label>
              <div class="col-sm-9">
                <input type="number" step="0.01" name="amount" class="form-control bg-secondary text-light"
                       value="{{ old('amount', $expense->amount) }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Receipt #</label>
              <div class="col-sm-9">
                <input name="recept_ref_number" class="form-control bg-secondary text-light"
                       value="{{ old('recept_ref_number', $expense->recept_ref_number) }}">
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button class="btn btn-outline-success">
                  <i class="mdi mdi-content-save"></i> Update Expense
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
