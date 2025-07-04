@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Create Branch</h3>
        </div>
        <div class="card-body">

          <!-- Back Button -->
          <div class="mb-3">
            <a href="{{ route('branches.index') }}" class="btn btn-sm btn-outline-light">
              <i class="mdi mdi-arrow-left-circle-outline"></i> Back to Branches
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

          <form action="{{ route('branches.store') }}" method="POST">
            @csrf
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">Branch Name</label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name" class="form-control bg-secondary text-light" placeholder="Enter branch name" value="{{ old('name') }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="address" class="col-sm-3 col-form-label">Location</label>
              <div class="col-sm-9">
                <input type="text" name="address" id="address" class="form-control bg-secondary text-light" placeholder="Enter Location" value="{{ old('address') }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
              <div class="col-sm-9">
                <input type="text" name="phone_number" id="phone_number" class="form-control bg-secondary text-light" placeholder="Enter phone number" value="{{ old('phone_number') }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="paybill_number" class="col-sm-3 col-form-label">Paybill Number</label>
              <div class="col-sm-9">
                <input type="text" name="paybill_number" id="paybill_number" class="form-control bg-secondary text-light" placeholder="Enter paybill number" value="{{ old('paybill_number') }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="zone_id" class="col-sm-3 col-form-label">Zone</label>
              <div class="col-sm-9">
                <select name="zone_id" id="zone_id" class="form-control bg-secondary text-light">
                  <option value="">-- Select Zone --</option>
                  @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                      {{ $zone->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mt-4">
              <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-outline-primary">
                  <i class="mdi mdi-check-circle-outline"></i> Create Branch
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
