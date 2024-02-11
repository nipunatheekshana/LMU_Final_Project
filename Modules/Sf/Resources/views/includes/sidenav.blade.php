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
                        <span>{{ __('MISL') }}</span>
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
                        <span>{{ __('Masters') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'fishGradesMaster_list') class="active" @elseif (request()->segment(2) == 'fishGradesMaster_Configure') class="active"  @endif
                                href="/sf/fishGradesMaster_list">{{ __('Fish Grades') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'presentationTypeMaster_list') class="active" @elseif (request()->segment(2) == 'presentationTypeMaster_Configure') class="active"  @endif
                                href="/sf/presentationTypeMaster_list">{{ __('presentation Type') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'cuttingtypeMaster_list') class="active" @elseif (request()->segment(2) == 'cuttingtypeMaster_configure') class="active"  @endif
                                href="/sf/cuttingtypeMaster_list">{{ __('cutting type') }}</a>
                        </li>


                        <li>
                            <a @if (request()->segment(2) == 'catchAreaMaster_list') class="active" @elseif (request()->segment(2) == 'catchAreaMaster_configure') class="active"  @endif
                                href="/sf/catchAreaMaster_list">{{ __('Catch Area') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'catchMethodMaster_list') class="active" @elseif (request()->segment(2) == 'catchMethodMaster_configure') class="active"  @endif
                                href="/sf/catchMethodMaster_list">{{ __('Catch Method') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'landingsiteMaster_list') class="active" @elseif (request()->segment(2) == 'landingsiteMaster_configure') class="active"  @endif
                                href="/sf/landingsiteMaster_list">{{ __('landing site') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'fishSpeciesMaster_list') class="active" @elseif (request()->segment(2) == 'fishSpeciesMaster_configure') class="active"  @endif
                                href="/sf/fishSpeciesMaster_list">{{ __('Fish Species') }}</a>
                        </li>

                        <li>
                            <a @if (request()->segment(2) == 'boatCategory_list') class="active" @elseif (request()->segment(2) == 'boatCategory_configure') class="active" @endif
                                href="/sf/boatCategory_list">{{ __('Boat Category') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'boat_list') class="active" @elseif (request()->segment(2) == 'boat_configure') class="active" @endif
                                href="/sf/boat_list">{{ __('Boat') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'fishReceiveParamSettings_list') class="active" @elseif (request()->segment(2) == 'fishReceiveParamSettings_configure') class="active" @endif
                                href="/sf/fishReceiveParamSettings_list">{{ __('Fish Receive Param Settings') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'boatHoldType_list') class="active" @elseif (request()->segment(2) == 'boatHoldType_configure') class="active" @endif
                                href="/sf/boatHoldType_list">{{ __('Boat Hold Type') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'companyBoats_list') class="active" @elseif (request()->segment(2) == 'companyBoats_configure') class="active" @endif
                                href="/sf/companyBoats_list">{{ __('Company Boats') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'fishCoolingMethod_list') class="active" @elseif (request()->segment(2) == 'fishCoolingMethod_configure') class="active" @endif
                                href="/sf/fishCoolingMethod_list">{{ __('Fish Cooling Method') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'fishSize_list') class="active"@elseif (request()->segment(2) == 'fishSize_configure') class="active" @endif
                                href="/sf/fishSize_list">{{ __('Fish Size') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'seaFoodRawMaterial_list') class="active"@elseif (request()->segment(2) == 'seaFoodRawMaterial_configure') class="active" @endif
                                href="/sf/seaFoodRawMaterial_list">{{ __('SeaFood Raw Material') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'productQuality_list') class="active"@elseif (request()->segment(2) == 'productQuality_configure') class="active" @endif
                                href="/sf/productQuality_list">{{ __('Product Quality') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'manufacturingItem_list') class="active"@elseif (request()->segment(2) == 'manufacturingItem_configure') class="active" @endif
                                href="/sf/manufacturingItem_list">{{ __('Manufacturing Item') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'fishrejectreason_list') class="active" @elseif (request()->segment(2) == 'fishrejectreason_configure') class="active"  @endif
                                href="/sf/fishrejectreason_list">{{ __('Fish Reject Reasons') }}</a>
                        </li>



                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
