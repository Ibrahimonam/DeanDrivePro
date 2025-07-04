@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card bg-dark text-light shadow-lg rounded">
        <div class="card-header d-flex justify-content-between align-items-center border-0">
            <h4 class="text-uppercase mb-0">Edit User</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>


        <div class="card-body">
          
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>There were some issues:</strong>
              <ul class="mb-0 mt-1">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
              <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          <form action="{{ route('admin.users.update', $user) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control text-primary" required>
            </div>

            <div class="form-group mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control text-primary" required>
            </div>

            <div class="form-group mb-3">
              <label for="password" class="form-label ">New Password <small class="text-muted">(leave blank to keep current)</small></label>
              <input type="password" name="password" id="password" class="form-control text-primary">
            </div>

            <div class="form-group mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control text-primary">
            </div>

            <div class="form-group mb-3">
              <label for="role" class="form-label">User Role</label>
              <select name="role" id="role" class="form-control text-primary" required>
                @foreach($roles as $role)
                  <option value="{{ $role->name }}"
                    {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                    {{ $role->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group mb-3">
              <label for="branch_id" class="form-label">Branch</label>
              <select name="branch_id" id="branch_id" class="form-control text-primary">
                <option value="">-- None --</option>
                @foreach($branches as $branch)
                  <option value="{{ $branch->id }}"
                    {{ old('branch_id', $user->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group mb-4">
              <label for="zone_id" class="form-label">Zone</label>
              <select name="zone_id" id="zone_id" class="form-control text-primary">
                <option value="">-- None --</option>
                @foreach($zones as $zone)
                  <option value="{{ $zone->id }}"
                    {{ old('zone_id', $user->zone_id ?? '') == $zone->id ? 'selected' : '' }}>
                    {{ $zone->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-outline-success px-4">
                Save Changes
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
