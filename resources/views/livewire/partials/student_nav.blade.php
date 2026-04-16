<aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
    <ul class="menu-inner">
        <li class="menu-title small text-uppercase">
            <span class="menu-title-text">STUDENT PORTAL</span>
        </li>
        
        <li class="menu-item">
            <a href="{{ route('student.dashboard') }}" class="menu-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <span class="material-symbols-outlined menu-icon">dashboard</span>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li class="menu-title small text-uppercase">
            <span class="menu-title-text">ACADEMICS</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('student.dashboard') }}" class="menu-link {{ request()->routeIs('student.view-materials', 'student.take-quiz', 'student.assignments') ? 'active' : '' }}">
                <span class="material-symbols-outlined menu-icon">school</span>
                <span class="title">My Courses</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('student.profile') }}" class="menu-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                <span class="material-symbols-outlined menu-icon">person</span>
                <span class="title">My Profile</span>
            </a>
        </li>

        <li class="menu-title small text-uppercase">
            <span class="menu-title-text">ACCOUNT</span>
        </li>

        <li class="menu-item">
            <a href="{{ url('auth/logout') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">logout</span>
                <span class="title">Logout</span>
            </a>
        </li>
    </ul>
</aside>
