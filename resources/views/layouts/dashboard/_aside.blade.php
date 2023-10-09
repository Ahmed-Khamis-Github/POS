<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/dashboard/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dashboard/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#"
                    class="d-block">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Admin' }}</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-sm btn-danger mt-1" type="submit">logOut</button>
                </form>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{ __('site.Dashboard') }}
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>



                @if (Auth::user()->hasPermission('categories_read'))
                    <li class="nav-item">
                        <a href="{{ route('dashboard.categories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ __('site.categories') }}
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                        </a>
                    </li>
                @endif





                @if (Auth::user()->hasPermission('users_read'))
                    <li class="nav-item">
                        <a href="{{ route('dashboard.users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ __('site.users') }}
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                        </a>
                    </li>
                @endif


                @if (Auth::user()->hasPermission('products_read'))
                    <li class="nav-item">
                        <a href="{{ route('dashboard.products.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ __('site.products') }}
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermission('clients_read'))
                <li class="nav-item">
                    <a href="{{ route('dashboard.clients.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{ __('site.clients') }}
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
            @endif





            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
