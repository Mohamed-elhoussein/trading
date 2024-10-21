<div class="app-menu navbar-menu">
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
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">

                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->





                <li class="nav-item">
                    <a class="nav-link menu-link   @if(request()->is('*/dashboard/period/global/*')) active
                        @else
                        collapsed
                        @endif" href="#range" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="range">
                        <i class='bx bxs-calendar'></i> <span data-key="t-landing">Period Global
                        </span>
                    </a>
                    <div class="collapse menu-dropdown @if(request()->is('*/dashboard/period/global/*')) show
                        @else
                        collapsed
                        @endif" id="range">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('period.global.index') }}" class="nav-link @if(request()->is('*/dashboard/period/global/index')) active
                                    @endif"
                                    data-key="t-nft-landing">List</a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('period.global.create') }}" class="nav-link  @if(request()->is('*/dashboard/period/global/create')) active
                                    @endif"
                                    data-key="t-one-page">Create</a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('period.global.archived') }}" class="nav-link  @if(request()->is('*/dashboard/period/global/archiveList')) active
                                    @endif"
                                    data-key="t-one-page">Archived</a>
                            </li>


                        </ul>
                    </div>
                </li>





                <li class="nav-item">
                    <a class="nav-link menu-link   @if(request()->is('*/dashboard/programs/*')) active
                        @else
                        collapsed
                        @endif" href="#program" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="program">
                        <i class='bx bxs-data'></i><span data-key="t-landing">Programs
                        </span>
                    </a>
                    <div class="collapse menu-dropdown @if(request()->is('*/dashboard/programs/*')) show
                        @else
                        collapsed
                        @endif" id="program">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('programs.index') }}" class="nav-link @if(request()->is('*/dashboard/programs/index')) active
                                    @endif"
                                    data-key="t-nft-landing">List</a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('programs.create') }}" class="nav-link  @if(request()->is('*/dashboard/programs/create')) active
                                    @endif"
                                    data-key="t-one-page">Create</a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('programs.archived') }}" class="nav-link  @if(request()->is('*/dashboard/programs/archiveList')) active
                                    @endif"
                                    data-key="t-one-page">Archived</a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>


                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/interest/calculator/index')) active
                        @else

                        @endif" href="{{ route('interest.calculator.index') }}">
                        <i class='bx bxs-calculator'></i><span data-key="t-widgets">Interest Calculator</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/programs/types/list')) active
                        @else

                        @endif" href="{{ route('programs.types.index') }}">
                        <i class='bx bx-list-ol'></i><span data-key="t-widgets">Programs types</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/programs/fields/list')) active
                        @else

                        @endif" href="{{ route('fields.index') }}">
                        <i class='bx bx-list-ol'></i><span data-key="t-widgets">Fields</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/currency/list')) active
                        @else

                        @endif" href="{{ route('currency.index') }}">
                        <i class='bx bx-dollar'></i><span data-key="t-widgets">currency</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/country/list')) active
                        @else

                        @endif" href="{{ route('country.index') }}">
                        <i class='bx bx-world'></i><span data-key="t-widgets">Countries</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/orders/list')) active
                        @else

                        @endif" href="{{ route('orders.index') }}">
                        <i class='bx bx-cart'></i><span data-key="t-widgets">Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/Customer/list')) active
                        @else

                        @endif" href="{{ route('customer.index') }}">
                        <i class='bx bxs-user-rectangle'></i><span data-key="t-widgets">Customers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/User/list')) active
                        @else

                        @endif" href="{{ route('user.index') }}">
                        <i class='bx bxs-user-rectangle'></i><span data-key="t-widgets">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/orders/month/installment')) active
                        @else

                        @endif" href="{{ route('get.month.installment') }}">
                        <i class='bx bx-calendar-star'></i><span data-key="t-widgets">Installments This Month</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if(request()->is('*/dashboard/orders/installmen/History')) active
                        @else

                        @endif" href="{{ route('get.installment.history') }}">
                        <i class='bx bx-history' ></i></i><span data-key="t-widgets">Installments History</span>
                    </a>
                </li>







            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
