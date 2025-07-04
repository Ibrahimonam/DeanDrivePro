<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dean Driving School</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      setTimeout(function () {
        $(".alert").fadeOut("slow");
      }, 8000); // Hide alert after 8 seconds
    </script>
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- Side Navigation (unchanged) -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex fixed-top">
          <a class="sidebar-brand brand-logo" style="color:blanchedalmond" href="https://optimumdefensivedriving.co.ke/">
            <img src="../../assets/images/dashboard/optimum_defensive_driving_logo.png" style="max-width: 300px; margin-bottom:20px; min-height:80px; padding:10px;" />
          </a>
          <a class="sidebar-brand brand-logo-mini" style="color:blanchedalmond" href="https://optimumdefensivedriving.co.ke/">
            <img src="../../assets/images/dashboard/optimum_defensive_driving_icon.png" alt="logo" />
          </a>
        </div>
        <ul class="nav">
          <li class="nav-item nav-category">
            {{--  <span class="nav-link">Navigation</span>  --}}
          </li>
          <li class="nav-item menu-items" style="margin-top:20px;">
            <a class="nav-link" href="/dashboard">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-sitemap"></i>
              </span>
              <span class="menu-title">Branches</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-timetable"></i>
              </span>
              <span class="menu-title">Classes</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-truck"></i>
              </span>
              <span class="menu-title">Practicals</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-human-male-female"></i>
              </span>
              <span class="menu-title">Teachers</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#students" aria-expanded="false" aria-controls="students">
              <span class="menu-icon">
                <i class="mdi mdi-human-male-female"></i>
              </span>
              <span class="menu-title">Students</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="students">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#"> All students </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Expired PDL </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Alumni </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#payments" aria-expanded="false" aria-controls="payments">
              <span class="menu-icon">
                <i class="mdi mdi-cash-100"></i>
              </span>
              <span class="menu-title">Payments</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="payments">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#"> All Payments </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-cash-100"></i>
              </span>
              <span class="menu-title">Expenses</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#enrollments" aria-expanded="false" aria-controls="enrollments">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Reports</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="enrollments">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#">Enrolment Report</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Practicals Report</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Expenses Report</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#sms" aria-expanded="false" aria-controls="sms">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Send SMS Messages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sms">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#">SMS All Students</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">SMS Active Students</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Class SMS</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="#">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- End Side Navigation -->

      <div class="container-fluid page-body-wrapper">
        <!-- Navbar -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="../../index.html">
              <img src="../../assets/images/logo-mini.svg" alt="logo" />
            </a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" action="/customers" method="GET">
                  <input type="text" class="form-control text-primary" placeholder="Search Customers" id="search" name="search" value="{{ request()->query('search') }}" />
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <!-- Additional Navbar Items (Projects, Notifications, etc.) -->
              <li class="nav-item dropdown d-none d-lg-block">
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                  <h6 class="p-3 mb-0">Projects</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-file-outline text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">UI Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="#">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-layers text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Testing</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all projects</p>
                </div>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
              </li>
              <!-- Logout Dropdown -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="navbar-profile d-flex align-items-center">
                    <img class="img-xs rounded-circle" src="../../assets/images/faces/face15.jpg" alt="Profile Image" />
                    @auth
                      <span class="navbar-profile-name ml-2">{{ Auth::user()->name }}</span>
                    @else
                      <span class="navbar-profile-name ml-2">Guest</span>
                    @endauth
                    <i class="mdi mdi-menu-down ml-2"></i>
                  </div>
                
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <h6 class="dropdown-header p-3">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <!-- Logout Form -->
                  <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0" style="text-decoration: none;">
                      <i class="mdi mdi-logout mr-2"></i> Log out
                    </button>
                  </form>
                </div>
                </a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- End Navbar -->

        <!-- Main Panel -->
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          <!-- content-wrapper ends -->

          <!-- Footer -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">
                Copyright © Optimum Defensive Driving School {{ date('Y') }}
              </span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                Powered by <a href="https://www.deansystems.co.ke" target="_blank">Dean Systems</a>
              </span>
            </div>
          </footer>
          <!-- End Footer -->
        </div>
        <!-- End Main Panel -->
      </div>
      <!-- End page-body-wrapper -->
    </div>
    <!-- End container-scroller -->

    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>
