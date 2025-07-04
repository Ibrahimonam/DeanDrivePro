@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <!-- Title -->
    <div class="text-center mb-4">
        <h3 class="blockquote text-light text-uppercase">{{ $practical->name }}</h3>
    </div>

    <!-- Back -->
    <div class="mb-3">
        <a class="btn btn-outline-primary" href="{{ route('practicals.index') }}">
            <i class="mdi mdi-arrow-left"></i> Go Back
        </a>
    </div>

    <!-- Details Card -->
    <div class="card bg-dark text-light shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary mb-4">Practical Details</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <span class="text-primary">{{ $practical->name }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Duration:</strong>
                    <span class="text-primary">{{ $practical->duration }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <strong>Description:</strong>
                    <p class="text-primary mb-0">{{ $practical->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete -->
    @role('Admin')
    <div class="card bg-dark text-light shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('practicals.destroy', $practical) }}" method="POST">
                @csrf @method('DELETE')
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger">
                        <i class="mdi mdi-alert"></i> Deleting this practical is irreversible.
                    </span>
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this practical?')">
                        <i class="mdi mdi-delete"></i> Delete Practical
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endrole()
</div>
@endsection
