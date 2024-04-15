<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.surat.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Surat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.permohonan-spd.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.pengajuan-form-non-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Form Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.pengajuan-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Pengajuan PBJ</span>
            </a>
        </li>
    </ul>
</nav>
