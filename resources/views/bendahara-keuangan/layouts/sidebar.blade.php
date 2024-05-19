<nav class="sidebar sidebar-offcanvas" style="width: 300px" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('bendahara-keuangan.dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#permohonan" aria-expanded="false"
                aria-controls="permohonan">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="permohonan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href=""> Permohonan SPD </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""> Permohonan Belanja </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#distribusi" aria-expanded="false"
                aria-controls="distribusi">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Distribusi Uang Muka</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="distribusi">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href=""> Perjalanan Dinas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bendahara-keuangan.disposisi-belanja.index') }}"> Belanja </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#arsip" aria-expanded="false"
                aria-controls="arsip">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Arsip Surat</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="arsip">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href=""> Perjalanan Dinas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bendahara-keuangan.surat-non-pbj.arsip-index') }}"> SPJ </a>
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
                        <a class="nav-link" href=""> Surat Perjalan Dinas </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""> Surat PertanggungJawaban </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#belanja" aria-expanded="false"
                aria-controls="belanja">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan Belanja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="belanja">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bendahara-keuangan.surat-non-pbj.index') }}"> Non PBJ Surat </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bendahara-keuangan.pengajuan-form-non-pbj.index') }}"> Non PBJ Formulir </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bendahara-keuangan.pengajuan-pbj.index') }}"> PBJ </a>
                    </li>
                </ul>
            </div>
        </li>
        {{--  <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('bendahara-keuangan.permohonan-spd.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Permohonan SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('bendahara-keuangan.spd.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Form Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Surat Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('bendahara-keuangan.arsip-spd-spj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Arsip SPD</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('bendahara-keuangan.arsip-form-non-pbj.index') }}">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Arsip Form Non PBJ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="">
                <i class="mdi mdi-folder  pr-2 icon-large"></i>
                <span class="menu-title">Arsip Surat Non PBJ</span>
            </a>
        </li>  --}}
    </ul>
</nav>
