@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <h2 class="text-light mb-4">Payments by Zone</h2>

  <div class="card bg-dark text-light mb-4 shadow-sm">
    <div class="card-body">
      <form method="GET" action="{{ route('reports.payments.zone') }}" class="row g-2 align-items-end">

  {{-- Zone selector --}}
  <div class="col-md-3">
    <label class="form-label text-primary">Zone</label>
    <select
      name="zone_id"
      class="form-control bg-secondary text-light @error('zone_id') is-invalid @enderror"
      @cannot('Admin') disabled @endcannot>

      @role('Admin')
        <option value="">— All Zones —</option>
      @endrole

      @foreach($zones as $z)
        <option value="{{ $z->id }}"
          {{ ($selectedZone == $z->id) ? 'selected' : '' }}>
          {{ $z->name }}
        </option>
      @endforeach
    </select>
    @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  {{-- From --}}
  <div class="col-md-3">
    <label class="form-label text-primary">From</label>
    <input type="date"
           name="start_date"
           value="{{ old('start_date', $start_date) }}"
           class="form-control bg-secondary text-light @error('start_date') is-invalid @enderror"
           required>
    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  {{-- To --}}
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

    @if($payments->isNotEmpty())
      <a href="{{ route('reports.payments.zone.download', [
                  'zone_id'   => auth()->user()->hasRole('Admin') ? $selectedZone : null,
                  'start_date'=> $start_date,
                  'end_date'  => $end_date
                ]) }}"
         class="btn btn-outline-success">
        Download PDF
      </a>
    @endif
  </div>

</form>

    </div>
  </div>

  @if($payments->isNotEmpty())
    <div class="card bg-dark text-light shadow-sm">
      <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0">
          <thead>
            <tr>
              <th>Date</th><th>Student</th><th>Branch</th><th>Zone</th>
              <th>Invoice #</th><th>Method</th><th class="text-end">Paid (KSh)</th><th>Tran Code</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $pay)
            <tr>
              <td>{{ $pay->payment_date->format('Y-m-d') }}</td>
              <td>{{ $pay->invoice->student->full_name }}</td>
              <td>{{ $pay->invoice->branch->name }}</td>
              <td>{{ $pay->invoice->branch->zone->name }}</td>
              <td>{{ $pay->fee_invoice_id }}</td>
              <td>{{ $pay->payment_method }}</td>
              <td class="text-end">{{ number_format($pay->amount_paid,2) }}</td>
              <td>{{ $pay->tran_code }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot class="table-secondary">
            <tr>
              <th colspan="6" class="text-end">Total Paid:</th>
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
