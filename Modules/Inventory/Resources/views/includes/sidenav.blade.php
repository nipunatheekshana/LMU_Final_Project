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
                            <a @if (request()->segment(2) == 'productGroups_list') class="active" @endif
                                href="/inventory/productGroups_list">{{ __('Product Groups') }}</a>
                        </li>
                        <li>
                            <a @if (request()->segment(2) == 'uom_list') class="active"@elseif (request()->segment(2) == 'uom_configure') class="active" @endif
                                href="/inventory/uom_list">{{ __('Unit Of Measurement(UOM)') }}</a>
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
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
