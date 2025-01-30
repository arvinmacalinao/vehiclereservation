<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
      </ul>
  
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          @php
                    $allNotificationsCount = $notifications->count();
          @endphp
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa fa-bell" aria-hidden="true"></i>
            @if($allNotificationsCount >= 1)
              <span class="badge badge-danger">{{ $allNotificationsCount }}</span>
            @endif
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li>
                <a href="{{ route('notification.list') }}" class="dropdown-item">View All Notifications
                </a><!-- Display the total number of unsold and sold notifications -->
              </li>
              
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('user.profile', ['id' => Auth::id() ]) }}" class="dropdown-item">Profile</a></li>
              <li class="dropdown-divider"></li>
              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST" style="display: none;">
                  @csrf
                </form>
                <div class="dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();">{{ __('Log out') }}</a>
              </div>
              </li>
              <!-- End Level two -->
            </ul>
          </li>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
  
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="../../images/vr_logo.png" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Vehicle Res</span>
      </a>
  
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="{{ route('user.profile', ['id' => Auth::id() ]) }}" class="d-block">{{ Auth::user()->fullname }}</a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-header">Menu</li>
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            @php
                // Get the authenticated user's ID
                $userId = auth()->id();
                          
                // Get the user's roles
                $userRoles = App\Models\UserRole::where('u_id', $userId)->pluck('role_id');
                          
                // Get the role names associated with the user's roles
                $roleNames = App\Models\Role::whereIn('role_id', $userRoles)->pluck('name');
                          
                // Check if the user has the SUPERADMIN role
                $driver = $roleNames->contains('DRIVER');
            @endphp   
            @if($driver)
            <li class="nav-item">
              <a href="{{ route('schedule', ['id' => Auth::id()]) }}" class="nav-link">
                <i class="fa-solid fas fa-car-side"></i>
                <p>
                  Scheduled Trips
                </p>
              </a>
            </li>
            @else
            <li class="nav-item">
              <a href="{{ route('reservation.index') }}" class="nav-link">
                <i class="fa-solid fas fa-car-side"></i>
                <p>
                  Reserve Vehicle
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('approval.index') }}" class="nav-link">
                <i class="fa-solid fas fa-calendar-check"></i>
                <p>
                  Approvals
                </p>
              </a>
            </li>
            @endif
            @php
                // Get the authenticated user
                $user = auth()->user();

                // Check if the user belongs to the RDU group
                $belongsToRDUGroup = $user->user_groups()->where('g_id', 3)->exists();
            @endphp
            @if ($belongsToRDUGroup)
            <li class="nav-header">RDU Settings</li>
                <li class="nav-item">
                    <a href="{{ route('vehicle.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Vehicles</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('driver.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Drivers</p>
                    </a>
              </li>
            @endif
            @php
                // Get the authenticated user's ID
                $userId = auth()->id();
                          
                // Get the user's roles
                $userRoles = App\Models\UserRole::where('u_id', $userId)->pluck('role_id');
                          
                // Get the role names associated with the user's roles
                $roleNames = App\Models\Role::whereIn('role_id', $userRoles)->pluck('name');
                          
                // Check if the user has the SUPERADMIN role
                $hasSuperAdminRole = $roleNames->contains('SUPERADMIN');
            @endphp
                          
            @if ($hasSuperAdminRole)
            <li class="nav-header">RDU Settings</li>
                <li class="nav-item">
                    <a href="{{ route('vehicle.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Vehicles</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('driver.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Drivers</p>
                    </a>
              </li>
                <li class="nav-header">Admin Settings</li>
                <li class="nav-item">
                    <a href="{{ route('role.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Roles</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('group.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Groups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Users</p>
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
            @else
            
            @endif
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </aside>
  