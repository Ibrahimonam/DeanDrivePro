@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Create Practical</h3>
        </div>
        <div class="card-body">
          <!-- Back Button -->
          <div class="mb-3">
            <a href="{{ route('practicals.index') }}" class="btn btn-sm btn-outline-light">
              <i class="mdi mdi-arrow-left-circle-outline"></i> Back to Practicals
            </a>
          </div>
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('practicals.store') }}" method="POST">
            @csrf

            <div class="form-group row mb-3">
              <label for="name" class="col-sm-3 col-form-label">Name</label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name"
                       class="form-control bg-secondary text-light"
                       placeholder="Enter name"
                       value="{{ old('name') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="description" class="col-sm-3 col-form-label">Description</label>
              <div class="col-sm-9">
                <textarea name="description" id="description" rows="3"
                          class="form-control bg-secondary text-light"
                          placeholder="Enter description">{{ old('description') }}</textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="duration" class="col-sm-3 col-form-label">Duration</label>
              <div class="col-sm-9">
                <input type="text" name="duration" id="duration"
                       class="form-control bg-secondary text-light"
                       placeholder="e.g. 2 weeks"
                       value="{{ old('duration') }}">
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button type="submit" class="btn btn-outline-primary">
                  <i class="mdi mdi-check-circle-outline"></i> Create Practical
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
