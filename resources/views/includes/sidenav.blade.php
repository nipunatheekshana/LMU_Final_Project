<div class="navigation">
    <div class="navigation-header">
        <span>Navigation</span>
        <a href="#">
            <i class="ti-close"></i>
        </a>
    </div>
    <div class="navigation-menu-body">


        @if (Auth::user()->user_level == 'MISLuser')
            <ul>
                <li>
                    <a @if (request()->segment(1) == 'dashbord-Misl') class="active" @endif href="/dashbord-Misl">
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
                        <span>{{ __('MISL Settings') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(1) == 'create_Misl-Users') class="active" @endif
                                href="create_Misl-Users">{{ __('Create Users') }}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="home"></i>
                        </span>
                        <span>{{ __('Parent Company') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(1) == 'edit_parent-company') class="active" @endif
                                href="edit_parent-company">{{ __('Edit Company') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(1) == 'createParentCompanyUser') class="active" @endif
                                href="createParentCompanyUser">{{ __('Create Users') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(1) == 'product-detail') class="active" @endif href="#"></a>
                        </li>
                    </ul>
                </li>
            </ul>
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
                        <span>{{ __('Child Company') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(1) == 'create_childCompany') class="active" @endif
                                href="create_childCompany">{{ __('Create Child Company') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(1) == 'childCompany_List') class="active" @endif
                                href="childCompany_List">{{ __('Child Company list') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(1) == 'createChildCompanyUsers') class="active" @endif
                                href="createChildCompanyUsers">{{ __('Child Company users') }}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="settings"></i>
                        </span>
                        <span>{{ __('Configurations') }}</span>
                    </a>
                    <ul>
                        {{-- <li>
                            <a @if (request()->segment(1) == 'address_list') class="active"  @elseif (request()->segment(1) == 'addres_configure') class="active" @endif
                                href="address_list">{{ __('Address') }}</a>
                        </li> --}}


                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
