<div class="navigation">
    <div class="navigation-header">
        <span>Navigation</span>
        <a href="#">
            <i class="ti-close"></i>
        </a>
    </div>
    <div class="navigation-menu-body">

        {{-- "MISLuser" Level Side Navigation Bar --}}

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
                                href="create_Misl-Users">{{ __('Super Admin Users') }}</a>
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

        {{-- "PCuser" Level Side Navigation Bar --}}

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
                {{-- <li>
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
                </li> --}}

                {{-- sf module side nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i class="fa fa-ship"></i>
                        </span>
                        <span>{{ __('Sea Food Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a href="#">Fish Related</a>
                            <ul>
                                <li>
                                    <a @if (request()->segment(2) == 'fishSpeciesMaster_list') class="active" @elseif (request()->segment(2) == 'fishSpeciesMaster_configure') class="active" @endif
                                        href="/sf/fishSpeciesMaster_list">{{ __('Fish Species') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'fishGradesMaster_list') class="active" @elseif (request()->segment(2) == 'fishGradesMaster_Configure') class="active" @endif
                                        href="/sf/fishGradesMaster_list">{{ __('Fish Grades') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'presentationTypeMaster_list') class="active" @elseif (request()->segment(2) == 'presentationTypeMaster_Configure') class="active" @endif
                                        href="/sf/presentationTypeMaster_list">{{ __('Presentation Type') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'cuttingtypeMaster_list') class="active" @elseif (request()->segment(2) == 'cuttingtypeMaster_configure') class="active" @endif
                                        href="/sf/cuttingtypeMaster_list">{{ __('Cutting Type') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'fishSize_list') class="active"@elseif (request()->segment(2) == 'fishSize_configure') class="active" @endif
                                        href="/sf/fishSize_list">{{ __('Fish Size') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'fishReceiveParamSettings_list') class="active" @elseif (request()->segment(2) == 'fishReceiveParamSettings_configure') class="active" @endif
                                        href="/sf/fishReceiveParamSettings_list">{{ __('Fish Receive Parameter Settings') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'fishrejectreason_list') class="active" @elseif (request()->segment(2) == 'fishrejectreason_configure') class="active" @endif
                                        href="/sf/fishrejectreason_list">{{ __('Fish Reject Reasons') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Boat Related</a>
                            <ul>
                                <li>
                                    <a @if (request()->segment(2) == 'catchAreaMaster_list') class="active" @elseif (request()->segment(2) == 'catchAreaMaster_configure') class="active" @endif
                                        href="/sf/catchAreaMaster_list">{{ __('Catch Area') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'catchMethodMaster_list') class="active" @elseif (request()->segment(2) == 'catchMethodMaster_configure') class="active" @endif
                                        href="/sf/catchMethodMaster_list">{{ __('Catch Method') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'landingsiteMaster_list') class="active" @elseif (request()->segment(2) == 'landingsiteMaster_configure') class="active" @endif
                                        href="/sf/landingsiteMaster_list">{{ __('Landing Site') }}</a>
                                </li>

                                <li>
                                    <a @if (request()->segment(2) == 'boatCategory_list') class="active" @elseif (request()->segment(2) == 'boatCategory_configure') class="active" @endif
                                        href="/sf/boatCategory_list">{{ __('Boat Category') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'boat_list') class="active" @elseif (request()->segment(2) == 'boat_configure') class="active" @endif
                                        href="/sf/boat_list">{{ __('Boats') }}</a>
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
                            </ul>
                        </li>
                        <li>
                            <a href="#">Product Related</a>
                            <ul>
                                <li>
                                    <a @if (request()->segment(2) == 'seaFoodRawMaterial_list') class="active"@elseif (request()->segment(2) == 'seaFoodRawMaterial_configure') class="active" @endif
                                        href="/sf/seaFoodRawMaterial_list">{{ __('Sea Food Raw Material') }}</a>
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
                                    <a @if (request()->segment(2) == 'byproductItem_list') class="active"@elseif (request()->segment(2) == 'byproductItem_configure') class="active" @endif
                                        href="/sf/byproductItem_list">{{ __('By-Product Items') }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                {{-- quality module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="list"></i>
                        </span>
                        <span>{{ __('Quality Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'qualityCheckParameter_list') class="active" @elseif (request()->segment(2) == 'qualityCheckParameter_configure')  class="active" @endif
                                href="/quality/qualityCheckParameter_list">{{ __('Quality Check Parameters') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityCheckingRules_list') class="active" @elseif (request()->segment(2) == 'qualityCheckingRules_configure')  class="active" @endif
                                href="/quality/qualityCheckingRules_list">{{ __('Quality Check Rules') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityRuleParameters_list') class="active" @elseif (request()->segment(2) == 'qualityRuleParameters_configure')  class="active" @endif
                                href="/quality/qualityRuleParameters_list">{{ __('Quality Rule Parameters') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualityControl_configure') class="active" @endif
                                href="/quality/qualityControl_configure">{{ __('Quality Control') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'labTestTypes_list') class="active" @elseif (request()->segment(2) == 'labTestTypes_configure')  class="active" @endif
                                href="/quality/labTestTypes_list">{{ __('Lab Test Types') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'qualitylabtests') class="active" @endif
                                href="/quality/qualitylabtests">{{ __('Lab Test') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- inventory module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="archive"></i>
                        </span>
                        <span>{{ __('Inventory Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'productGroups_list') class="active" @endif
                                href="/inventory/productGroups_list">{{ __('Product Groups') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'uom_list') class="active"@elseif (request()->segment(2) == 'uom_configure') class="active" @endif
                                href="/inventory/uom_list">{{ __('Unit Of Measurement (UOM)') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'hsCode_list') class="active"@elseif (request()->segment(2) == 'hsCode_configure') class="active" @endif
                                href="/inventory/hsCode_list">{{ __('HS Code') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'manufacturer_list') class="active"@elseif (request()->segment(2) == 'manufacturer_configure') class="active" @endif
                                href="/inventory/manufacturer_list">{{ __('Manufacturers') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'brand_list') class="active"@elseif (request()->segment(2) == 'brand_configure') class="active" @endif
                                href="/inventory/brand_list">{{ __('Brands') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'Item_list') class="active"@elseif (request()->segment(2) == 'Item_configure') class="active" @endif
                                href="/inventory/Item_list">{{ __('Item') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'ItemAlternative_list') class="active"@elseif (request()->segment(2) == 'itemAlternative_configure') class="active" @endif
                                href="/inventory/ItemAlternative_list">{{ __('Item Alternative') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'UOMConversionFactors_list') class="active"@elseif (request()->segment(2) == 'UOMConversionFactors_configure') class="active" @endif
                                href="/inventory/UOMConversionFactors_list">{{ __('UOM Conversion Factors') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'delivery_list') class="active"@elseif (request()->segment(2) == 'deliveryNote_configure') class="active" @endif
                                href="/inventory/delivery_list">{{ __('Delivery Note') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'warehouseType_list') class="active"@elseif (request()->segment(2) == 'warehouseType_configure') class="active" @endif
                                href="/inventory/warehouseType_list">{{ __('Warehouse Type') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'warehouse_list') class="active"@elseif (request()->segment(2) == 'warehouse_configure') class="active" @endif
                                href="/inventory/warehouse_list">{{ __('Warehouse') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- buying module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="dollar-sign"></i>
                        </span>
                        <span>{{ __('Buying Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'supplierGroup_list') class="active" @elseif  (request()->segment(2) == 'supplierGroup_configure') class="active" @endif
                                href="/buying/supplierGroup_list">{{ __('Supplier Group') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'supplier_list') class="active" @elseif  (request()->segment(2) == 'supplier_configure') class="active" @endif
                                href="/buying/supplier_list">{{ __('Supplier') }}</a>
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
                            <a href="#">Reports</a>
                            <ul>
                                <li>
                                    <a @if (request()->segment(2) == 'purchaseAnalytics') class="active" @endif
                                        href="/buying/purchaseAnalytics">{{ __('Purchase Analytics') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'monthlyPurchaseSummary') class="active" @endif
                                        href="/buying/monthlyPurchaseSummary">{{ __('Monthly Purchase Summary') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'periodicPurchaseSummary') class="active" @endif
                                        href="/buying/periodicPurchaseSummary">{{ __('Periodic Purchase Summary') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'QGrn_list') class="active" @elseif  (request()->segment(2) == 'QGrn_configure') class="active" @endif
                                href="/buying/QGrn_list">{{ __('QGrn') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- crm module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="box"></i>
                        </span>
                        <span>{{ __('CRM Module') }}</span>
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

                {{-- HRM module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="users"></i>
                        </span>
                        <span>{{ __('HRM Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'designation_list') class="active" @elseif  (request()->segment(2) == 'designation_configure') class="active" @endif
                                href="/hrm/designation_list">{{ __('Designation') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'employee_list') class="active" @elseif  (request()->segment(2) == 'employee_configure') class="active" @endif
                                href="/hrm/employee_list">{{ __('Employees') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'departments_list') class="active" @elseif  (request()->segment(2) == 'departments_configure') class="active" @endif
                                href="/hrm/departments_list">{{ __('Departments') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Selling module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="box"></i>
                        </span>
                        <span>{{ __('Selling Module') }}</span>
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
                            <a @if (request()->segment(2) == 'notifyparty_list') class="active" @elseif (request()->segment(2) == 'notifyparty_configure') class="active" @endif
                                href="/selling/notifyparty_list">{{ __('Notify Party') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'customerOrder_list') class="active" @elseif (request()->segment(2) == 'customerOrder_configure') class="active" @endif
                                href="/selling/customerOrder_list">{{ __('Customer Order') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'salesinvoice_list') class="active" @elseif (request()->segment(2) == 'salesinvoice_configure') class="active" @endif
                                href="/selling/salesinvoice_list">{{ __('Sales Invoice') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- settings module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="settings"></i>
                        </span>
                        <span>{{ __('Settings Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'email_settings') class="active" @endif
                                href="/settings/email_settings">{{ __('E-Mail Settings') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'Company_List') class="active"@elseif (request()->segment(2) == 'create_Company') class="active" @endif
                                href="/settings/Company_List">{{ __('Company List') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'createCompanyUsers') class="active" @endif
                                href="/settings/createCompanyUsers">{{ __('Create Company Users') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'activity_list') class="active"@elseif (request()->segment(2) == 'activity_configure') class="active" @endif
                                href="/settings/activity_list">{{ __('Activity') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'Process_list') class="active"@elseif (request()->segment(2) == 'Process_configure') class="active" @endif
                                href="/settings/Process_list">{{ __('Process') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'processActivity_list') class="active"@elseif (request()->segment(2) == 'processActivity_configure') class="active" @endif
                                href="/settings/processActivity_list">{{ __('Process Activity') }}</a>
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
                            <a @if (request()->segment(2) == 'printer_list') class="active"@elseif (request()->segment(2) == 'printer_configure') class="active" @endif
                                href="/settings/printer_list">{{ __('Printers') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'report_list') class="active"@elseif (request()->segment(2) == 'report_configure') class="active" @endif
                                href="/settings/report_list">{{ __('Reports') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'term_list') class="active"@elseif (request()->segment(2) == 'term_configure') class="active" @endif
                                href="/settings/term_list">{{ __('Terms') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'vehicle_list') class="active"@elseif (request()->segment(2) == 'vehicle_configure') class="active" @endif
                                href="/settings/vehicle_list">{{ __('Vehicle') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'driver_list') class="active"@elseif (request()->segment(2) == 'driver_configure') class="active" @endif
                                href="/settings/driver_list">{{ __('Drivers') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'querylog') class="active" @endif
                                href="/settings/querylog">{{ __('Application Log') }}</a>
                        </li>

                    </ul>
                </li>

                {{-- Assets module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="codesandbox"></i>
                        </span>
                        <span>{{ __('Assets Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'assetCategory_list') class="active" @elseif  (request()->segment(2) == 'assetCategory_configure') class="active" @endif
                                href="/assets/assetCategory_list">{{ __('Asset Category') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Accounting module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="dollar-sign"></i>
                        </span>
                        <span>{{ __('Accounting Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'priceList_list') class="active" @elseif  (request()->segment(2) == 'priceList_configure') class="active" @endif
                                href="/accounting/priceList_list">{{ __('Price List') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'itemPrice_list') class="active" @elseif  (request()->segment(2) == 'itemPrice_configure') class="active" @endif
                                href="/accounting/itemPrice_list">{{ __('Item Price') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'bank_list') class="active" @elseif  (request()->segment(2) == 'bank_configure') class="active" @endif
                                href="/accounting/bank_list">{{ __('Bank') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'bankAccountType_list') class="active" @elseif  (request()->segment(2) == 'bankAccountType_configure') class="active" @endif
                                href="/accounting/bankAccountType_list">{{ __('Bank Account Type') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'bankAccount_list') class="active" @elseif  (request()->segment(2) == 'bankAccount_configure') class="active" @endif
                                href="/accounting/bankAccount_list">{{ __('Bank Accounts') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'exchange_rate_list') class="active" @elseif  (request()->segment(2) == 'exchange_rate_configure') class="active" @endif
                                href="/accounting/exchange_rate_list">{{ __('Exchange Rates') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Manufacturing module nav --}}
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i data-feather="dollar-sign"></i>
                        </span>
                        <span>{{ __('Manufacturing Module') }}</span>
                    </a>
                    <ul>
                        <li>
                            <a @if (request()->segment(2) == 'manufacturingSetting_list') class="active" @elseif (request()->segment(2) == 'manufacturingSetting_configure')  class="active" @endif
                                href="/mnu/manufacturingSetting_list">{{ __('Manufacturing Setting') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'BOMItem_list') class="active" @elseif (request()->segment(2) == 'BOMItem_configure')  class="active" @endif
                                href="/mnu/BOMItem_list">{{ __('BOM Item') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'customerItem_list') class="active" @elseif (request()->segment(2) == 'customerItem_configure')  class="active" @endif
                                href="/mnu/customerItem_list">{{ __('Customer Item') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'productionPlan_configure') class="active" @elseif (request()->segment(2) == 'NewRequirements_configure')  class="active" @endif
                                href="/mnu/productionPlan_configure">{{ __('Production Plan') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'planingDetail_configure') class="active" @endif
                                href="/mnu/planingDetail_configure">{{ __('Planing Detail') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'packingDetails') class="active" @endif
                                href="/mnu/packingDetails">{{ __('Packing Details') }}</a>
                        </li>
                        <li>
                            <a href="#">Reports</a>
                            <ul>
                                <li>
                                    <a @if (request()->segment(3) == 'productionRecovery_details') class="active" @endif
                                        href="/mnu/reports/productionRecovery_details">{{ __('Production Recovery Details') }}</a>
                                </li>
                                <li>
                                    <a @if (request()->segment(2) == 'production_details') class="active" @endif
                                        href="/mnu/reports/production_details">{{ __('Production Details') }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif

        {{-- "CCuser" Level Side Navigation Bar --}}

        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
