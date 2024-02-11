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

                    </ul>
                </li>
            </ul>
        @endif
        @if (Auth::user()->user_level == 'CCuser')
        @endif
    </div>
</div>
