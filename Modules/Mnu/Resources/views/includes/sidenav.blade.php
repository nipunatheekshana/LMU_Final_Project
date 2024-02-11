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
                            <a @if (request()->segment(2) == 'manufacturingSetting_list') class="active" @elseif (request()->segment(2) == 'manufacturingSetting_configure')  class="active"@endif
                                href="/mnu/manufacturingSetting_list">{{ __('Manufacturing Setting') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'BOMItem_list') class="active" @elseif (request()->segment(2) == 'BOMItem_configure')  class="active"@endif
                                href="/mnu/BOMItem_list">{{ __('BOM Item') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'customerItem_list') class="active" @elseif (request()->segment(2) == 'customerItem_configure')  class="active"@endif
                                href="/mnu/customerItem_list">{{ __('Customer Item') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'productionPlan_configure')  class="active" @elseif (request()->segment(2) == 'NewRequirements_configure')  class="active"@endif
                                href="/mnu/productionPlan_configure">{{ __('Production Plan') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'planingDetail_configure')  class="active" @endif
                                href="/mnu/planingDetail_configure">{{ __('Planing Detail') }}</a>
                        </li>

                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
