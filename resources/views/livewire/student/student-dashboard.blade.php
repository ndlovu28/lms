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
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}! Here's an overview of your studies.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">My courses</h5>
                    <p class="display-6 mb-0">{{ $courses->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    @foreach($courses as $course)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $course->name }}</h5>
                        <small class="text-muted">Phase: {{ $course->phase?->name ?? 'N/A' }} | Tutor: {{ $course->tutor?->name ?? 'N/A' }} {{ $course->tutor?->surname ?? '' }}</small>
                    </div>
                    <div>
                        <a href="{{ route('student.view-materials', $course->id) }}" class="btn btn-sm btn-primary">
                            <span class="material-symbols-outlined align-middle fs-6 me-1">auto_stories</span>
                            Study Materials
                        </a>
                        <a href="{{ route('student.assignments', $course->id) }}" class="btn btn-sm btn-outline-primary">
                            <span class="material-symbols-outlined align-middle fs-6 me-1">assignment</span>
                            Assignments
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="text-uppercase text-muted small fw-bold mb-3">Quizzes</h6>
                @if($course->quizzes->isEmpty())
                    <p class="text-muted mb-0">No quizzes available for this course.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Quiz Name</th>
                                    <th>Questions</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->quizzes as $quiz)
                                    @php
                                        $attempt = $attempts->get($quiz->id)?->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $quiz->name }}</td>
                                        <td>{{ $quiz->questions->count() }}</td>
                                        <td>
                                            @if(!$attempt)
                                                <span class="badge bg-secondary">Not Started</span>
                                            @elseif($attempt->completed_at)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning">In Progress</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attempt && $attempt->completed_at)
                                                <span class="fw-bold">{{ $attempt->score }} / {{ $quiz->questions->count() }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if(!$attempt)
                                                <a href="{{ route('student.take-quiz', $quiz->id) }}" class="btn btn-sm btn-primary">Start Quiz</a>
                                            @elseif(!$attempt->completed_at)
                                                <a href="{{ route('student.take-quiz', $quiz->id) }}" class="btn btn-sm btn-warning">Resume</a>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled>View Result</button>
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
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">You are not enrolled in any courses yet.</p>
            </div>
        </div>
    @endif
</div>
