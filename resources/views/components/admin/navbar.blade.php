<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        @if (auth()->user()->getRoleNames()->first() === 'Admin')
            {{ auth()->user()->name }}
        @else
            {{ auth()->user()->karyawan->nama }}
        @endif
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ auth()->user()->avatar() }}" alt="profile" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    @if (auth()->user()->getRoleNames()->first() === 'Admin')
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Pengadministrasi Umum')
                        <a class="dropdown-item" href="{{ route('pengadministrasi-umum.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Kepala Bagian')
                        <a class="dropdown-item" href="{{ route('kabag.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Karyawan')
                        <a class="dropdown-item" href="{{ route('karyawan.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Bendahara Keuangan')
                        <a class="dropdown-item" href="{{ route('bendahara-keuangan.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Pengelola Keuangan')
                        <a class="dropdown-item" href="{{ route('pengelola-keuangan.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Pejabat Pembuat Komitmen')
                        <a class="dropdown-item" href="{{ route('ppk.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Tim PPK')
                        <a class="dropdown-item" href="{{ route('timppk.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Wakil Direktur II')
                        <a class="dropdown-item" href="{{ route('wakil-direktur-ii.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Wakil Direktur I')
                        <a class="dropdown-item" href="{{ route('wakil-direktur-i.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @elseif(auth()->user()->getRoleNames()->first() === 'Supir')
                        <a class="dropdown-item" href="{{ route('supir.profile') }}">
                            <i class="ti-user text-primary"></i>
                            Edit Profile
                        </a>
                    @endif
                    <a class="dropdown-item" onclick="document.getElementById('formLogout').submit()">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                    <form action="{{ route('logout') }}" id="formLogout" method="post">
                        @csrf

                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
