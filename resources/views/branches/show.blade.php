@extends('layouts.main_layout')

@section('content')

<div class="container mt-5">
    <!-- Customer Name -->
    <div class="text-center mb-4">
        <h3 class="blockquote text-light text-uppercase">{{$branch->name }}</h3>
    </div>

    <!-- Go Back Button -->
    <div class="mb-3">
        <a class="btn btn-outline-primary" href="{{ route('branches.index') }}">
            <i class="mdi mdi-arrow-left"></i> Go Back
        </a>
    </div>

    <!-- Customer Details Card -->
    <div class="card bg-dark text-light shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary mb-4">Branch Details</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Branch Name:</strong>
                    <span class="text-primary">{{ $branch->name }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Zone:</strong>
                    <span class="text-primary">{{ $branch->zone->name }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Phone No:</strong>
                    <span class="text-primary">{{ $branch->phone_number }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Paybill Number:</strong>
                    <span class="text-primary">{{ $branch->paybill_number }}</span>
                </div>

            </div>

            
        </div>
    </div>

    <!-- Delete Form -->
    @role('Admin')
    <div class="card bg-dark text-light shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('branches.destroy', $branch) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger">
                        <i class="mdi mdi-alert"></i> Deleting this branch is irreversible.
                    </span>
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this branch ?')">
                        <i class="mdi mdi-delete"></i> Delete branch
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endrole()
</div>

@endsection
