<header id="page-topbar">
    <div class="navbar-header">
        <!-- LOGO -->
        <div class="navbar-brand-box d-flex align-items-left">
            <a href="#" class="logo">
                <img src="{{asset('')}}public/assets/images/logo-kwarsa1.png" alt="">
                <span style="color:#fff; font-size:22px; font-weight:bold; text-transform:none">e-PERDIN</span>
            </a>

            <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect waves-light" id="page-header-notifications-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-bell"></i>
                    <span class="badge badge-danger badge-pill" style="margin-left:-10px"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small"> View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-warning rounded-circle">
                                        <i class="mdi mdi-alert-octagon-outline"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-down-circle mr-1"></i> Load More..
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item waves-effect waves-light"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('')}}public/assets/images/users/avatar-3.jpg"
                        alt="Header Avatar">
                    <span class="d-none d-sm-inline-block ml-1">{{Auth::user()->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">
                        <span>Profile</span>
                        <span>
                            <span class="badge badge-pill badge-warning">1</span>
                        </span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                        Settings
                    </a>

                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <span>Log Out</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="bx bx-home-smile"></i>Dashboard
                        </a>
                    </li>
                    @if(Auth::user()->secondposition_id != 13 && Auth::user()->secondposition_id != 12)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('inspector')}}">
                            <i class="bx bxs-car"></i>Staff Perdin
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('userPerdin')}}">
                            <i class="bx bx-archive"></i>History Perdin
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
