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
                        <span>{{ __('System Settings') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'email_settings') class="active" @endif
                                href="/settings/email_settings">{{ __('Email settings') }}</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="box"></i>
                        </span>
                        <span>{{ __('Company Setting') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'create_Company') class="active" @endif
                                href="/settings/create_Company">{{ __('Create company') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'Company_List') class="active" @endif
                                href="/settings/Company_List">{{ __('company list') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'createCompanyUsers') class="active" @endif
                                href="/settings/createCompanyUsers">{{ __('Create Company Users') }}</a>
                        </li>

                    </ul>
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
                            <a @if (request()->segment(2) == 'activity_list') class="active"@elseif (request()->segment(2) == 'activity_configure') class="active" @endif
                                href="/settings/activity_list">{{ __('Activity') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'Process_list') class="active"@elseif (request()->segment(2) == 'Process_configure') class="active" @endif
                                href="/settings/Process_list">{{ __('process') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'processActivity_list') class="active"@elseif (request()->segment(2) == 'processActivity_configure') class="active" @endif
                                href="/settings/processActivity_list">{{ __('process Activity') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'workstation_list') class="active"@elseif (request()->segment(2) == 'workstation_configure') class="active" @endif
                                href="/settings/workstation_list">{{ __('Workstation') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'processWorkstation_list') class="active"@elseif (request()->segment(2) == 'processWorkstation_configure') class="active" @endif
                                href="/settings/processWorkstation_list">{{ __('Process Workstation') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'processActivityEmployeeFilters_list') class="active"@elseif (request()->segment(2) == 'processActivityEmployeeFilters_configure') class="active" @endif
                                href="/settings/processActivityEmployeeFilters_list">{{ __('Process Activity Employee Filters') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'transportVehicleTypes_list') class="active"@elseif (request()->segment(2) == 'transportVehicleTypes_configure') class="active" @endif
                                href="/settings/transportVehicleTypes_list">{{ __('Transport Vehicle Types') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'namingSeries_list') class="active"@elseif (request()->segment(2) == 'namingSeries_configure') class="active" @endif
                                href="/settings/namingSeries_list">{{ __('Naming Series') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'barcodeTypes_list') class="active"@elseif (request()->segment(2) == 'barcodeTypes_configure') class="active" @endif
                                href="/settings/barcodeTypes_list">{{ __('Barcode Types') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'dataType_list') class="active"@elseif (request()->segment(2) == 'dataType_configure') class="active" @endif
                                href="/settings/dataType_list">{{ __('Data Types') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'dataTypeFormat_list') class="active"@elseif (request()->segment(2) == 'dataTypeFormat_configure') class="active" @endif
                                href="/settings/dataTypeFormat_list">{{ __('Data Type Formats') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'querylog') class="active" @endif
                                href="/settings/querylog">{{ __('Application Log') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'vehicle_list') class="active"@elseif (request()->segment(2) == 'vehicle_configure') class="active" @endif
                                href="/settings/vehicle_list">{{ __('Vehicle') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'driver_list') class="active"@elseif (request()->segment(2) == 'driver_configure') class="active" @endif
                                href="/settings/driver_list">{{ __('Drivers') }}</a>
                        </li>

                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
