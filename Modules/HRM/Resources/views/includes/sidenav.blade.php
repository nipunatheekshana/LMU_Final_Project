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
                            <a @if (request()->segment(2) == 'designation_list') class="active" @elseif  (request()->segment(2) == 'designation_configure') class="active" @endif
                                href="/hrm/designation_list">{{ __('Designation') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'employee_list') class="active" @elseif  (request()->segment(2) == 'employee_configure') class="active" @endif
                                href="/hrm/employee_list">{{ __('Employee') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'departments_list') class="active" @elseif  (request()->segment(2) == 'departments_configure') class="active" @endif
                                href="/hrm/departments_list">{{ __('Departments') }}</a>
                        </li>


                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
