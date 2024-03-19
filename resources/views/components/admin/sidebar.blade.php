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
        @can('Surat Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('surat.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Surat</span>
                </a>
            </li>
        @endcan
        @can('Surat Perjalanan Dinas Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('surat-perjalanan-dinas.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Surat Perjalanan Dinas</span>
                </a>
            </li>
        @endcan
        @can('Karyawan Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('karyawan.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Karyawan</span>
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#master_data" aria-expanded="false"
                aria-controls="master_data">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Master Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master_data">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}"> Role </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">Permission </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">User </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jabatan.index') }}"> Jabatan </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('golongan.index') }}"> Golongan </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
