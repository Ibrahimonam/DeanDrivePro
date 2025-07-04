@extends('layouts.main_layout')

@section('content')


<div class="row">
    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="/students"> All Students</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
             {{-- <h6 class="text-muted font-weight-normal">Full Course : *********</h6>
              <h6 class="text-muted font-weight-normal">Half Course : ********</h6> --}}
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                
               <h3 class="mb-0">Total : 1002 </h3> 
                {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> --}}
              </div>
              
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-account-multiple text-primary ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="#"> Full Course Students</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h3 class="mb-0">Total : ************ </h3>
                {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p> --}}
              </div>
              {{-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> --}}
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-account-multiple text-danger ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="#">Half Course Students</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h3 class="mb-0">Total : ********</h3>
                {{-- <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p> --}}
              </div>
              {{-- <h6 class="text-muted font-weight-normal">2.27% Since last month</h6> --}}
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-account-multiple text-success ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="row">
    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="/branches">Branches</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h3 class="mb-0">Total : ********** </h3>
                {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> --}}
              </div>
              {{-- <h6 class="text-muted font-weight-normal">11.38% Since last month</h6> --}}
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-package text-primary ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="/classes">Courses</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h3 class="mb-0">Total : *********</h3>
                {{-- <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p> --}}
              </div>
              {{-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> --}}
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-package text-danger ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="/practicals">Practicals Classes</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h3 class="mb-0">Total : ********</h3>
                {{-- <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p> --}}
              </div>
              {{-- <h6 class="text-muted font-weight-normal">2.27% Since last month</h6> --}}
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-package text-success ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="#">Sellers </a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h2 class="mb-0">*****</h2>
                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
              </div>
              <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-account-multiple text-success ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="#">Defaulted Accounts</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h2 class="mb-0">7</h2>
                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
              </div>
              <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-book-open text-success ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h5><a href="#">Reports</a></h5>
          <div class="row">
            <div class="col-8 col-sm-12 col-xl-8 my-auto">
              <div class="d-flex d-sm-block d-md-flex align-items-center">
                <h2 class="mb-0">7</h2>
                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
              </div>
              <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
            </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
              <i class="icon-lg mdi mdi-book-open text-success ml-auto"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    --}}
  </div>
 



















@endsection