@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <h2 class="text-light mb-4">Expenses Report</h2>

  {{-- Filters Form --}}
  <div class="card bg-dark text-light mb-4 shadow-sm">
    <div class="card-body">
      <form method="GET" action="{{ route('reports.expenses') }}" class="row g-2 align-items-end">

        {{-- Branch --}}
        <div class="col-md-3">
          <label class="form-label text-primary">Branch</label>
          <select name="branch_id"
                  class="form-control bg-secondary text-light @error('branch_id') is-invalid @enderror">
            <option value="">— All Branches —</option>
            @foreach($branches as $b)
              <option value="{{ $b->id }}"
                {{ ($selectedBranch == $b->id) ? 'selected' : '' }}>
                {{ $b->name }}
              </option>
            @endforeach
          </select>
          @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Start Date --}}
        <div class="col-md-3">
          <label class="form-label text-primary">From</label>
          <input type="date"
                 name="start_date"
                 value="{{ old('start_date', $start_date) }}"
                 class="form-control bg-secondary text-light @error('start_date') is-invalid @enderror"
                 required>
          @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-3">
          <label class="form-label text-primary">To</label>
          <input type="date"
                 name="end_date"
                 value="{{ old('end_date', $end_date) }}"
                 class="form-control bg-secondary text-light @error('end_date') is-invalid @enderror"
                 required>
          @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Buttons --}}
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-primary">Run Report</button>
          @if($expenses->isNotEmpty())
            <a href="{{ route('reports.expenses.download', [
                        'branch_id'  => $selectedBranch,
                        'start_date' => $start_date,
                        'end_date'   => $end_date
                      ]) }}"
               class="btn btn-outline-success">
              Download PDF
            </a>
          @endif
        </div>

      </form>
    </div>
  </div>

  {{-- Results Table --}}
  @if($expenses->isNotEmpty())
    <div class="card bg-dark text-light shadow-sm">
      <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Category</th>
              <th>Description</th>
              <th>Branch</th>
              <th class="text-end">Quantity</th>
              <th class="text-end">Amount (KSh)</th>
              <th>Receipt Ref</th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenses as $exp)
              <tr>
                <td>{{ $exp->expense_date->format('Y-m-d') }}</td>
                <td>{{ $exp->category }}</td>
                <td>{{ $exp->description }}</td>
                <td>{{ $exp->branch->name }}</td>
                <td class="text-end">{{ $exp->quantity }}</td>
                <td class="text-end">{{ number_format($exp->amount, 2) }}</td>
                <td>{{ $exp->recept_ref_number }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="table-secondary">
            <tr>
              <th colspan="5" class="text-end">Total Expenses:</th>
              <th class="text-end">KSh {{ number_format($totalAmount, 2) }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  @elseif(request()->filled(['start_date','end_date']))
    <div class="alert alert-warning">No expenses found in that period.</div>
  @endif

</div>
@endsection
