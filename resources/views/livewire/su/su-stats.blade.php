<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">System Overview</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Statistics</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Schools Stats -->
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ri-school-line fs-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Total Schools</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $totalSchools }}</h3>
                        <span class="fs-12 text-success fw-medium">{{ $activeSchools }} Active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Stats -->
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
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Total Users</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $totalUsers }}</h3>
                        <span class="fs-12 text-muted fw-medium">{{ $studentsCount }} Students</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses Stats -->
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
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $totalCourses }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quizzes Stats -->
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="ri-questionnaire-line fs-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-0 fs-14 fw-medium text-body">Quiz Attempts</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $totalAttempts }}</h3>
                        <span class="fs-12 text-muted fw-medium">from {{ $totalQuizzes }} Quizzes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <!-- User Distribution -->
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">User Distribution</h3>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded-10 text-center">
                                <h6 class="fs-14 fw-medium text-body mb-2">Administrators</h6>
                                <h3 class="mb-0 fs-20 fw-bold text-secondary">{{ $adminsCount }}</h3>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded-10 text-center">
                                <h6 class="fs-14 fw-medium text-body mb-2">Tutors</h6>
                                <h3 class="mb-0 fs-20 fw-bold text-secondary">{{ $tutorsCount }}</h3>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded-10 text-center">
                                <h6 class="fs-14 fw-medium text-body mb-2">Students</h6>
                                <h3 class="mb-0 fs-20 fw-bold text-secondary">{{ $studentsCount }}</h3>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4 opacity-10">
                    
                    <h3 class="fs-18 fw-medium mb-4">Content Statistics</h3>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 border rounded-10">
                                <i class="ri-attachment-line fs-24 text-primary me-3"></i>
                                <div>
                                    <h6 class="fs-14 fw-medium mb-0">Learning Materials</h6>
                                    <h4 class="mb-0 fs-18 fw-bold">{{ $totalMaterials }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 border rounded-10">
                                <i class="ri-file-list-3-line fs-24 text-success me-3"></i>
                                <div>
                                    <h6 class="fs-14 fw-medium mb-0">Assignments</h6>
                                    <h4 class="mb-0 fs-18 fw-bold">{{ $totalAssignments }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-10">
                                <div class="d-flex align-items-center">
                                    <i class="ri-checkbox-circle-line fs-24 text-info me-3"></i>
                                    <h6 class="fs-14 fw-medium mb-0">Assignment Submissions</h6>
                                </div>
                                <h4 class="mb-0 fs-18 fw-bold">{{ $totalSubmissions }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <h3 class="fs-18 fw-medium mb-0">Recent Users</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-body fw-medium">User</th>
                                    <th class="py-3 text-body fw-medium">Role</th>
                                    <th class="py-3 text-body fw-medium">School</th>
                                    <th class="pe-4 py-3 text-end text-body fw-medium">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-semibold text-secondary">{{ $user->name }} {{ $user->surname }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">{{ ucfirst($user->role->name) }}</span>
                                        </td>
                                        <td class="py-3 text-body small">
                                            {{ $user->school->name ?? 'System' }}
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted small">
                                            {{ $user->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <!-- Recent Schools -->
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <h3 class="fs-18 fw-medium mb-0">Recent Schools</h3>
                    </div>
                    <div class="p-4">
                        @foreach($recentSchools as $school)
                            <div class="d-flex align-items-center mb-4 last-child-mb-0">
                                <div class="flex-shrink-0">
                                    @if($school->logo_url)
                                        <img src="{{ asset($school->logo_url) }}" alt="Logo" class="rounded-circle" style="width: 45px; height: 45px; object-fit: contain; background: #f8f9fa;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="ri-school-line fs-20"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0 fs-15 fw-bold text-secondary">{{ $school->name }}</h6>
                                    <div class="d-flex align-items-center justify-content-between mt-1">
                                        <span class="text-muted small">{{ $school->slug }}</span>
                                        <span class="text-muted small">{{ $school->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-4 pt-0">
                        <a href="{{ route('su.dashboard') }}" class="btn btn-outline-primary w-100 rounded-10">
                            <i class="ri-settings-3-line me-1"></i> Manage All Schools
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">System Information</h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-3 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-body fw-medium">PHP Version</span>
                            <span class="badge bg-light text-secondary border">{{ PHP_VERSION }}</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-body fw-medium">Laravel Version</span>
                            <span class="badge bg-light text-secondary border">{{ app()->version() }}</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-body fw-medium">Server Date</span>
                            <span class="text-muted small">{{ now()->format('Y-m-d H:i:s') }}</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-body fw-medium">Environment</span>
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill">{{ app()->environment() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
