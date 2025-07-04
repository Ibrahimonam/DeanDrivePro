@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <!-- Name -->
    <div class="text-center mb-4">
        <h3 class="blockquote text-light text-uppercase">{{ $teacher->full_name }}</h3>
    </div>

    <!-- Back -->
    <div class="mb-3">
        <a class="btn btn-outline-primary" href="{{ route('teachers.index') }}">
            <i class="mdi mdi-arrow-left"></i> Go Back
        </a>
    </div>

    <!-- Details -->
    <div class="card bg-dark text-light shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary mb-4">Teacher Details</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong> <span class="text-primary">{{ $teacher->email }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Phone:</strong> <span class="text-primary">{{ $teacher->phone_number }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>ID Number:</strong> <span class="text-primary">{{ $teacher->id_number }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Branch:</strong> <span class="text-primary">{{ $teacher->branch->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete -->
    @role('Admin')
    <div class="card bg-dark text-light shadow-sm mt-4">
        <div class="card-body">
            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                @csrf @method('DELETE')
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger">
                        <i class="mdi mdi-alert"></i> Deleting this teacher is irreversible.
                    </span>
                    <button class="btn btn-outline-danger" onclick="return confirm('Delete this teacher?')">
                        <i class="mdi mdi-delete"></i> Delete Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endrole()
</div>
@endsection
