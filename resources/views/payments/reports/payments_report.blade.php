@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <h2 class="text-light mb-4">Payments Report</h2>

  {{-- Filters Form --}}
  <div class="card bg-dark text-light mb-4 shadow-sm">
    <div class="card-body">
      <form method="GET" action="{{ route('reports.payments') }}" class="row g-2 align-items-end">

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
                 value="{{ old('start_date',$start_date) }}"
                 class="form-control bg-secondary text-light @error('start_date') is-invalid @enderror"
                 required>
          @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-3">
          <label class="form-label text-primary">To</label>
          <input type="date"
                 name="end_date"
                 value="{{ old('end_date',$end_date) }}"
                 class="form-control bg-secondary text-light @error('end_date') is-invalid @enderror"
                 required>
          @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Buttons --}}
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-primary">Run Report</button>
          @if($payments->isNotEmpty())
            <a href="{{ route('reports.payments.download', [
                        'branch_id'=>$selectedBranch,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date
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
  @if($payments->isNotEmpty())
    <div class="card bg-dark text-light shadow-sm">
      <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Student</th>
              <th>Branch</th>
              <th>Invoice #</th>
              <th>Method</th>
              <th class="text-end">Paid (KSh)</th>
              <th>Tran Code</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $pay)
            <tr>
              <td>{{ $pay->payment_date->format('Y-m-d') }}</td>
              <td>{{ $pay->invoice->student->full_name }}</td>
              <td>{{ $pay->invoice->branch->name }}</td>
              <td>{{ $pay->fee_invoice_id }}</td>
              <td>{{ $pay->payment_method }}</td>
              <td class="text-end">{{ number_format($pay->amount_paid,2) }}</td>
              <td>{{ $pay->tran_code }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot class="table-secondary">
            <tr>
              <th colspan="5" class="text-end">Total Paid:</th>
              <th class="text-end">KSh {{ number_format($totalPaid,2) }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  @elseif(request()->filled(['start_date','end_date']))
    <div class="alert alert-warning">No payments found in that period.</div>
  @endif
</div>
@endsection
