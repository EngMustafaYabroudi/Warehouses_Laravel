<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img src="{{asset("Admin/user_images/".auth()->user()->image)}}"  class="loaded-image" alt="" style="display: block; width: 100px; margin: 5px 5px;">
        <div>
            <p class="app-sidebar__user-name">{{ auth()->user()->name }}</p>
            {{-- <p class="app-sidebar__user-designation">{{ auth()->user()->roles->name }}</p> --}}
        </div>
    </div>

    <ul class="app-menu">
        {{-- Home --}}
    
        <li>
            <a class="app-menu__item {{ request()->is('*home*') ? 'active' : '' }}" href="{{ route('admin.home') }}">
                <i class="app-menu__icon fa fa-home"></i> 
                <span class="app-menu__label">@lang('site.home')</span>
            </a>
        </li>

        {{--roles--}}
        @if (auth()->user()->hasPermission('read_roles'))
            <li><a class="app-menu__item {{ request()->is('*roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="app-menu__icon fa fa-lock"></i> <span class="app-menu__label">@lang('roles.roles')</span></a></li>
        @endif
        
        {{--admins--}}
        @if (auth()->user()->hasPermission('read_admins'))
        <li><a class="app-menu__item {{ request()->is('*admins*') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}"><i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label">@lang('admins.admins')</span></a></li>
        @endif

        {{--users--}}
        @if (auth()->user()->hasPermission('read_users'))
            <li><a class="app-menu__item {{ request()->is('*users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="app-menu__icon fa fa-user"></i> <span class="app-menu__label">@lang('users.users')</span></a></li>
        @endif

        {{--categorys--}}
        @if (auth()->user()->hasPermission('read_category'))
        <li><a class="app-menu__item {{ request()->is('*category*') ? 'active' : '' }}" href="{{ route('admin.category.index') }}"><i class="app-menu__icon fa fa-list-alt"></i> <span class="app-menu__label">@lang('category.categories')</span></a></li>
       @endif
    
        {{--products--}}
        @if (auth()->user()->hasPermission('read_product'))
            <li><a class="app-menu__item {{ request()->is('*product*') ? 'active' : '' }}" href="{{ route('admin.product.index') }}"><i class="app-menu__icon fa fa-product-hunt"></i> <span class="app-menu__label">@lang('product.products')</span></a></li>
        @endif

        {{--storehouse--}}
        @if (auth()->user()->hasPermission('read_storehouses'))
            <li><a class="app-menu__item {{ request()->is('*storehouses*') ? 'active' : '' }}" href="{{ route('admin.storehouses.index') }}"><i class="app-menu__icon fa fa-store-alt"></i> <span class="app-menu__label">@lang('storehouses.storehouses')</span></a></li>
        @endif

        {{--storehouse_managment--}}
        @if (auth()->user()->hasPermission('read_storehouses_management'))
        <li class="treeview {{ request()->is('*storehouses_management*')}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user-circle"></i><span class="app-menu__label">{{ auth()->user()->storehouse->name}}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('admin.Storehouse_mangament.products.index') }}"><i class="icon fa fa-circle-o"></i>@lang('product.products')</a></li>
                <li><a class="treeview-item" href="{{ route('admin.Storehouse_mangament.employees.index') }}"><i class="icon fa fa-circle-o"></i>@lang('employees.employees')</a></li>
            </ul>
        </li>
       
        
        @endif


        {{--employees--}}
        {{-- @if (auth()->user()->hasPermission('read_employees'))
            <li><a class="app-menu__item {{ request()->is('*employees*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}"><i class="app-menu__icon fa fa-user"></i> <span class="app-menu__label">@lang('employees.employees')</span></a></li>
        @endif
 --}}

         {{--settings--}}
        @if (auth()->user()->hasPermission('read_settings'))
        <li class="treeview {{ request()->is('*settings*') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">@lang('settings.settings')</span><i class="treeview-indicator fa fa-angle-right"></i></a>

            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('admin.settings.general') }}"><i class="icon fa fa-circle-o"></i>@lang('settings.general')</a></li>
            </ul>
        </li>
    @endif

        {{--profile--}}
        <li class="treeview {{ request()->is('*profile*') || request()->is('*password*')  ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user-circle"></i><span class="app-menu__label">@lang('users.profile')</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('admin.profile.edit') }}"><i class="icon fa fa-circle-o"></i>@lang('users.edit_profile')</a></li>
                <li><a class="treeview-item" href="{{ route('admin.profile.password.edit') }}"><i class="icon fa fa-circle-o"></i>@lang('users.change_password')</a></li>
            </ul>
        </li>

        

</aside>
