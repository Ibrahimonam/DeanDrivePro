@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <h2 class="text-light mb-4">Payments Dashboard</h2>

  @if($branches->isEmpty())
    <div class="alert alert-warning">No branches to display.</div>
  @else
    <div class="row">
    @foreach($branches as $branch)
    <div class="col-lg-2 col-md-3 col-sm-4 mb-4">
        <div class="card bg-secondary text-light shadow-sm h-100">
        <div class="card-body p-2 d-flex flex-column">
            <h6 class="card-title mb-1">{{ $branch->name }}</h6>
            <p class="card-text small mb-1">Zone: {{ $branch->zone->name ?? '—' }}</p>
            <p class="card-text small mb-1">
            Payments: <strong>{{ $branch->payments_count }}</strong>
            </p>
            <p class="card-text small mb-2">
            Total Paid: <strong>KSh {{ number_format($branch->payments_sum_amount_paid,2) }}</strong>
            </p>

            <!-- NEW: link to invoices for this branch -->
            <a href="{{ route('branches.invoices.index', $branch) }}"
            class="btn btn-outline-light btn-sm mt-auto">
            View Invoices
            </a>
        </div>
        </div>
    </div>
    @endforeach

        </div>

    <div class="d-flex justify-content-center">
      {{ $branches->links() }}
    </div>
  @endif
</div>
@endsection
