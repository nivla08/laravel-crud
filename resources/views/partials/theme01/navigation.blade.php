<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                @include('partials.theme01.nav-header')
            </li>
            <li class="{{ (Request::segment(1) == '') ? 'active' : '' }}">
                <a href="{{ route('home') }}"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            @can('manage.users')
            <li class="{{ (Request::segment(2) == 'users') ? 'active' : '' }}">
                <a href="{{ URL::to('/admin/users')}}"><i class="fa fa-users"></i> <span class="nav-label">Users</span></a>
            </li>
            @endcan
            {{-- @canany('permissions.manage' or 'roles.manage') --}}
            @if(auth()->user()->can('manage.permissions') || (auth()->user()->can('manage.roles')))
            <li class="{{ (Request::segment(2) == 'roles' or Request::segment(2) == 'permission') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Roles &  Permissions</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                @can('manage.permissions')
                    <li class="{{ (Request::segment(2) == 'permission') ? 'active' : '' }}"><a href="{{ URL::to('/admin/permission') }}">Permission</a></li>
                @endcan
                @can('manage.roles')
                    <li class="{{ (Request::segment(2) == 'roles') ? 'active' : '' }}"><a href="{{ URL::to('/admin/roles') }}">Roles</a></li>
                @endcan
                </ul>
            </li>
            @endif
            @if(auth()->user()->can('manage.general.settings') || (auth()->user()->can('manage.auth.settings')))
            <li class="{{ (Request::segment(1) == 'settings' or Request::segment(2) == 'auth') ? 'active' : ''  }}">
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                @can('manage.general.settings')
                    <li class="{{ (Request::segment(2) == 'auth') ? 'active' : '' }}"><a href="{{ route('settings.authRegistration') }}">Auth & Registration</a></li>
                @endcan
                @if (Auth::user()->id == 1)
                <li class="{{ (Request::segment(1) == (substr(config("dotenveditor.route"), 1))) ? 'active' : '' }}">
                    <a href="{{ config('dotenveditor.route') }}"><span class="nav-label">Configuration</span></a>
                </li>
                @endif
                @can('manage.auth.settings')
                    <li class="{{ (Request::segment(1) == 'settings' && Request::segment(2) == '') ? 'active' : '' }}"><a href="{{ route('settings.general') }}">General</a></li>
                @endcan
                </ul>
            </li>
            @endif
        </ul>

    </div>
</nav>
