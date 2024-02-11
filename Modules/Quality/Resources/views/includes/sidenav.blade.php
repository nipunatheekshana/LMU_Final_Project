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
                            <a @if (request()->segment(2) == 'qualityCheckParameter_list') class="active" @elseif (request()->segment(2) == 'qualityCheckParameter_configure')  class="active"@endif
                                href="/quality/qualityCheckParameter_list">{{ __('Qcheck Parameters') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityCheckingRules_list') class="active" @elseif (request()->segment(2) == 'qualityCheckingRules_configure')  class="active"@endif
                                href="/quality/qualityCheckingRules_list">{{ __('Quality Checking Rules') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityRuleParameters_list') class="active" @elseif (request()->segment(2) == 'qualityRuleParameters_configure')  class="active"@endif
                                href="/quality/qualityRuleParameters_list">{{ __('Quality Rule Parameters') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityControl_configure')  class="active"@endif
                                href="/quality/qualityControl_configure">{{ __('Quality Control') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'labTestTypes_list') class="active" @elseif (request()->segment(2) == 'labTestTypes_configure')  class="active" @endif
                                href="/quality/labTestTypes_list">{{ __('Lab Test Types') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityLabTests')  class="active"@endif
                                href="/quality/qualitylabtests">{{ __('Quality Lab Tests') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
