@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-light">Fee Invoices</h2>
    <a href="{{ route('invoices.create') }}" class="btn btn-outline-primary">New Invoice</a>
  </div>
  {{-- Back button if present --}}
  @if(!empty($backUrl))
    <a href="{{ $backUrl }}" class="btn btn-outline-primary mb-3">
      {{ $backText }}
    </a>
  @endif

  {{-- Custom page title --}}
  <h2 class="text-light mb-3">{{ $pageTitle ?? 'All Invoices' }}</h2>
  <div class="card bg-dark text-light shadow-sm">
    <div class="card-body p-0">
      <table class="table table-dark table-hover mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Branch</th>
            <th>Due Date</th>
            <th>Status</th>
            <th class="text-end">Balance</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invoices as $inv)
          <tr>
            <td>{{ $inv->id }}</td>
            <td>{{ $inv->student->full_name }}</td>
            <td>{{ $inv->branch->name }}</td>
            <td>{{ $inv->due_date->format('Y-m-d') }}</td>
            <td>{{ ucfirst($inv->status) }}</td>
            <td class="text-end">KSh {{ number_format($inv->balance,2) }}</td>
            <td>
              <a href="{{ route('invoices.show', $inv) }}" class="btn btn-sm btn-outline-info">View</a>
              <!-- <a href="{{ route('invoices.edit', $inv) }}" class="btn btn-sm btn-outline-warning">Edit</a> -->
              <form action="{{ route('invoices.destroy', $inv) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete invoice?')">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-secondary">
      {{ $invoices->links() }}
    </div>
  </div>
</div>
@endsection