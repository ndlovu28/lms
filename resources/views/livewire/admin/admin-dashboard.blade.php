<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Admin Dashboard</h1>
            <small class="text-muted">Overview of {{ Auth::user()->school->name }}</small>
        </div>

        <span class="badge bg-secondary">Admin Access</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-primary me-2">people</span>
                        <h5 class="card-title mb-0">Total Students</h5>
                    </div>
                    <p class="display-6 mb-0 fw-bold">{{ $studentsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-success me-2">groups</span>
                        <h5 class="card-title mb-0">Total Tutors</h5>
                    </div>
                    <p class="display-6 mb-0 fw-bold">{{ $tutorsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-info me-2">book</span>
                        <h5 class="card-title mb-0">Total Courses</h5>
                    </div>
                    <p class="display-6 mb-0 fw-bold">{{ $coursesCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="material-symbols-outlined text-warning me-2">person_add</span>
                        <h5 class="card-title mb-0">Pending Tutors</h5>
                    </div>
                    <p class="display-6 mb-0 fw-bold">{{ $pendingTutorsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action d-flex align-items-center px-0">
                            <span class="material-symbols-outlined me-3">how_to_reg</span>
                            <div>
                                <div class="fw-bold">Approve Tutors</div>
                                <small class="text-muted">Review and approve pending tutor registrations.</small>
                            </div>
                        </a>
                        <a href="{{ route('admin.courses') }}" class="list-group-item list-group-item-action d-flex align-items-center px-0">
                            <span class="material-symbols-outlined me-3">add_box</span>
                            <div>
                                <div class="fw-bold">Manage Courses</div>
                                <small class="text-muted">Create or modify school curriculum.</small>
                            </div>
                        </a>
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action d-flex align-items-center px-0">
                            <span class="material-symbols-outlined me-3">manage_accounts</span>
                            <div>
                                <div class="fw-bold">User Management</div>
                                <small class="text-muted">Disable users or assign students to courses.</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">School Info</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold d-block">School Name</label>
                        <span class="fs-5">{{ Auth::user()->school->name }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold d-block">Admin</label>
                        <span class="fs-5">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
                    </div>
                    <div>
                        <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-outline-primary">Edit My Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
