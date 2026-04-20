<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Student Dashboard</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Welcome back, {{ Auth::user()->name }}!</span>
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
                            <p class="text-muted mb-0">You are currently enrolled in {{ $courses->count() }} {{ Str::plural('course', $courses->count()) }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($courses as $course)
        <div class="card bg-white border border-white rounded-10 mb-4 overflow-hidden">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="mb-1 fs-18 fw-bold text-secondary">{{ $course->name }}</h5>
                        <div class="d-flex align-items-center gap-3">
                            <span class="small text-muted"><i class="ri-stack-line me-1"></i>Phase: {{ $course->phase?->name ?? 'N/A' }}</span>
                            <span class="small text-muted"><i class="ri-user-star-line me-1"></i>Tutor: {{ $course->tutor?->name ?? 'N/A' }} {{ $course->tutor?->surname ?? '' }}</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('student.view-materials', $course->id) }}" class="btn btn-primary btn-sm px-3">
                            <i class="ri-book-open-line me-1"></i> Study Materials
                        </a>
                        <a href="{{ route('student.assignments', $course->id) }}" class="btn btn-outline-primary btn-sm px-3">
                            <i class="ri-edit-box-line me-1"></i> Assignments
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <h6 class="text-uppercase text-muted small fw-bold mb-4">Quizzes Overview</h6>
                @if($course->quizzes->isEmpty())
                    <div class="alert alert-light border-0 py-3 mb-0">
                        <p class="text-muted mb-0"><i class="ri-information-line me-2"></i>No quizzes available for this course yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-body fw-medium">Quiz Name</th>
                                    <th class="py-3 text-body fw-medium text-center">Questions</th>
                                    <th class="py-3 text-body fw-medium">Status</th>
                                    <th class="py-3 text-body fw-medium text-center">Score</th>
                                    <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->quizzes as $quiz)
                                    @php
                                        $attempt = $attempts->get($quiz->id)?->first();
                                    @endphp
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-semibold text-secondary">{{ $quiz->name }}</div>
                                        </td>
                                        <td class="py-3 text-center">
                                            <span class="badge bg-light text-body border px-2 py-1">{{ $quiz->questions->count() }}</span>
                                        </td>
                                        <td class="py-3">
                                            @if(!$attempt)
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Not Started</span>
                                            @elseif($attempt->completed_at)
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Completed</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">In Progress</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-center">
                                            @if($attempt && $attempt->completed_at)
                                                <span class="fw-bold text-secondary">{{ $attempt->score }} / {{ $quiz->questions->count() }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            @if(!$attempt)
                                                <a href="{{ route('student.take-quiz', $quiz->id) }}" class="btn btn-sm btn-primary px-4">Start Quiz</a>
                                            @elseif(!$attempt->completed_at)
                                                <a href="{{ route('student.take-quiz', $quiz->id) }}" class="btn btn-sm btn-warning px-4 text-white">Resume</a>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary px-4" disabled>Completed</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    @if($courses->isEmpty())
        <div class="card bg-white border border-white rounded-10">
            <div class="card-body text-center py-5">
                <i class="ri-book-2-line fs-48 text-light mb-3 d-block"></i>
                <p class="text-muted mb-0">You are not enrolled in any courses yet.</p>
            </div>
        </div>
    @endif
</div>
