<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('karyawan.dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('karyawan.spd.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('karyawan.riwayat-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Riwayat PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('karyawan.form-non-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Pengajuan Form Non PBJ</span>
            </a>
        </li>
    </ul>
</nav>
