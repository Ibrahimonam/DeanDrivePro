<!-- _form.blade.php -->
@csrf
<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
</div>

@if (!isset($user))
<div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
</div>
<div class="mb-3">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" required>
</div>
@else
<div class="mb-3">
    <label>New Password (optional)</label>
    <input type="password" name="password" class="form-control">
</div>
<div class="mb-3">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>
@endif

<div class="mb-3">
    <label>Role</label>
    <select name="role" class="form-control" required>
    @foreach($roles as $role)
        <option value="{{ $role->name }}"
            {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
            {{ $role->name }}
        </option>
    @endforeach
</select>

</div>

<div class="mb-3">
    <label>Branch</label>
    <select name="branch_id" class="form-control">
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
    <label>Zone</label>
    <select name="zone_id" class="form-control">
        <option value="">-- None --</option>
        @foreach($zones as $zone)
            <option value="{{ $zone->id }}"
                {{ old('zone_id', $user->zone_id ?? '') == $zone->id ? 'selected' : '' }}>
                {{ $zone->name }}
            </option>
        @endforeach
    </select>
</div>

<button class="btn btn-success">Save</button>
