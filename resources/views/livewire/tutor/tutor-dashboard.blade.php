<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Tutor Dashboard</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Overview for {{ Auth::user()->school->name }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->school->logo_url)
                                <img src="{{ asset(Auth::user()->school->logo_url) }}" alt="Logo" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="ri-school-line fs-24"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1 fs-20 fw-bold">{{ Auth::user()->school->name }}</h4>
                            <p class="text-muted mb-0">Tutor Dashboard | Manage your courses, students and curriculum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                        <i class="ri-book-open-line fs-24"></i>
                    </div>
                    <h5 class="card-title mb-1 fs-14 fw-medium text-body">Assigned Courses</h5>
                    <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $courses->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                        <i class="ri-group-line fs-24"></i>
                    </div>
                    <h5 class="card-title mb-1 fs-14 fw-medium text-body">Students</h5>
                    <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $studentsCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-4 text-center">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                        <i class="ri-questionnaire-line fs-24"></i>
                    </div>
                    <h5 class="card-title mb-1 fs-14 fw-medium text-body">Total Quizzes</h5>
                    <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $quizzesCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-4 text-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                        <i class="ri-checkbox-circle-line fs-24"></i>
                    </div>
                    <h5 class="card-title mb-1 fs-14 fw-medium text-body">Quiz Completions</h5>
                    <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $quizAttemptsCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white border border-white rounded-10">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h3 class="fs-18 fw-medium mb-0">Your Courses</h3>
            </div>
            @if($courses->isEmpty())
                <div class="p-5 text-center">
                    <i class="ri-book-3-line fs-48 text-light mb-3 d-block"></i>
                    <p class="text-muted mb-0">You have no courses assigned yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-body fw-medium">Course Name</th>
                                <th class="py-3 text-body fw-medium">Phase</th>
                                <th class="py-3 text-body fw-medium text-center">Students</th>
                                <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-semibold text-secondary fs-15">{{ $course->name }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                            {{ $course->phase?->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="fw-medium text-body">{{ $course->students_count }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('tutor.courses') }}" class="btn btn-outline-primary btn-sm px-3">
                                            <i class="ri-settings-line me-1"></i> Manage
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
