<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $class->name) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $class->description) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Duration</label>
    <input type="text" name="duration" class="form-control" value="{{ old('duration', $class->duration) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Fee (KES)</label>
    <input type="number" step="0.01" name="fee" class="form-control" value="{{ old('fee', $class->fee) }}" required>
</div>
