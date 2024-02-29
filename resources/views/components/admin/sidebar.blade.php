<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @can('Dashboard')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('dashboard') }}">
                    <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        @endcan
        @can('Role Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('roles.index') }}">
                    <i class="mdi mdi-shield-account  pr-2 icon-large"></i>
                    <span class="menu-title">Roles</span>
                </a>
            </li>
        @endcan
        @can('Permission Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('permissions.index') }}">
                    <i class="mdi mdi-security  pr-2 icon-large"></i>
                    <span class="menu-title">Permission</span>
                </a>
            </li>
        @endcan
        @can('User Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('users.index') }}">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
        @endcan
    </ul>
</nav>
