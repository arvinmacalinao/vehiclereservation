<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="../../index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>
  
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
  
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Vehicle Res</span>
      </a>
  
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->fullname }}</a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-header">Menu</li>
            <li class="nav-item">
              <a href="../calendar.html" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reservation.index') }}" class="nav-link">
                <i class="fa-solid fas fa-car-side"></i>
                <p>
                  Reserve Vehicle
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('vehicle.index') }}" class="nav-link">
                <i class="nav-icon fas fa-car"></i>
                <p>
                  Vehicles
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('driver.index') }}" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                  Drivers
                </p>
              </a>
            </li>
            <li class="nav-header">MISCELLANEOUS</li>
            <li class="nav-item">
              <a href="https://adminlte.io/docs/3.1/" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>Documentation</p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
            <li class="nav-item mb-5 mt-5">
              <a href="#" class="nav-link">
                <i></i>
                <p></p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </aside>
  </div>