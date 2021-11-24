<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ asset('website') }}/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ userSession()->name }}</div>
            <div class="email">{{ userSession()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{url('/user/edit/'. userSession()->id)}}"><i class="material-icons">person</i>{{__("website.text_profile")}}</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="{{ route('logout') }}"><i class="material-icons">input</i>{{ __("website.button_logout") }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ activateTap('dashboard') }}">
                <a href="{{ url('dashboard') }}">
                    <i class="material-icons">home</i>
                    <span>{{ __("website.titel_dashboard") }}</span>
                </a>
            </li>
            <li class="{{ activateList('inventories','inventory') }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">store</i>
                    <span>{{ __("website.inventories") }}</span>
                </a>
                <ul class="ml-menu">
                    @role('show-inventories')
                    <li class="{{ activateTap('inventories/all', "inventories") }} ">
                        <a href="{{ url('inventories/all') }}">{{ __("website.my_inventories") }}</a>
                    </li>
                    @endrole
                    @role('modify-inventories')

                    <li class="{{ activateTap('inventory/create') }}">
                        <a href="{{ url('inventory/create') }}">{{ __("website.create_inventories") }}</a>
                    </li>
                    @endrole
                </ul>
            </li>
            <li class="{{ activateList('categories','category') }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">store</i>
                    <span>{{ __("website.categories") }}</span>
                </a>
                <ul class="ml-menu">
                    @role('show-categories')
                    <li class="{{ activateTap('categories/all', "categories") }}">
                        <a href="{{ url('categories/all') }}">{{ __("website.my_categories") }}</a>
                    </li>
                    @endrole
                    @role('modify-categories')

                    <li  class="{{ activateTap('category/create') }}">
                        <a href="{{ url('category/create') }}">{{ __("website.create_categories") }}</a>
                    </li>
                    @endrole
                </ul>
            </li>
            <li class="{{ activateList('products','product') }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">store</i>
                    <span>{{ __("website.products") }}</span>
                </a>
                <ul class="ml-menu">
                    @role('show-products')
                    <li class="{{ activateTap('products/all',"products") }}">
                        <a href="{{ url('products/all') }}">{{ __("website.my_products") }}</a>
                    </li>
                    @endrole
                    @role('modify-products')

                    <li class="{{ activateTap('product/create') }}">
                        <a href="{{ url('product/create') }}">{{ __("website.create_products") }}</a>
                    </li>
                    @endrole
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>