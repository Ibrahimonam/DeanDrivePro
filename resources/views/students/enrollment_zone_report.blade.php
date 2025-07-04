@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <h2 class="text-light mb-4">Enrollment by Zone</h2>

  {{-- Filter Form --}}
  <div class="card bg-dark text-light mb-4 shadow-sm">
    <div class="card-body">
      <form method="GET" action="{{ route('reports.enrollment.zone') }}" class="row g-2 align-items-end">
        
        {{-- Zone --}}
        <div class="col-md-3">
          <label class="form-label text-primary">Zone</label>
          <select name="zone_id"
                  class="form-control bg-secondary text-light @error('zone_id') is-invalid @enderror"
                 @cannot('Admin') disabled @endcannot>
            @role('Admin')
              <option value="">— All Zones —</option>
            @endrole
            @foreach($zones as $z)
              <option value="{{ $z->id }}"
                {{ ($selectedZone==$z->id)?'selected':'' }}>
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
                 value="{{ old('start_date',$start_date) }}"
                 class="form-control bg-secondary text-light @error('start_date') is-invalid @enderror"
                 required>
          @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- To --}}
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

  @if($students->isNotEmpty())
    <a href="{{ route('reports.enrollment.zone.download', [
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

  {{-- Results Table --}}
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
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @elseif(request()->filled(['start_date','end_date']))
    <div class="alert alert-warning">No enrollments found for that period.</div>
  @endif
</div>
@endsection
