<div class="ec-left-sidebar ec-bg-sidebar">
    <div id="sidebar" class="sidebar ec-sidebar-footer">

        <div class="ec-brand">
            <a href="{{ route('home') }}" title="{{ config('app.name') }}">
                <img class="ec-brand-icon" src="{{ asset('admin/assets/img/logo/ec-site-logo.png') }}" alt="" />
                <span class="ec-brand-name text-truncate">{{ config('app.name') }}</span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="ec-navigation" data-simplebar>
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <!-- Dashboard -->
                <li class="{{ request()->is('home') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('home') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">{{ __('Dashboard') }}</span>
                    </a>
                    <hr>
                </li>

                <!-- Users -->
                <li class="{{request()->is('home/users*')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('users.index')}}">
                        <i class="mdi mdi-account-group"></i>
                        <span class="nav-text">{{__('Users')}}</span>
                    </a>
                </li>

                <!-- Warehouses -->
                <li class="{{request()->is('home/warehouses*')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('warehouses.index')}}">
                        <i class="mdi mdi-source-branch"></i>
                        <span class="nav-text">{{ __('Warehouses') }}</span>
                    </a>
                </li>

                <!-- Products -->
                <li class="{{request()->is('home/products*')? 'active' : ''}}">
                   <a class="sidenav-item-link" href="{{route('products.index')}}">
                       <i class="mdi mdi-palette-advanced"></i>
                       <span class="nav-text">{{ __('Products') }}</span>
                   </a>
               </li>

                <!-- Categories -->
                <li class="{{request()->is('home/categories*')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('categories.index')}}">
                        <i class="mdi mdi-dns-outline"></i>
                        <span class="nav-text">{{ __('Categories') }}</span>
                    </a>
                </li>

                  <!-- Brands -->
                  <li class="{{request()->is('home/brands*')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('brands.index')}}">
                        <i class="mdi mdi-tag-faces"></i>
                        <span class="nav-text">{{ __('Brands') }}</span>
                    </a>
                </li>

                <!-- Suppliers -->
                <li class="{{request()->is('home/suppliers*')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('suppliers.index')}}">
                        <i class="mdi mdi-dns-outline"></i>
                        <span class="nav-text">{{ __('Suppliers') }}</span>
                    </a>
                </li>

                <!-- Clients -->
                <li class="{{request()->is('home/clients*')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{route('clients.index')}}">
                        <i class="mdi mdi-account-group-outline"></i>
                        <span class="nav-text">{{__('Clients')}}</span>
                    </a>
                </li>

                <!-- Cash Registers -->
                {{-- <li class="has-sub {{request()->is('home/cash-registers*')? 'active expand' : ''}}">
                    <a class="sidenav-item-link" href="#javascript:void(0)">
                        <i class="mdi mdi-cash-multiple"></i>
                        <span class="nav-text">{{ __('Cash Registers') }}</span> <b class="caret"></b>
                    </a>
                    <div class="collapse" style="{{request()->is('home/cash-registers*')? 'display:block' : 'display:none'}}">
                        <ul class="sub-menu" id="cash_registers" data-parent="#sidebar-menu">
                            <li class="{{request()->is('home/cash-registers')? 'active' : ''}}">
                                <a class="sidenav-item-link" href="{{route('cash-registers.index')}}">
                                    <span class="nav-text">{{ __('List') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="sidenav-item-link" href="#order-history">
                                    <span class="nav-text">{{ __('Cash register history') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="sidenav-item-link" href="#order-history">
                                    <span class="nav-text">{{ __('Cash registers authorization') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <!-- Reports -->
                {{-- <li>
                    <a class="sidenav-item-link" href="#review-list">
                        <i class="mdi mdi-star-half"></i>
                        <span class="nav-text">{{ __('Reports') }}</span>
                    </a>
                </li> --}}

                <hr>
                <!-- Settings -->
                <li class="{{request()->is('home/settings')? 'active' : ''}}">
                    <a class="sidenav-item-link" href="{{ route('settings.index') }}">
                        <i class="mdi mdi-settings-outline"></i>
                        <span class="nav-text">{{ __('Settings') }}</span>
                    </a>
                    <hr>
                </li>

                {{-- <!-- Authentication -->
                <li class="has-sub">
                    <a class="sidenav-item-link" href="#javascript:void(0)">
                        <i class="mdi mdi-login"></i>
                        <span class="nav-text">Authentication</span> <b class="caret"></b>
                    </a>
                    <div class="collapse">
                        <ul class="sub-menu" id="authentication" data-parent="#sidebar-menu">
                            <li class="">
                                <a href="#sign-in">
                                    <span class="nav-text">Sign In</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#sign-up">
                                    <span class="nav-text">Sign Up</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Icons -->
                <li class="has-sub">
                    <a class="sidenav-item-link" href="#javascript:void(0)">
                        <i class="mdi mdi-diamond-stone"></i>
                        <span class="nav-text">Icons</span> <b class="caret"></b>
                    </a>
                    <div class="collapse">
                        <ul class="sub-menu" id="icons" data-parent="#sidebar-menu">
                            <li class="">
                                <a class="sidenav-item-link" href="#material-icon">
                                    <span class="nav-text">Material Icon</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="sidenav-item-link" href="#font-awsome-icons">
                                    <span class="nav-text">Font Awsome Icon</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="sidenav-item-link" href="#flag-icon">
                                    <span class="nav-text">Flag Icon</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Other Pages -->
                <li class="has-sub">
                    <a class="sidenav-item-link" href="#javascript:void(0)">
                        <i class="mdi mdi-image-filter-none"></i>
                        <span class="nav-text">Other Pages</span> <b class="caret"></b>
                    </a>
                    <div class="collapse">
                        <ul class="sub-menu" id="otherpages" data-parent="#sidebar-menu">
                            <li class="has-sub">
                                <a href="#404">404 Page</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
