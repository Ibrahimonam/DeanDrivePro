@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
  <!-- Header -->
  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-6">
      <h3 class="text-light text-uppercase">Expenses</h3>
    </div>
    <div class="col-12 col-md-6 text-md-end text-start mt-3 mt-md-0">
      <a href="{{ route('expenses.create') }}" class="btn btn-outline-light">
        <i class="mdi mdi-plus-circle-outline"></i> Add New
      </a>
    </div>
  </div>

  <!-- Search & Count -->
  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-6">
      <h5 class="text-light">
        Total Expenses: <span class="text-light">{{ $expenses->total() }}</span>
      </h5>
    </div>
    <div class="col-12 col-md-6 mt-3 mt-md-0">
      <form action="{{ route('expenses.index') }}" method="GET" class="d-flex">
        <input
          type="text"
          name="search"
          class="form-control bg-dark text-light border-light w-100"
          placeholder="Search by description, category or branch"
          value="{{ request('search') }}"
        >
      </form>
    </div>
  </div>

  <!-- Flash -->
  @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
  @endif

  <!-- Table -->
  <div class="table-responsive shadow-lg">
    <table class="table table-striped align-middle">
      <thead class="text-uppercase" style="background-color: #007bff !important;">
        <tr>
          <th class="text-white">ID</th>
          <th class="text-white">CATEGORY</th>
          <th class="text-white">DESCRIPTION</th>
          <th class="text-white">BRANCH</th>
          <th class="text-white">QTY</th>
          <th class="text-white">EXPENSE DATE</th>
          <th class="text-white">AMOUNT</th>
          <th class="text-white">RECEIPT #</th>
          <th class="text-white">CREATED ON</th>
          <th class="text-white">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        @forelse($expenses as $expense)
          <tr>
            <td class="text-white">
              <a href="{{ route('expenses.show', $expense) }}" class="text-decoration-none text-light">
                {{ '0'.$expense->id }}
              </a>
            </td>
            <td class="text-white">{{ $expense->category }}</td>
            <td class="text-white">{{ \Illuminate\Support\Str::limit($expense->description, 30) }}</td>
            <td class="text-white">{{ $expense->branch->name }}</td>
            <td class="text-white">{{ $expense->quantity }}</td>
            <td class="text-white">{{ $expense->expense_date->format('jS F Y') }}</td>
            <td class="text-white">KES {{ number_format($expense->amount, 2) }}</td>
            <td class="text-white">{{ $expense->recept_ref_number ?? '—' }}</td>
            <td class="text-white">{{ $expense->created_at->format('jS F Y') }}</td>
            <td>
              <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-outline-primary btn-sm">
                  <i class="mdi mdi-border-color"></i> Edit
                </a>
                <!-- <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Delete this expense?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm">
                    <i class="mdi mdi-delete"></i> Delete
                  </button>
                </form> -->
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="text-center text-white">No expenses found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-center mt-4">
    {{ $expenses->withQueryString()->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection
