@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Create Teacher</h3>
        </div>
        <div class="card-body">
          <!-- Back Button -->
          <div class="mb-3">
            <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-light">
              <i class="mdi mdi-arrow-left-circle-outline"></i> Back to Teachers
            </a>
          </div>
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif

          <form action="{{ route('teachers.store') }}" method="POST">
            @csrf

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">First Name</label>
              <div class="col-sm-9">
                <input name="first_name" class="form-control bg-secondary text-light"
                       value="{{ old('first_name') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Last Name</label>
              <div class="col-sm-9">
                <input name="last_name" class="form-control bg-secondary text-light"
                       value="{{ old('last_name') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="email" name="email" class="form-control bg-secondary text-light"
                       value="{{ old('email') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Phone Number</label>
              <div class="col-sm-9">
                <input name="phone_number" class="form-control bg-secondary text-light"
                       value="{{ old('phone_number') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">ID Number</label>
              <div class="col-sm-9">
                <input name="id_number" class="form-control bg-secondary text-light"
                       value="{{ old('id_number') }}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Branch</label>
              <div class="col-sm-9">
                <select name="branch_id" class="form-control bg-secondary text-light">
                  <option value="">-- Select Branch --</option>
                  @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ old('branch_id')==$b->id?'selected':'' }}>
                      {{ $b->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button class="btn btn-outline-primary">
                  <i class="mdi mdi-check-circle-outline"></i> Create Teacher
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
