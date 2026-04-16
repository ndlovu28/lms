<aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
    <ul class="menu-inner">
        <li class="menu-title small text-uppercase">
            <span class="menu-title-text">MAIN</span>
        </li>
        <li class="menu-item">
            <a href="{{ url('tutor/dashboard') }}" class="menu-link active">
                <span class="material-symbols-outlined menu-icon">dashboard</span>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('tutor/courses') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">content_copy</span>
                <span class="title">My Courses</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('tutor/students') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">people</span>
                <span class="title">My Students</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('tutor.create-quiz') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">quiz</span>
                <span class="title">Create Quiz</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('tutor.materials') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">library_books</span>
                <span class="title">Manage Materials</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('tutor.manage-assignments') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">assignment</span>
                <span class="title">Manage Assignments</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('tutor.review-quizzes') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">assignment_turned_in</span>
                <span class="title">Review Quizzes</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('tutor.profile') }}" class="menu-link">
                <span class="material-symbols-outlined menu-icon">person</span>
                <span class="title">My Profile</span>
            </a>
        </li>
    </ul>
</aside>