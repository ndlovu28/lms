<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        @if(Auth::user()->school->logo_url)
            <img src="{{ asset(Auth::user()->school->logo_url) }}" alt="Logo" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
        @else
            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                <span class="material-symbols-outlined fs-2">school</span>
            </div>
        @endif
        <div>
            <h1 class="h3 mb-1">{{ Auth::user()->school->name }}</h1>
            <p class="text-muted mb-0">Tutor Dashboard | Overview of your courses and students.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Assigned courses</h5>
                    <p class="display-6 mb-0">{{ $courses->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Students</h5>
                    <p class="display-6 mb-0">{{ $studentsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Quizzes</h5>
                    <p class="display-6 mb-0">{{ $quizzesCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Quiz Completions</h5>
                    <p class="display-6 mb-0">{{ $quizAttemptsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Your courses
        </div>
        <div class="card-body p-0">
            @if($courses->isEmpty())
                <p class="text-muted p-3 mb-0">
                    You have no courses assigned yet.
                </p>
            @else
                <div class="list-group list-group-flush">
                    @foreach($courses as $course)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $course->name }}</div>
                                <small class="text-muted d-block">
                                    Phase: {{ $course->phase?->name ?? 'N/A' }}
                                </small>
                                <small class="text-muted d-block">
                                    Enrolled students: {{ $course->students_count }}
                                </small>
                            </div>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('tutor.courses') }}" class="btn btn-outline-primary">
                                    Manage
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
