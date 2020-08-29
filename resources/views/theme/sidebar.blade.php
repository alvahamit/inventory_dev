<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-print-none" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
            <!--<i class="fas fa-chart-line"></i>-->
        </div>
        <div class="sidebar-brand-text mx-3">@yield('logo', 'SB Admin <sup>2</sup>')</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Buy and Sell
    </div>

    <!-- Nav Item - Purchase Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBuy" aria-expanded="true" aria-controls="collapseBuy">
            <i class="fas fa-shopping-bag"></i>
            <span>Buy</span>
        </a>
        <div id="collapseBuy" class="collapse" aria-labelledby="headingBuy" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Supplier:</h6>
                <a class="collapse-item" href="{{route('suppliers.index')}}">Suppliers</a>
                
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Purchases:</h6>
                <a class="collapse-item" href="{{route('purchases.index')}}">Purchases</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Catalog:</h6>
                <!--<a class="collapse-item" href="{{route('categories.index')}}">Categories</a>-->
                <a class="collapse-item" href="{{route('products.index')}}">Products</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Sell Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSale" aria-expanded="true" aria-controls="collapseSale">
            <i class="fas fa-dollar-sign"></i>
            <span>Sell</span>
        </a>
        <div id="collapseSale" class="collapse" aria-labelledby="headingSale" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sales Memos:</h6>
                <a class="collapse-item" href="{{route('orders.index')}}">Orders</a>
                <a class="collapse-item" href="{{route('invoices.index')}}">Invoices</a>
                <a class="collapse-item" href="{{route('challans.index')}}">Delivery Challan</a>
                <a class="collapse-item" href="{{route('mrs.index')}}">Money Receipt</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Customer:</h6>
                <a class="collapse-item" href="{{route('customers.index')}}">Customers</a>
                <a class="collapse-item" href="{{route('customers.account')}}">Account Status</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Stock Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock" aria-expanded="true" aria-controls="collapseStock">
            <i class="fas fa-store-alt"></i>
            <span>Stock</span>
        </a>
        <div id="collapseStock" class="collapse" aria-labelledby="headingStock" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Inventory Status:</h6>
                <a class="collapse-item" href="{{route('stock')}}">View Stock</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Transfer Stock:</h6>
                <a class="collapse-item" href="{{route('transfer.challan.create')}}">Transfer Stock</a>
                <a class="collapse-item" href="{{route('transfer.challan.index')}}">Transfer Records</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Stock-out (other):</h6>
                <a class="collapse-item" href="{{route('wastage.index')}}">Wastage</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Marketing Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMarketing" aria-expanded="true" aria-controls="collapseMarketing">
            <i class="fas fa-bullhorn"></i>
            <span>Marketing</span>
        </a>
        <div id="collapseMarketing" class="collapse" aria-labelledby="headingSale" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sampling Memos:</h6>
                <a class="collapse-item" href="{{route('leads.index')}}"">Leads</a>
                <a class="collapse-item" href="{{route('samples.index')}}">Sample Req.</a>
                <a class="collapse-item" href="{{route('sample.invoice.index')}}">Invoices</a>
                <a class="collapse-item" href="{{route('sample.challan.index')}}">Challan</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Customer:</h6>
                <a class="collapse-item" href="{{route('customers.index')}}">Customers</a>
                <a class="collapse-item" href="{{route('customers.account')}}">Account</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>

    <!-- Nav Item - Users Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userSettings" aria-expanded="true" aria-controls="userSettings">
            <i class="fas fa-user-cog"></i>
            <span>Users</span>
        </a>
        <div id="userSettings" class="collapse" aria-labelledby="headingUserSettings" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Setup:</h6>
                <a class="collapse-item" href="{{route('users.index')}}"> Users</a>
                <a class="collapse-item" href="{{route('roles.index')}}">Roles</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Catalog Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#catalogSettings" aria-expanded="true" aria-controls="catalogSettings">
            <!--<i class="fab fa-opencart"></i>-->
            <i class="fas fa-shopping-cart"></i>
            <span>Catalog</span>
        </a>
        <div id="catalogSettings" class="collapse" aria-labelledby="headingCatalogSettings" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Catalog Setup:</h6>
                <a class="collapse-item" href="{{route('categories.index')}}">Categories</a>
                <a class="collapse-item" href="{{route('products.index')}}">Products</a>
                <a class="collapse-item" href="{{route('measurements.index')}}">Measurements</a>
                <a class="collapse-item" href="{{route('countries.index')}}">Countries</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Stores Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#storesSettings" aria-expanded="true" aria-controls="storesSettings">
            <i class="fas fa-store"></i>
            <span>Stores</span>
        </a>
        <div id="storesSettings" class="collapse" aria-labelledby="headingStoresSettings" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Store Setup:</h6>
                <a class="collapse-item" href="{{route('stores.index')}}">Stores</a>
            </div>
        </div>
    </li>

    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>