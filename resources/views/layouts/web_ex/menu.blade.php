<div class=" navbar-menu" style="overflow-x: auto;">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('web/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('web/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('web/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('web/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard.index') }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">{{ __('Dashboards') }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">

                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/stocks')) active
                        @else

                        @endif" href="{{ route('stocks.index') }}">
                        <i class='bx bx-cart'></i><span data-key="t-widgets">{{ __('Stocks') }}</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/country/list')) active
                        @else

                        @endif" href="{{ route('country.index') }}">
                        <i class='bx bx-world'></i><span data-key="t-widgets">{{ __('Countries') }}</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/orders/list')) active
                        @else

                        @endif" href="{{ route('orders.index') }}">
                        <i class='bx bx-cart'></i><span data-key="t-widgets">{{ __('Orders') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/wallet')) active
                        @else

                        @endif" href="{{ route('wallet.index') }}">
                        <i class='bx bx-cart'></i><span data-key="t-widgets">{{ __('Wallet') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/setting')) active
                        @else

                        @endif" href="{{ route('setting.index') }}">
                        <i class='bx bx-cart'></i><span data-key="t-widgets">{{ __('Setting') }}</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/Customer/list')) active
                        @else

                        @endif" href="{{ route('customer.index') }}">
                        <i class='bx bxs-user-rectangle'></i><span data-key="t-widgets">{{ __('Customers') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/User/list')) active
                        @else

                        @endif" href="{{ route('user.index') }}">
                        <i class='bx bxs-user-rectangle'></i><span data-key="t-widgets">{{ __('Users') }}</span>
                    </a>
                </li>
    






            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
