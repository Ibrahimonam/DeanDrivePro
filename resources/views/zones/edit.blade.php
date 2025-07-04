@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Edit Zone</h3>
        </div>
        <div class="card-body">

         <!-- Back Button -->
          <div class="mb-3">
            <a href="{{ route('zones.index') }}" class="btn btn-sm btn-outline-light">
              <i class="mdi mdi-arrow-left-circle-outline"></i> Back to Zones
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

          <form action="{{ route('zones.update', $zone) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Zone Name -->
            <div class="form-group row mb-3">
              <label for="name" class="col-sm-4 col-form-label">Zone Name</label>
              <div class="col-sm-8">
                <input
                  type="text"
                  name="name"
                  id="name"
                  class="form-control bg-secondary text-light"
                  value="{{ old('name', $zone->name) }}"
                >
              </div>
            </div>

            <!-- Description -->
            <div class="form-group row mb-3">
              <label for="description" class="col-sm-4 col-form-label">Description</label>
              <div class="col-sm-8">
                <textarea
                  name="description"
                  id="description"
                  class="form-control bg-secondary text-light"
                  rows="3"
                  placeholder="Enter a brief description of the zone"
                >{{ old('description', $zone->description) }}</textarea>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row">
              <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-outline-primary">
                  <i class="mdi mdi-check-circle-outline"></i>
                  Update Zone
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
