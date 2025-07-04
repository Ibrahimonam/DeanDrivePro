@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-dark text-light shadow">
        <div class="card-header text-center">
          <h3 class="text-uppercase mb-0">Edit Student</h3>
        </div>
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf @method('PUT')

            <!-- personal -->
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">First Name</label>
              <div class="col-sm-9">
                <input name="first_name" class="form-control bg-secondary text-light"
                       value="{{ old('first_name', $student->first_name) }}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Middle Name</label>
              <div class="col-sm-9">
                <input name="middle_name" class="form-control bg-secondary text-light"
                       value="{{ old('middle_name', $student->middle_name) }}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Last Name</label>
              <div class="col-sm-9">
                <input name="last_name" class="form-control bg-secondary text-light"
                       value="{{ old('last_name', $student->last_name) }}">
              </div>
            </div>

            <!-- contacts -->
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="email" name="email" class="form-control bg-secondary text-light"
                       value="{{ old('email', $student->email) }}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Phone Number</label>
              <div class="col-sm-9">
                <input name="phone_number" class="form-control bg-secondary text-light"
                       value="{{ old('phone_number', $student->phone_number) }}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">ID Number</label>
              <div class="col-sm-9">
                <input name="id_number" class="form-control bg-secondary text-light"
                       value="{{ old('id_number', $student->id_number) }}">
              </div>
            </div>

            <!-- relations -->
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Branch</label>
              <div class="col-sm-9">
                <select name="branch_id" class="form-control bg-secondary text-light">
                  @foreach($branches as $b)
                    <option value="{{ $b->id }}"
                      {{ old('branch_id', $student->branch_id)==$b->id?'selected':'' }}>
                      {{ $b->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Class</label>
              <div class="col-sm-9">
                <select name="class_id" class="form-control bg-secondary text-light">
                  @foreach($classes as $c)
                    <option value="{{ $c->id }}"
                      {{ old('class_id', $student->class_id)==$c->id?'selected':'' }}>
                      {{ $c->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- statuses -->
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">PDL Status</label>
              <div class="col-sm-9">
                <select name="pdl_status" class="form-control bg-secondary text-light">
                  @foreach(['Booked','Not Booked','Accepted'] as $st)
                    <option value="{{ $st }}" {{ old('pdl_status', $student->pdl_status)==$st?'selected':'' }}>
                      {{ $st }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Exam Status</label>
              <div class="col-sm-9">
                <select name="exam_status" class="form-control bg-secondary text-light">
                  @foreach(['Booked','Not Booked'] as $st)
                    <option value="{{ $st }}" {{ old('exam_status', $student->exam_status)==$st?'selected':'' }}>
                      {{ $st }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">T-Shirt Status</label>
              <div class="col-sm-9">
                <select name="tshirt_status" class="form-control bg-secondary text-light">
                  @foreach(['Issued','Not Issued'] as $st)
                    <option value="{{ $st }}" {{ old('tshirt_status', $student->tshirt_status)==$st?'selected':'' }}>
                      {{ $st }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-3 col-form-label">Student Status</label>
              <div class="col-sm-9">
                <select name="student_status" class="form-control bg-secondary text-light">
                  @foreach(['Active','Cleared','Expired'] as $st)
                    <option value="{{ $st }}" {{ old('student_status', $student->student_status)==$st?'selected':'' }}>
                      {{ $st }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- submit -->
            <div class="form-group row mt-4">
              <div class="d-flex justify-content-end w-100">
                <button type="submit" class="btn btn-outline-success">
                  <i class="mdi mdi-content-save"></i> Update Student
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
