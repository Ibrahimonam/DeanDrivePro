@extends('layouts.main_layout')

@section('content')

<div class="container mt-5">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h3 class="text-light text-uppercase">Branches</h3>
        </div>
        <div class="col-12 col-md-6 text-md-end text-start mt-3 mt-md-0">
            <a href="{{route('branches.download')}}" class="btn btn-outline-light me-2">
                <i class="mdi mdi-download"></i> Download List
            </a>
            <a href="{{ route('branches.create') }}" class="btn btn-outline-light">
                <i class="mdi mdi-plus-circle-outline"></i> Add New
            </a>
        </div>
    </div>
    
    <!-- Search and Statistics Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-6">
            <h5 class="text-light">Total Branches: <span class="text-light">{{ $total_branches }}</span></h5>
        </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0">
            <form action="{{ route('branches.index') }}" method="GET" class="d-flex">
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
    @if (session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session()->get('message') }}
        </div>
    @endif

    @if (session()->has('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    <!-- Branches Table -->
    <div class="table-responsive shadow-lg">
        <table class="table  table-striped align-middle">
            <thead class="text-uppercase" style="background-color: #007bff !important;">
                <tr>
                    <th class="text-white">BRANCH ID</th>
                    <th class="text-white">BRANCH NAME</th>
                    <th class="text-white">LOCATION</th>
                    <th class="text-white">ZONE</th>
                    <th class="text-white">PAYBILL NUMBER</th>
                    <th class="text-white">PHONE NUMBER</th>
                    <th class="text-white">CREATED ON</th>
                    <th class="text-white">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                    <tr>
                        <td class="text-white">
                            <a href="{{ route('branches.show', $branch) }}" class="text-decoration-none text-light">
                               {{ '0'.$branch->id }}
                            </a>
                        </td>
                        <td class="text-white">
                            <a href="{{ route('branches.show', $branch) }}" class="text-decoration-none text-light">
                                {{ $branch->name }}
                            </a>
                        </td>
                        <td class="text-white">
                            <a href="{{ route('branches.show', $branch) }}" class="text-decoration-none text-light">
                                {{ $branch->address }}
                            </a>
                        </td>
                        <td class="text-white">
                            <a href="{{ route('branches.show', $branch) }}" class="text-decoration-none text-light">
                                {{ $branch->zone->name }}
                            </a>
                        </td>
                        <td class="text-white">{{ $branch->paybill_number }}</td>
                        <td class="text-white">{{ $branch->phone_number }}</td>
                        <td class="text-white">{{ $branch->created_at->format('jS F Y') }}</td>

                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-outline-primary btn-sm">
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
        {{ $branches->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
