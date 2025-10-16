<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/long_pln.png') }}" alt="navbar brand" class="navbar-brand"
                    height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item @if(Route::is('dashboard')) active @endif">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item @if(Route::is('admin.index')) active @endif">
                    <a href="{{ route('admin.index') }}">
                        <i class="fas fa-users"></i>
                        <p>Admin</p>
                    </a>
                </li>
                <li
                    class="nav-item @if(Route::is('keypoint') || Route::is('penyulangan') || Route::is('absen')) active @endif">
                    <a data-bs-toggle="collapse" href="#forms"
                        class="@if(Route::is('keypoint') || Route::is('penyulangan') || Route::is('absen')) show @endif">
                        <i class="icon-notebook"></i>
                        <p>Forms</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if(Route::is('keypoint.create') || Route::is('penyulangan.create') || Route::is('absen')) show @endif"
                        id="forms">
                        <ul class="nav nav-collapse">
                            <li class="@if(Route::is('keypoint.create')) active @endif">
                                <a href="{{ route('keypoint.create') }}"><span class="sub-item">Keypoint Form</span></a>
                            </li>
                            <li class="@if(Route::is('penyulangan.create')) active @endif">
                                <a href="{{ route('penyulangan.create') }}"><span
                                        class="sub-item">Penyulangan</span></a>
                            </li>
                            <li class="@if(Route::is('absen')) active @endif">
                                <a href="{{ route('absen') }}"><span class="sub-item">Absen</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item @if(Route::is('data*')) active @endif">
                    <a data-bs-toggle="collapse" href="#data" class="@if(Route::is('data*')) show @endif">
                        <i class="fas fa-table"></i>
                        <p>Data</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if(Route::is('data*')) show @endif" id="data">
                        <ul class="nav nav-collapse">
                            <li class="@if(Route::is('data.keypoint')) active @endif">
                                <a href="{{ route('data.keypoint') }}"><span class="sub-item">Data Keypoint</span></a>
                            </li>
                            <li class="@if(Route::is('data.penyulangan')) active @endif">
                                <a href="{{ route('data.penyulangan') }}"><span class="sub-item">Data
                                        Penyulangan</span></a>
                            </li>
                            <li class="@if(Route::is('data.absen')) active @endif">
                                <a href="{{ route('data.absen') }}"><span class="sub-item">Data Rekap Absen</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#datapengusahaan" class="show">
                        <i class="icon-settings"></i>
                        <p>Data Pengusahaan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse show" id="datapengusahaan">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('gardu.index') }}"><span class="sub-item">Gardu Induk</span></a>
                            </li>
                            <li>
                                <a href="{{ route('merk.index') }}"><span class="sub-item">Merk Lbs</span></a>
                            </li>
                            <li>
                                <a href="{{ route('modem.index') }}"><span class="sub-item">Modem</span></a>
                            </li>
                            <li>
                                <a href="{{ route('sectoral.index') }}"><span class="sub-item">Sectoral</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
