<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">EcosEth Cloud</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="/" class="d-block">Admin</a>
            </div>
        </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item">
            <a href="{{route('dash.index')}}" class="nav-link {{Route::is('dash.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link {{Route::is('users.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>

          <li class="nav-item">
            {{-- <a href="/withdraws.html" class="nav-link"> --}}
                <a href="{{route('users.withdraws')}}" class="nav-link">
                    <i class="nav-icon fas fa-minus-circle"></i>
                <p>Withdraws</p>
            
          </li>

          <li class="nav-item">
            <a href="{{route('rewards.index')}}" class="nav-link {{request()->route()->getName() == 'rewards.index' ? 'active' : ''}}">
              <i class="nav-icon fas fa-plus-circle"></i>
              <p>Reward Setting</p>
            </a>
          </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>Helper Setting</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('setting.index')}}" class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Setting</p>
                    </a>
                </li>

                <li class="nav-header">Manage Profile</li>

                <li class="nav-item">
                    <a href="{{route('profile.edit', ['id' => auth()->user()->id])}}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Edit Profile</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('password.edit', ['id' => auth()->user()->id])}}" class="nav-link">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Change Password</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
