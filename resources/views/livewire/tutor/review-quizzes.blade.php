<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Review Quizzes</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Quiz Performance Overview</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border border-white rounded-10">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h3 class="fs-18 fw-medium mb-0">Quizzes</h3>
            </div>
            @if($quizzes->isEmpty())
                <div class="p-5 text-center">
                    <i class="ri-questionnaire-line fs-48 text-light mb-3 d-block"></i>
                    <p class="text-muted mb-0">No quizzes have been created yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-body fw-medium">Quiz Name</th>
                                <th class="py-3 text-body fw-medium">Course</th>
                                <th class="py-3 text-body fw-medium text-center">Questions</th>
                                <th class="py-3 text-body fw-medium text-center">Completions</th>
                                <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizzes as $quiz)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-semibold text-secondary fs-15">{{ $quiz->name }}</div>
                                        <small class="text-muted"><i class="ri-calendar-line me-1"></i>Created: {{ $quiz->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-body">{{ $quiz->course->name }}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-light text-body border px-2 py-1">{{ $quiz->questions_count }}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $quiz->attempts_count }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('tutor.quiz-attempts', $quiz->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                            <i class="ri-eye-line me-1"></i> View Results
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($quizzes->hasPages())
                    <div class="px-4 py-3 border-top">
                        {{ $quizzes->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
