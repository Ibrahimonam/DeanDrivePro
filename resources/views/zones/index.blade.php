@extends('layouts.main_layout')

@section('content')

<div class="container mt-5">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h3 class="text-light text-uppercase">Zones</h3>
        </div>
        <div class="col-12 col-md-6 text-md-end text-start mt-3 mt-md-0">
            <a href="{{ route('zones.download') }}" class="btn btn-outline-light me-2">
                <i class="mdi mdi-download"></i> Download List
            </a>
            <a href="{{ route('zones.create') }}" class="btn btn-outline-light">
                <i class="mdi mdi-plus-circle-outline"></i> Add New
            </a>
        </div>
    </div>
    
    <!-- Search and Statistics Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h5 class="text-light">Total Zones: <span class="text-light">{{ $total_zones }}</span></h5>
        </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0">
            <form action="{{ route('zones.index') }}" method="GET" class="d-flex">
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

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Zones Table -->
    <div class="table-responsive shadow-lg">
        <table class="table table-striped align-middle">
            <thead class="text-uppercase" style="background-color: #007bff !important;">
                <tr>
                    <th class="text-white">ZONE ID</th>
                    <th class="text-white">ZONE NAME</th>
                    <th class="text-white">CREATED ON</th>
                    <th class="text-white">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                    <tr>
                        <td class="text-white">
                            <a href="{{ route('zones.show', $zone) }}" class="text-decoration-none text-light">
                                {{ '0'.$zone->id }}
                            </a>
                        </td>
                        <td class="text-white">
                            <a href="{{ route('zones.show', $zone) }}" class="text-decoration-none text-light">
                                {{ $zone->name }}
                            </a>
                        </td>
                        <td class="text-white">{{ $zone->created_at->format('jS F Y') }}</td>

                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('zones.edit', $zone) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="mdi mdi-border-color"></i> Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $zones->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
