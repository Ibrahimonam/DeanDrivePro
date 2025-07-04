@extends('layouts.main_layout')

@section('content')

<div class="container mt-5">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h3 class="text-light text-uppercase">Classes</h3>
        </div>
        <div class="col-12 col-md-6 text-md-end text-start mt-3 mt-md-0">
            <a href="{{ route('classes.create') }}" class="btn btn-outline-light">
                <i class="mdi mdi-plus-circle-outline"></i> Add New
            </a>
        </div>
    </div>

    <!-- Search and Count -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h5 class="text-light">Total Classes: <span class="text-light">{{ $classes->total() }}</span></h5>
        </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0">
            <form action="{{ route('classes.index') }}" method="GET" class="d-flex">
                <input 
                    type="text" 
                    class="form-control bg-dark text-light border-light w-100" 
                    placeholder="Search Name" 
                    name="search" 
                    id="search" 
                    value="{{ request()->query('search') }}">
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Classes Table -->
    <div class="table-responsive shadow-lg">
        <table class="table table-striped align-middle">
            <thead class="text-uppercase" style="background-color: #007bff !important;">
                <tr>
                    <th class="text-white">ID</th>
                    <th class="text-white">NAME</th>
                    <th class="text-white">DURATION</th>
                    <th class="text-white">FEE (Ksh)</th>
                    <th class="text-white">CREATED ON</th>
                    <th class="text-white">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($classes as $class)
                    <tr>
                        <td class="text-white">
                            <a href="{{ route('classes.show', $class) }}" class="text-decoration-none text-light">
                                {{ '0' . $class->id }}
                            </a>
                        </td>
                        <td class="text-white">
                            <a href="{{ route('classes.show', $class) }}" class="text-decoration-none text-light">
                                {{ $class->name }}
                            </a>
                        </td>
                        <td class="text-white">{{ $class->duration }}</td>
                        <td class="text-white">{{ number_format($class->fee, 2) }}</td>
                        <td class="text-white">{{ $class->created_at->format('jS F Y') }}</td>

                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('classes.edit', $class) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="mdi mdi-border-color"></i> Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-white">No classes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $classes->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
