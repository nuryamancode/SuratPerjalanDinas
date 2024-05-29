<nav class="sidebar sidebar-offcanvas" style="width: 330px" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('ppk.dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#approval" aria-expanded="false"
                aria-controls="approval">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Approval Permohonan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="approval">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.permohonan-spd.index') }}"> Surat Perjalan Dinas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.surat-non-pbj-spj.index') }}"> SPJ Surat Non PBJ </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.form-non-pbj-spj.index') }}"> SPJ Form Non PBJ </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.form-non-pbj.index') }}"> Form Non PBJ </a>
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
                        <a class="nav-link" href="{{ route('ppk.spd.index') }}"> Surat Perjalan Dinas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""> Surat PertanggungJawaban </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#permohonan" aria-expanded="false"
                aria-controls="permohonan">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan Belanja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="permohonan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.surat-non-pbj.index') }}"> Non PBJ Surat </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.pengajuan-form-non-pbj.index') }}"> Non PBJ Formulir </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ppk.pengajuan-pbj.index')  }}"> PBJ </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('ppk.tte.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">TTE</span>
            </a>
        </li>
        {{--  <li class="nav-item">
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
            <a class="nav-link py-2" href="{{ route('ppk.spd-spj.index') }}">
                <i class="mdi mdi-folder pr-2 icon-large"></i>
                <span class="menu-title">SPJ SPD</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Form Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('ppk.form-non-pbj-spj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">SPJ Form Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Pengajuan PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Surat Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">SPJ Surat Non PBJ</span>
            </a>
        </li>  --}}
    </ul>
</nav>
