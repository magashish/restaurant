<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="{{ asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Ruben & Associates</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('images//user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Ruben</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-hamburger"></i>
                    <p>
                        Restaurant Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('restaurant.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Restaurant</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('restaurant.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Restaurants</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fa fa-list-alt"></i>
                    <p>
                       Category Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('category.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Menu Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('category.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Menu Categories</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{url('/users')}}" class="nav-link">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <p>
                        User Management
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{url('/cms')}}" class="nav-link">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <p>
                        CMS Management
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{url('/orders')}}" class="nav-link">
                    <i class="fa fa-first-order" aria-hidden="true"></i>
                    <p>
                        Order Management
                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fa fa-motorcycle"></i>
                    <p>
                        Delivery Prices
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{url('/admin/set-delivery-charges')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Set Delivery Prices</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/admin/view-delivery-charges')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Delivery Prices</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{url('/settings')}}" class="nav-link">
                    <i class="nav-icon fas fa-cogs" aria-hidden="true"></i>
                    <p>
                        Settings
                    </p>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
