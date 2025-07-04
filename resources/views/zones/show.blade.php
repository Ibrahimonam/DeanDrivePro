@extends('layouts.main_layout')

@section('content')

<div class="container mt-5">
    <!-- Zone Name -->
    <div class="text-center mb-4">
        <h3 class="blockquote text-light text-uppercase">{{ $zone->name }}</h3>
    </div>

    <!-- Go Back Button -->
    <div class="mb-3">
        <a class="btn btn-outline-primary" href="{{ route('zones.index') }}">
            <i class="mdi mdi-arrow-left"></i> Go Back
        </a>
    </div>

    <!-- Zone Details Card -->
    <div class="card bg-dark text-light shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary mb-4">Zone Details</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Zone Name:</strong>
                    <span class="text-primary">{{ $zone->name }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Created On:</strong>
                    <span class="text-primary">{{ $zone->created_at->format('jS F Y') }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <strong>Description:</strong>
                    <p class="text-primary mb-0">{{ $zone->description ?? '—' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <strong>Branches in Zone:</strong>
                    <span class="text-primary">{{ $zone->branches()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
     @role('Admin')
    <div class="card bg-dark text-light shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('zones.destroy', $zone) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger">
                        <i class="mdi mdi-alert"></i> Deleting this zone is irreversible.
                    </span>
                    <button type="submit"
                            class="btn btn-outline-danger"
                            onclick="return confirm('Are you sure you want to delete this zone?')">
                        <i class="mdi mdi-delete"></i> Delete Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endrole()
</div>

@endsection
