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
                            <a @if (request()->segment(2) == 'supplierGroup_list') class="active" @elseif  (request()->segment(2) == 'supplierGroup_configure') class="active" @endif
                                href="/buying/supplierGroup_list">{{ __('supplier Group') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'supplier_list') class="active" @elseif  (request()->segment(2) == 'supplier_configure') class="active" @endif
                                href="/buying/supplier_list">{{ __('supplier') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'supplierHoldTypes_list') class="active" @elseif  (request()->segment(2) == 'supplierHoldTypes_configure') class="active" @endif
                                href="/buying/supplierHoldTypes_list">{{ __('Supplier Hold Types') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'companySupplier_list') class="active" @elseif  (request()->segment(2) == 'companySupplier_configure') class="active" @endif
                                href="/buying/companySupplier_list">{{ __('Company Supplier') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'grnHistory_list') class="active" @elseif  (request()->segment(2) == 'grnHistory_configure') class="active" @endif
                                href="/buying/grnHistory_list">{{ __('GRN History') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'QGrn_list') class="active" @elseif  (request()->segment(2) == 'QGrn_configure') class="active" @endif
                                href="/buying/QGrn_list">{{ __('QGrn') }}</a>
                        </li>


                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
