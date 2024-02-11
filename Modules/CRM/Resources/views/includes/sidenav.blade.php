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
                        <span>{{ __('Masters') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'address_list') class="active" @elseif  (request()->segment(2) == 'addres_configure') class="active" @endif
                                href="/crm/address_list">{{ __('Address') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'contact_list') class="active" @elseif  (request()->segment(2) == 'contact_configure') class="active" @endif
                                href="/crm/contact_list">{{ __('Contact') }}</a>
                        </li>


                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
