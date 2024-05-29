<nav class="sidebar sidebar-offcanvas" style="width: 300px" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#master_data" aria-expanded="false"
                aria-controls="master_data">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Surat Permohonan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master_data">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengadministrasi-umum.surat.index') }}"> Surat Tugas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengadministrasi-umum.permohonan-spd.index') }}"> Permohonan SPD </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#surat" aria-expanded="false"
                aria-controls="surat">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Surat</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="surat">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengadministrasi-umum.spd.index') }}"> Surat Perjalan Dinas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""> Surat Pertanggung Jawaban </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#master_data1" aria-expanded="false"
                aria-controls="master_data1">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan Belanja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master_data1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengadministrasi-umum.pengajuan-surat-non-pbj.index') }}"> Non PBJ Surat </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengadministrasi-umum.pengajuan-form-non-pbj.index') }}"> Non PBJ Formulir </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengadministrasi-umum.pengajuan-pbj.index') }}"> PBJ </a>
                    </li>
                </ul>
            </div>
        </li>
        {{--  <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Surat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.pengajuan-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Pengajuan PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('pengadministrasi-umum.surat-non-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Pengajuan Surat Non PBJ</span>
            </a>
        </li>  --}}
    </ul>
</nav>
