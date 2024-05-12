<nav class="sidebar sidebar-offcanvas" style="width: 300px" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('supir.dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
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
    </ul>
</nav>
