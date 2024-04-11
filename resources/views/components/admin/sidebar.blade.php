<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('dashboard') }}">
                <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @canany(['Surat Pertanggung Jawaban Index', 'SPJ Form Non PBJ Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#surat_pertanggungjawaban" aria-expanded="false"
                    aria-controls="surat_pertanggungjawaban">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">SPJ</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="surat_pertanggungjawaban">
                    <ul class="nav flex-column sub-menu">
                        @can('Surat Pertanggung Jawaban Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('surat-pertanggung-jawaban.index') }}"> PBJ </a>
                            </li>
                        @endcan
                        @can('SPJ Form Non PBJ Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('spj-form-non-pbj.index') }}">Form Non PBJ
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @can('Surat Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('surat.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Surat</span>
                </a>
            </li>
        @endcan
        @can('Permohonan Surat Perjalanan Dinas Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('permohonan-surat-perjalanan-dinas.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Permohonan SPD</span>
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
        @canany(['Uang Muka Index', 'Uang Muka Form Non PBJ Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#uang_muka" aria-expanded="false"
                    aria-controls="uang_muka">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Uang Muka</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="uang_muka">
                    <ul class="nav flex-column sub-menu">
                        @can('Uang Muka Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('uang-muka.index') }}"> PBJ </a>
                            </li>
                        @endcan
                        @can('Uang Muka Form Non PBJ Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan-form-non-pbj.uang-muka.index') }}">Form Non PBJ
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @can('TTE Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('tte.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Upload TTE</span>
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
        @can('Pengajuan PBJ Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('pengajuan-pbj.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Pengajuan PBJ</span>
                </a>
            </li>
        @endcan
        @canany(['Pengajuan PBJ Index', 'Pengajuan Form Non PBJ Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#pengajuan" aria-expanded="false"
                    aria-controls="pengajuan">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Pengajuan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="pengajuan">
                    <ul class="nav flex-column sub-menu">
                        @can('Pengajuan PBJ Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan-pbj.index') }}"> PBJ </a>
                            </li>
                        @endcan
                        @can('Pengajuan Form Non PBJ Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengajuan-form-non-pbj.index') }}"> Form Non PBJ </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @can('Proses PBJ Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('proses-pbj.index') }}">
                    <i class="mdi mdi-folder  pr-2 icon-large"></i>
                    <span class="menu-title">Proses PBJ</span>
                </a>
            </li>
        @endcan
        @canany(['Role Index', 'Permission Index', 'User Index', 'Jabatan Index', 'Golongan Index'])
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
        @endcanany
    </ul>
</nav>
