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
                <li
                    class="nav-item @if(Route::is('keypoint') || Route::is('feeder-inc') || Route::is('absen')) active @endif">
                    <a data-bs-toggle="collapse" href="#forms"
                        class="@if(Route::is('keypoint') || Route::is('feeder-inc') || Route::is('absen')) show @endif">
                        <i class="icon-notebook"></i>
                        <p>Forms</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if(Route::is('keypoint') || Route::is('feeder-inc') || Route::is('absen')) show @endif"
                        id="forms">
                        <ul class="nav nav-collapse">
                            <li class="@if(Route::is('keypoint')) active @endif">
                                <a href="{{ route('keypoint') }}"><span class="sub-item">Keypoint</span></a>
                            </li>
                            <li class="@if(Route::is('feeder-inc')) active @endif">
                                <a href="{{ route('feeder-inc') }}"><span class="sub-item">Feeder & Inc</span></a>
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
                            <li class="@if(Route::is('data.feeder')) active @endif">
                                <a href="{{ route('data.feeder') }}"><span class="sub-item">Data Feeder & Inc</span></a>
                            </li>
                            <li class="@if(Route::is('data.absen')) active @endif">
                                <a href="{{ route('data.absen') }}"><span class="sub-item">Data Rekap Absen</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item @if(Route::is('datapengusahaan*')) active @endif">
                    <a data-bs-toggle="collapse" href="#datapengusahaan"
                        class="@if(Route::is('datapengusahaan*')) show @endif">
                        <i class="icon-settings"></i>
                        <p>Data Pengusahaan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if(Route::is('datapengusahaan*')) show @endif" id="datapengusahaan">
                        <ul class="nav nav-collapse">
                            <li class="@if(Route::is('datapengusahaan.gardu')) active @endif">
                                <a href="{{ route('datapengusahaan.gardu') }}"><span class="sub-item">Gardu
                                        Induk</span></a>
                            </li>
                            <li class="@if(Route::is('datapengusahaan.lbs')) active @endif">
                                <a href="{{ route('datapengusahaan.lbs') }}"><span class="sub-item">Merk Lbs</span></a>
                            </li>
                            <li class="@if(Route::is('datapengusahaan.modem')) active @endif">
                                <a href="{{ route('datapengusahaan.modem') }}"><span class="sub-item">Modem</span></a>
                            </li>
                            <li class="@if(Route::is('datapengusahaan.sectoral')) active @endif">
                                <a href="{{ route('datapengusahaan.sectoral') }}"><span
                                        class="sub-item">Sectoral</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
