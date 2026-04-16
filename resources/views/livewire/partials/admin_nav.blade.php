<aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
    <ul class="menu-inner">
        <li class="menu-title small text-uppercase">
            <span class="menu-title-text">MAIN</span>
        </li>
        <li class="menu-item">
            <a href="{{ url('admin/dashboard') }}" class="menu-link active">
                <span class="material-symbols-outlined menu-icon">dashboard</span>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('admin/phases') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">content_copy</span>
                <span class="title">Phases</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('admin/courses') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">book</span>
                <span class="title">Courses</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('admin/users') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">people</span>
                <span class="title">Users</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.school-info') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">corporate_fare</span>
                <span class="title">School Info</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('admin.profile') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">person</span>
                <span class="title">My Profile</span>
            </a>
        </li>
    </ul>
</aside>