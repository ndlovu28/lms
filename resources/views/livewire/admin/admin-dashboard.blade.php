<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Admin Dashboard</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Overview of {{ Auth::user()->school->name }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ri-user-line fs-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Total Students</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $studentsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 text-success rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ri-group-line fs-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Total Tutors</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $tutorsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 text-info rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ri-book-line fs-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Total Courses</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $coursesCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ri-user-add-line fs-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Pending Tutors</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $pendingTutorsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fs-18 fw-medium mb-0">Quick Actions</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action border-0 px-0 py-3 d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="ri-user-follow-line fs-20"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-15 fw-semibold">Approve Tutors</h6>
                                <p class="mb-0 fs-13 text-body">Review and approve pending tutor registrations.</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.courses') }}" class="list-group-item list-group-item-action border-0 px-0 py-3 d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 text-success rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="ri-add-box-line fs-20"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-15 fw-semibold">Manage Courses</h6>
                                <p class="mb-0 fs-13 text-body">Create or modify school curriculum.</p>
                            </div>
                        </a>
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action border-0 px-0 py-3 d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 text-info rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="ri-user-settings-line fs-20"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-15 fw-semibold">User Management</h6>
                                <p class="mb-0 fs-13 text-body">Disable users or assign students to courses.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fs-18 fw-medium mb-0">School Info</h3>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="ri-school-line fs-20 text-secondary"></i>
                            </div>
                            <div>
                                <span class="d-block fs-13 text-body fw-medium">School Name</span>
                                <h6 class="mb-0 fs-15 fw-semibold text-secondary">{{ Auth::user()->school->name }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="ri-user-3-line fs-20 text-secondary"></i>
                            </div>
                            <div>
                                <span class="d-block fs-13 text-body fw-medium">Administrator</span>
                                <h6 class="mb-0 fs-15 fw-semibold text-secondary">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.profile') }}" class="btn btn-outline-primary w-100">
                            <i class="ri-edit-line me-1"></i> Edit My Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
