@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h3 class="text-light text-uppercase">Practicals</h3>
        </div>
        <div class="col-12 col-md-6 text-md-end text-start mt-3 mt-md-0">
            <a href="{{ route('practicals.create') }}" class="btn btn-outline-light">
                <i class="mdi mdi-plus-circle-outline"></i> Add New
            </a>
        </div>
    </div>

    <!-- Search & Count -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h5 class="text-light">Total Practicals: <span class="text-light">{{ $practicals->total() }}</span></h5>
        </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0">
            <form action="{{ route('practicals.index') }}" method="GET" class="d-flex">
                <input
                    type="text"
                    name="search"
                    class="form-control bg-dark text-light border-light w-100"
                    placeholder="Search..."
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
        <thead class="text-uppercase" style="background-color: #007bff !important;">
          <tr>
            <th class="text-white">ID</th>
            <th class="text-white">NAME</th>
            <th class="text-white">DURATION</th>
            <th class="text-white">CREATED ON</th>
            <th class="text-white">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($practicals as $practical)
            <tr>
              <td class="text-white">
                <a href="{{ route('practicals.show', $practical) }}" class="text-decoration-none text-light">
                  {{ '0'.$practical->id }}
                </a>
              </td>
              <td class="text-white">
                <a href="{{ route('practicals.show', $practical) }}" class="text-decoration-none text-light">
                  {{ $practical->name }}
                </a>
              </td>
              <td class="text-white">{{ $practical->duration }}</td>
              <td class="text-white">{{ $practical->created_at->format('jS F Y') }}</td>
              <td>
                <div class="d-flex gap-2 flex-wrap">
                  <a href="{{ route('practicals.edit', $practical) }}" class="btn btn-outline-primary btn-sm">
                    <i class="mdi mdi-border-color"></i> Edit
                  </a>
                  <!-- <form action="{{ route('practicals.destroy', $practical) }}" method="POST" onsubmit="return confirm('Delete this practical?')">
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
              <td colspan="5" class="text-center text-white">No practicals found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      {{ $practicals->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
