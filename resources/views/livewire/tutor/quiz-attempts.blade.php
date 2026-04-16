<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tutor.review-quizzes') }}">Quizzes</a></li>
            <li class="breadcrumb-item active">{{ $quiz->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Results: {{ $quiz->name }}</h1>
            <p class="text-muted">Course: {{ $quiz->course->name }} | Total Questions: {{ $quiz->questions->count() }}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($attempts->isEmpty())
                <p class="text-muted p-5 mb-0 text-center">No students have completed this quiz yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Completed At</th>
                                <th class="text-center">Score</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attempts as $attempt)
                                @php
                                    $percentage = ($attempt->score / $quiz->questions->count()) * 100;
                                    $statusClass = $percentage >= 50 ? 'text-success' : 'text-danger';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $attempt->user->name }} {{ $attempt->user->surname }}</div>
                                        <small class="text-muted">{{ $attempt->user->email }}</small>
                                    </td>
                                    <td>{{ $attempt->completed_at->format('M d, Y H:i') }}</td>
                                    <td class="text-center">
                                        <span class="fw-bold {{ $statusClass }}">{{ $attempt->score }} / {{ $quiz->questions->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 10px; width: 100px; margin: 0 auto;">
                                            <div class="progress-bar {{ $percentage >= 50 ? 'bg-success' : 'bg-danger' }}" role="progressbar" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <small class="{{ $statusClass }} fw-bold">{{ number_format($percentage, 0) }}%</small>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('tutor.review-attempt', $attempt->id) }}" class="btn btn-sm btn-outline-secondary">
                                            Review Answers
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $attempts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
