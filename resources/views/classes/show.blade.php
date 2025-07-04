@extends('layouts.main_layout')

@section('content')

<div class="container mt-5">
    <!-- Class Name -->
    <div class="text-center mb-4">
        <h3 class="blockquote text-light text-uppercase">{{ $class->name }}</h3>
    </div>

    <!-- Go Back Button -->
    <div class="mb-3">
        <a class="btn btn-outline-primary" href="{{ route('classes.index') }}">
            <i class="mdi mdi-arrow-left"></i> Go Back
        </a>
    </div>

    <!-- Class Details Card -->
    <div class="card bg-dark text-light shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary mb-4">Class Details</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Class Name:</strong>
                    <span class="text-primary">{{ $class->name }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Duration:</strong>
                    <span class="text-primary">{{ $class->duration }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Fee:</strong>
                    <span class="text-primary">Ksh {{ number_format($class->fee, 2) }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Description:</strong>
                    <span class="text-primary">{{ $class->description }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <div class="card bg-dark text-light shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('classes.destroy', $class) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger">
                        <i class="mdi mdi-alert"></i> Deleting this class is irreversible.
                    </span>
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this class?')">
                        <i class="mdi mdi-delete"></i> Delete Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
