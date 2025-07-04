@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="mb-0">New Fee Invoice</h3>
        </div>
        <div>
        @if(session('error'))
          <div class="alert alert-warning alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        </div>
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            {{-- STUDENT --}}
            @if(isset($student))
              <input type="hidden" name="student_id" value="{{ $student->id }}">
              <div class="form-group mb-3 row">
                <label class="col-sm-3 col-form-label">Student</label>
                <div class="col-sm-9">
                  <input
                    type="text"
                    class="form-control bg-secondary text-light"
                    value="{{ $student->full_name }}"
                    disabled
                  >
                </div>
              </div>
            @else
              <div class="form-group mb-3 row">
                <label class="col-sm-3 col-form-label">Student</label>
                <div class="col-sm-9">
                  <select name="student_id" class="form-control bg-secondary text-light">
                    <option value="">-- Select Student --</option>
                    @foreach($students as $s)
                      <option value="{{ $s->id }}"
                        {{ old('student_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->full_name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            @endif

            {{-- BRANCH --}}
            @if(isset($student))
              <input type="hidden" name="branch_id" value="{{ $student->branch->id }}">
              <div class="form-group mb-3 row">
                <label class="col-sm-3 col-form-label">Branch</label>
                <div class="col-sm-9">
                  <input
                    type="text"
                    class="form-control bg-secondary text-light"
                    value="{{ $student->branch->name }}"
                    disabled
                  >
                </div>
              </div>
            @else
              <div class="form-group mb-3 row">
                <label class="col-sm-3 col-form-label">Branch</label>
                <div class="col-sm-9">
                  <select name="branch_id" class="form-control bg-secondary text-light">
                    <option value="">-- Select Branch --</option>
                    @foreach($branches as $b)
                      <option value="{{ $b->id }}"
                        {{ old('branch_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            @endif

            {{-- ORIGINAL AMOUNT --}}
            <div class="form-group mb-3 row">
              <label class="col-sm-3 col-form-label">Original Amount</label>
              <div class="col-sm-9">
                <input
                  type="number"
                  name="amount_original"
                  class="form-control bg-secondary text-light"
                  step="0.01"
                  value="{{ old('amount_original', isset($student) ? $student->class->fee : '') }}"
                >
              </div>
            </div>

            {{-- DISCOUNT --}}
            <div class="form-group mb-3 row">
              <label class="col-sm-3 col-form-label">Discount</label>
              <div class="col-sm-9">
                <input
                  type="number"
                  name="discount_amount"
                  class="form-control bg-secondary text-light"
                  step="0.01"
                  value="{{ old('discount_amount') }}"
                >
              </div>
            </div>

            {{-- DUE DATE --}}
            <div class="form-group mb-3 row">
              <label class="col-sm-3 col-form-label">Due Date</label>
              <div class="col-sm-9">
                <input
                  type="date"
                  name="due_date"
                  class="form-control bg-secondary text-light"
                  value="{{ old('due_date') }}"
                >
              </div>
            </div>

            {{-- SUBMIT --}}
            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button class="btn btn-outline-primary">
                  Create Invoice
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
