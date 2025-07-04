@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
  <!-- Header -->
  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-6">
      <h3 class="text-light text-uppercase">Alumni</h3>
    </div>
    <div class="col-12 col-md-6 text-md-end text-start mt-3 mt-md-0">
     <!--  <a href="{{ route('students.create') }}" class="btn btn-outline-light">
        <i class="mdi mdi-plus-circle-outline"></i> Add New
      </a> -->
    </div>
  </div>

  <!-- Search & Count -->
  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-6">
      <h5 class="text-light">
        Total Alumni: <span class="text-light">{{ $students->total() }}</span>
      </h5>
    </div>
    <div class="col-12 col-md-6 mt-3 mt-md-0">
      <form action="{{ route('students.index') }}" method="GET" class="d-flex">
        <input
          type="text"
          name="search"
          class="form-control bg-dark text-light border-light w-100"
          placeholder="Search by name or ID #"
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
      <thead class="text-uppercase" style="background-color: #007bff;">
        <tr>
          <th class="text-white">ID</th>
          <th class="text-white">NAME</th>
          <th class="text-white">ID NUMBER</th>
          <th class="text-white">BRANCH</th>
          <th class="text-white">CLASS</th>
          <th class="text-white">PDL</th>
          <th class="text-white">EXAM</th>
          <th class="text-white">TSHIRT</th>
          <th class="text-white">STATUS</th>
          <th class="text-white">CREATED ON</th>
         <!--  <th class="text-white">ACTIONS</th> -->
        </tr>
      </thead>
      <tbody>
        @forelse($students as $student)
          <tr>
            <td class="text-white">
              <a href="{{ route('students.alumni.show', $student) }}" class="text-decoration-none text-light">
                {{ '0'.$student->id }}
              </a>
            </td>
            <td class="text-white">
              <a href="{{ route('students.alumni.show', $student) }}" class="text-decoration-none text-light">
                {{ $student->full_name }}
              </a>
            </td>
            <td class="text-white">{{ $student->id_number }}</td>
            <td class="text-white">{{ $student->branch->name }}</td>
            <td class="text-white">{{ $student->class->name }}</td>
            <td class="text-white">{{ $student->pdl_status }}</td>
            <td class="text-white">{{ $student->exam_status }}</td>
            <td class="text-white">{{ $student->tshirt_status }}</td>
            <td class="text-white">{{ $student->student_status }}</td>
            <td class="text-white">{{ $student->created_at->format('jS F Y') }}</td>
            <td>
              <div class="d-flex gap-2 flex-wrap">
               <!--  <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary btn-sm">
                  <i class="mdi mdi-border-color"></i> Edit
                </a> -->
                <!-- <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?')">
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
            <td colspan="11" class="text-center text-white">No alumni found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-center mt-4">
    {{ $students->withQueryString()->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection
