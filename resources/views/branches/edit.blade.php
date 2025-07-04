@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Edit Branch</h3>
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

          <form action="{{ route('branches.update', $branch) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Branch Name -->
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">Branch Name</label>
              <div class="col-sm-9">
                <input type="text" name="name" id="name"
                       class="form-control bg-secondary text-light"
                       value="{{ old('name', $branch->name) }}">
              </div>
            </div>

            <!-- Address -->
            <div class="form-group row">
              <label for="address" class="col-sm-3 col-form-label">Location</label>
              <div class="col-sm-9">
                <input type="text" name="address" id="address"
                       class="form-control bg-secondary text-light"
                       value="{{ old('address', $branch->address) }}">
              </div>
            </div>

            <!-- Phone -->
            <div class="form-group row">
              <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
              <div class="col-sm-9">
                <input type="text" name="phone_number" id="phone_number"
                       class="form-control bg-secondary text-light"
                       value="{{ old('phone_number', $branch->phone_number) }}">
              </div>
            </div>

            <!-- Paybill Number -->
            <div class="form-group row">
              <label for="paybill_number" class="col-sm-3 col-form-label">Paybill Number</label>
              <div class="col-sm-9">
                <input type="text" name="paybill_number" id="paybill_number"
                       class="form-control bg-secondary text-light"
                       value="{{ old('paybill_number', $branch->paybill_number) }}">
              </div>
            </div>

            <!-- Zone Dropdown -->
            <div class="form-group row">
              <label for="zone_id" class="col-sm-3 col-form-label">Zone</label>
              <div class="col-sm-9">
                <select name="zone_id" id="zone_id"
                        class="form-control bg-secondary text-light">
                  <option value="">-- Select Zone --</option>
                  @foreach($zones as $zone)
                    <option value="{{ $zone->id }}"
                      {{ old('zone_id', $branch->zone_id) == $zone->id ? 'selected' : '' }}>
                      {{ $zone->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Submit -->
            <div class="form-group row">
              <div class="d-flex justify-content-end w-100">
                <button type="submit" class="btn btn-outline-primary">
                  <i class="mdi mdi-check-circle-outline"></i> Update Branch
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
