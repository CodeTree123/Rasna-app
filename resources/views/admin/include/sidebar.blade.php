        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
                <div class="sidebar-brand-icon ">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                    <div id="my_logo">

                        <img src="{{getImage(getFilePath('logoIcon') .'/logo.png')}}" width="50px" height="50px" id="my_logo_image">

                    </div>
                </div>
                <div class="sidebar-brand-text mx-3"> Rasna <sup><i class="fas fa-laugh-wink"></i></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Create User
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.account.index') }}">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    <span>@lang('Create Account')</span>
                </a>
            </li>

            <div class="sidebar-heading">
                Product
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.account.page.product') }}">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    <span>@lang('Add Product')</span>
                </a>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                User
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed " href="javascript:void(0)" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Manage User</span>
                    @if($bannedUsersCount > 0 || $emailUnverifiedUsersCount > 0 || $mobileUnverifiedUsersCount > 0 || $kycUnverifiedUsersCount > 0 || $kycPendingUsersCount > 0)
                    <span class="menu-badge pill bg-danger ms-auto">
                        <i class="fa fa-exclamation"></i>
                    </span>
                    @endif
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu:</h6>
                        <a class="collapse-item" href="{{route('admin.users.active')}}"><i class="menu-icon fa fa-dot-circle">Active User</i></a>
                        <a class="collapse-item" href="{{route('admin.users.banned')}}"><i class="menu-icon fa fa-dot-circle">Banned User</i>
                            @if($bannedUsersCount)
                            <span class="bg-danger">{{$bannedUsersCount}}</span>
                            @endif</a>
                        <a class="collapse-item" href="{{route('admin.users.email.unverified')}}"><i class="menu-icon fa fa-dot-circle">Email Unverified</i>
                            @if($emailUnverifiedUsersCount)
                            <span class="bg-danger">{{$emailUnverifiedUsersCount}}</span>
                            @endif</a>
                        <a class="collapse-item" href="{{route('admin.users.mobile.unverified')}}"><i class="menu-icon fa fa-dot-circle">Mobile Unverified</i>
                            @if($mobileUnverifiedUsersCount)
                            <span class="bg-danger">{{$mobileUnverifiedUsersCount}}</span>
                            @endif</a>
                        <a class="collapse-item" href="{{route('admin.users.kyc.unverified')}}"><i class="menu-icon fa fa-dot-circle">KYC Unverified</i>
                            @if($kycUnverifiedUsersCount)
                            <span class="bg-danger">{{$kycUnverifiedUsersCount}}</span>
                            @endif</a>
                        <a class="collapse-item" href="{{route('admin.users.with.balance')}}"><i class="menu-icon fa fa-dot-circle">With Balance</i></a>
                        <a class="collapse-item" href="{{route('admin.users.all')}}"><i class="menu-icon fa fa-dot-circle">All User</i></a>
                        <a class="collapse-item" href="{{route('admin.users.notification.all')}}"><i class="menu-icon fa fa-dot-circle">Notification to all</i></a>
                    </div>
                </div>
            </li>

            <div class="sidebar-heading">
                Report
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.report.index') }}">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    <span>@lang('See Report')</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Settings
            </div>

            <!-- Nav Item - General Setting -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin.setting.index')}}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>@lang('General Setting')</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin.setting.logo.icon')}}">
                    <i class="fas fa-images"></i>
                    <span>@lang('Logo & Favicon')</span>
                </a>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->