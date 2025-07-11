@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Edit Class</h3>
        </div>
        <div class="card-body">
          <!-- Back Button -->
          <div class="mb-3">
            <a href="{{ route('classes.index') }}" class="btn btn-sm btn-outline-light">
              <i class="mdi mdi-arrow-left-circle-outline"></i> Back to Classes
            </a>
          </div>
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('classes.update', $class) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group row mb-3">
              <label for="name" class="col-sm-3 col-form-label">Class Name</label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name" class="form-control bg-secondary text-light" value="{{ old('name', $class->name) }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="description" class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                <textarea name="description" id="description" class="form-control bg-secondary text-light" rows="3">{{ old('description', $class->description) }}</textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="duration" class="col-sm-3 col-form-label">Duration</label>
              <div class="col-sm-9">
                <input type="text" name="duration" id="duration" class="form-control bg-secondary text-light" value="{{ old('duration', $class->duration) }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="fee" class="col-sm-3 col-form-label">Fee</label>
              <div class="col-sm-9">
                <input type="number" step="0.01" name="fee" id="fee" class="form-control bg-secondary text-light" value="{{ old('fee', $class->fee) }}">
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button type="submit" class="btn btn-outline-success">
                  <i class="mdi mdi-content-save"></i> Update Class
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
