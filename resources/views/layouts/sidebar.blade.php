<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @foreach($Menus as $Menu)
                @if(count($Menu->SubMenu) > 0)
                <li class="sidebar-item {{$MainMenus->menu_system_part == $Menu->menu_system_name ? 'selected' : ''}}">
                    <a class="sidebar-link has-arrow waves-effect waves-dark {{$MainMenus->menu_system_part == $Menu->menu_system_name ? 'active' : ''}}" href="javascript:void(0)" aria-expanded="false">
                        <i class="{{$Menu->menu_system_icon}}"></i>
                        <span class="hide-menu">{{$Menu->menu_system_name}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level {{$MainMenus->MainMenus && $MainMenus->MainMenus->menu_system_name == $Menu->menu_system_name ? 'in' : ''}}">
                        @foreach($Menu->SubMenu as $SubMenu)
                        <li class="sidebar-item {{$SubMenu->menu_system_part == $MainMenus->menu_system_part ? 'active' : ''}}">
                            <a href="{{url('admin/'.$SubMenu->menu_system_part)}}" class="sidebar-link">
                                <i class="{{$SubMenu->menu_system_icon}}"></i>

                                <span class="hide-menu">{{$SubMenu->menu_system_name}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @else
                <li class="sidebar-item">
                    <a href="{{url('admin/'.$Menu->menu_system_part)}}" class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false">
                        <i class="{{$Menu->menu_system_icon}}"></i>
                        <span class="hide-menu">{{$Menu->menu_system_name}}</span>
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>