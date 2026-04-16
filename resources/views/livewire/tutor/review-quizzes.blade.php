<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-1">Review Quizzes</h1>
        <p class="text-muted">Overview of all quizzes and student performance.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Quizzes</h5>
        </div>
        <div class="card-body p-0">
            @if($quizzes->isEmpty())
                <p class="text-muted p-4 mb-0 text-center">No quizzes have been created yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Quiz Name</th>
                                <th>Course</th>
                                <th class="text-center">Questions</th>
                                <th class="text-center">Completions</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizzes as $quiz)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $quiz->name }}</div>
                                        <small class="text-muted">Created: {{ $quiz->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>{{ $quiz->course->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $quiz->questions_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $quiz->attempts_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('tutor.quiz-attempts', $quiz->id) }}" class="btn btn-sm btn-outline-primary">
                                            View Results
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $quizzes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
