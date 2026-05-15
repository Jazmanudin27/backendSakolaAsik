<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle d-flex">
        <i class="hamburger align-self-center"></i>
    </a>
    <form class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <h4 id="clock"></h4>
        </div>
    </form>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                    <img src="{{ asset('adminkit/img/avatars/avatar.jpg') }}"
                        class="avatar img-fluid rounded mr-1" alt="User" /> <span
                        class="text-dark">{{ Auth::guard('siswa')->user()->nama ?? 'Siswa' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="user"></i>
                        Profile</a>
                    <a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="pie-chart"></i> Analytics</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="align-middle mr-1"
                            data-feather="settings"></i> Settings & Privacy</a>
                    <a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="help-circle"></i> Help
                        Center</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="align-middle mr-1" data-feather="log-out"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
