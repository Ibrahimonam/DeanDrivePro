@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Edit User</h3>
        </div>
        <div class="card-body">
          {{-- Display validation errors --}}
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
    
          {{-- Begin form --}}
          <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">New Password (optional)</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select name="role" id="role" class="form-control" required>
                @foreach($roles as $role)
                  <option value="{{ $role->name }}"
                    {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                    {{ $role->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="branch_id" class="form-label">Branch</label>
              <select name="branch_id" id="branch_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($branches as $branch)
                  <option value="{{ $branch->id }}"
                    {{ old('branch_id', $user->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="zone_id" class="form-label">Zone</label>
              <select name="zone_id" id="zone_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($zones as $zone)
                  <option value="{{ $zone->id }}"
                    {{ old('zone_id', $user->zone_id ?? '') == $zone->id ? 'selected' : '' }}>
                    {{ $zone->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="text-end">
              <button class="btn btn-success">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
