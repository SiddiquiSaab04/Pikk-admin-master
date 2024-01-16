<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ asset('images/user.png') }}" alt="..." class="img-circle profile_img border border-success">
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{ Auth::check() ? Auth::user()->name : 'XXXX' }}</h2>
    </div>
</div>
<!-- /menu profile quick info -->

<br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-users"></i> System Users <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('user.index') }}">Listing</a></li>
                    <li><a href="{{ route('user.create') }}">Create User</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-users"></i> Role & Permissions <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('role.index') }}">Role</a></li>
                    @can('create_roles')
                    <li><a href="{{ route('role.create') }}">Create Role</a></li>
                    @endcan
                    <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                    @can('create_permissions')
                    <li><a href="{{ route('permissions.create') }}">Create Permissions</a></li>
                    @endcan
                </ul>
            </li>
            @can('read_branches')
            <li><a><i class="fa fa-home"></i> Branches <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('branch.index', Auth::user()->branch_id) }}">Manage Branches</a></li>
                </ul>
            </li>
            @endcan
            <li><a><i class="fa fa-edit"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @can('read_categories')<li><a href="{{ route('category.index') }}">Categories</a></li>@endcan
                    @can('read_products')<li><a href="{{ route('product.index') }}">Products</a></li>@endcan
                    @can('read_addon_groups')<li><a href="{{ route('addonGroup.index') }}">Addon Groups</a></li>@endcan
                </ul>
            </li>
            @can('read_orders')
            <li><a><i class="fa fa-table"></i> Orders <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @if(!empty(Auth::user()->branch_id))
                    <li><a href="{{ route('order.index', Auth::user()->branch_id) }}">Order Listing</a></li>
                    @else
                    @foreach(app('branches') as $branch)
                    <li><a href="{{ route('order.index', $branch->id) }}">{{ $branch->name }} Order Listing</a></li>
                    @endforeach
                    @endif
                </ul>
            </li>
            @endcan
            @can('create_medias')
            <li><a><i class="fa fa-desktop"></i> Media Gallery <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('media.index') }}">Listing</a></li>
                    <li><a href="{{ route('media.create') }}">Create Media</a></li>
                </ul>
            </li>
            @endcan
            @can('see_reports')
            <li><a><i class="fa fa-desktop"></i> Reports <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @if(!empty(Auth::user()->branch_id))
                    <li><a href="{{ route('report.index', Auth::user()->branch_id) }}">Reports</a></li>
                    @else
                    @foreach(app('branches') as $branch)
                    <li><a href="{{ route('report.index', $branch->id) }}">{{ $branch->name }} Reports</a></li>
                    @endforeach
                    @endif
                </ul>
            </li>
            @endcan
        </ul>
    </div>

</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->
