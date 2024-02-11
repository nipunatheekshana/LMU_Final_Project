<div class="navigation">
    <div class="navigation-header">
        <span>Navigation</span>
        <a href="#">
            <i class="ti-close"></i>
        </a>
    </div>
    <div class="navigation-menu-body">


        @if (Auth::user()->user_level == 'MISLuser')

        @endif
        @if (Auth::user()->user_level == 'PCuser')
            <ul>
                <li>
                    <a @if (request()->segment(1) == 'dashbord-Parent') class="active" @endif href="/dashbord-Parent">
                        <span class="nav-link-icon">
                            <i data-feather="pie-chart"></i>
                        </span>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="box"></i>
                        </span>
                        <span>{{ __('Customers') }}</span>
                    </a>
                    <ul>

                        <li>
                            <a @if (request()->segment(2) == 'customerGroupMaster_list') class="active" @elseif (request()->segment(2) == 'customerGroupMaster_configure') class="active" @endif
                                href="/selling/customerGroupMaster_list">{{ __('Customer Group') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'customer_master') class="active" @elseif (request()->segment(2) == 'customer_configure') class="active" @endif
                                href="/selling/customer_master">{{ __('Customer Master') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'customerOrder_list') class="active" @elseif (request()->segment(2) == 'customerOrder_configure') class="active" @endif
                                href="/selling/customerOrder_list">{{ __('Customer Order') }}</a>
                        </li>

                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
