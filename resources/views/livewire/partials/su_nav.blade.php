<aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
    <ul class="menu-inner">
        <li class="menu-title small text-uppercase">
            <span class="menu-title-text">MAIN</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('su.dashboard') }}" class="menu-link {{ Request::routeIs('su.dashboard') ? 'active' : '' }}">
                <i class="ri-dashboard-line menu-icon"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('su.stats') }}" class="menu-link {{ Request::routeIs('su.stats') ? 'active' : '' }}">
                <i class="ri-bar-chart-box-line menu-icon"></i>
                <span class="title">Statistics</span>
            </a>
        </li>
    </ul>
</aside>