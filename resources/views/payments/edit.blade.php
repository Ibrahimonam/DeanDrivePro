@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center"><h4>Edit Payment</h4></div>
        <div class="card-body">
          <form action="{{ route('invoices.payments.update', [$invoice, $payment]) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
              <label>Amount</label>
              <input type="number" name="amount_paid" class="form-control bg-secondary text-light" step="0.01" value="{{ old('amount_paid',$payment->amount_paid) }}">
            </div>
            <div class="mb-3">
              <label>Method</label>
              <select name="payment_method" class="form-control bg-secondary text-light">
                @foreach(['Mpesa','Cheque','Cash','Card'] as $m)
                  <option value="{{ $m }}" {{ $payment->payment_method==$m?'selected':'' }}>{{ $m }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label>Tran Code</label>
              <input name="tran_code" class="form-control bg-secondary text-light" value="{{ old('tran_code',$payment->tran_code) }}">
            </div>
            <div class="d-flex justify-content-end">
              <button class="btn btn-outline-primary">Update Payment</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
