@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="card bg-dark text-light shadow-sm">
    <div class="card-header">
      <h5>Send SMS to Students by Class</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('sms.send_all_class_students') }}">
        @csrf
        <div class="mb-3">
          <label for="class_id" class="form-label">Select Class</label>
          <select name="class_id" id="class_id" class="form-select" required>
            <option value="">-- Select Class --</option>
            @foreach($courses as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">SMS Message</label>
          <textarea name="message" id="message" rows="4" class="form-control text-light" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Send SMS</button>
      </form>
    </div>
  </div>
</div>
@endsection
