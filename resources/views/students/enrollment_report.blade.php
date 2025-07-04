@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <h2 class="text-light mb-4">Enrollment Report</h2>

  {{-- Filter Form --}}
  <div class="card bg-dark text-light shadow-sm mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('students.reports.enrollment') }}" class="row g-2 align-items-end">
        @csrf

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
          @error('branch_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Start Date --}}
        <div class="col-md-3">
          <label class="form-label text-primary">From</label>
          <input type="date"
                 name="start_date"
                 value="{{ old('start_date', $start_date) }}"
                 class="form-control bg-secondary text-light @error('start_date') is-invalid @enderror"
                 required>
          @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-3">
          <label class="form-label text-primary">To</label>
          <input type="date"
                 name="end_date"
                 value="{{ old('end_date', $end_date) }}"
                 class="form-control bg-secondary text-light @error('end_date') is-invalid @enderror"
                 required>
          @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Buttons --}}
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-primary w-50">Run</button>
          @if($students->isNotEmpty())
            <a href="{{ route('students.reports.enrollment.download',
                        ['branch_id'=>$selectedBranch,
                         'start_date'=>$start_date,
                         'end_date'=>$end_date]) }}"
               class="btn btn-outline-success w-50">
              Download
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

  {{-- Report Table --}}
  @if($students->isNotEmpty())
    <div class="card bg-dark text-light shadow-sm">
      <div class="card-body p-0">
        <table class="table table-dark table-striped mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Enrolled On</th>
              <th>Full Name</th>
              <th>ID Number</th>
              <th>Branch</th>
              <th>Class</th>
              <th>Email</th>
              <th>Phone</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $i => $stu)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $stu->created_at->format('Y-m-d') }}</td>
              <td>{{ $stu->full_name }}</td>
              <td>{{ $stu->id_number }}</td>
              <td>{{ $stu->branch->name }}</td>
              <td>{{ $stu->class->name }}</td>
              <td>{{ $stu->email }}</td>
              <td>{{ $stu->phone_number }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @elseif(request()->filled(['start_date','end_date']))
    <div class="alert alert-warning">No students found for that range.</div>
  @endif
</div>
@endsection
