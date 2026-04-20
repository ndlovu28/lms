<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Quiz Results: {{ $quiz->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('tutor.review-quizzes') }}" class="text-decoration-none text-body fs-14">Quizzes</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Results</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border border-white rounded-10 mb-4 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <i class="ri-pie-chart-line fs-24 text-primary"></i>
                </div>
                <div>
                    <h3 class="fs-18 fw-semibold mb-1 text-secondary">{{ $quiz->name }}</h3>
                    <p class="text-muted mb-0 small">Course: {{ $quiz->course->name }} | Total Questions: {{ $quiz->questions->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white border border-white rounded-10 shadow-sm">
        <div class="card-body p-0">
            @if($attempts->isEmpty())
                <div class="p-5 text-center">
                    <i class="ri-user-unfollow-line fs-48 text-light mb-3 d-block"></i>
                    <p class="text-muted mb-0">No students have completed this quiz yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-body fw-medium">Student Name</th>
                                <th class="py-3 text-body fw-medium text-center">Score</th>
                                <th class="py-3 text-body fw-medium text-center">Performance</th>
                                <th class="py-3 text-body fw-medium">Completed At</th>
                                <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attempts as $attempt)
                                @php
                                    $percentage = ($attempt->score / $quiz->questions->count()) * 100;
                                    $isPass = $percentage >= 50;
                                @endphp
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="ri-user-3-line text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-secondary">{{ $attempt->user->name }} {{ $attempt->user->surname }}</div>
                                                <small class="text-muted">{{ $attempt->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="fw-bold @if($isPass) text-success @else text-danger @endif fs-16">{{ $attempt->score }} / {{ $quiz->questions->count() }}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-inline-block" style="width: 120px;">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <small class="@if($isPass) text-success @else text-danger @endif fw-bold">{{ number_format($percentage, 0) }}%</small>
                                            </div>
                                            <div class="progress" style="height: 6px; border-radius: 3px;">
                                                <div class="progress-bar @if($isPass) bg-success @else bg-danger @endif" role="progressbar" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-body">{{ $attempt->completed_at->format('M d, Y') }}</span>
                                        <small class="text-muted d-block">{{ $attempt->completed_at->format('H:i') }}</small>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('tutor.review-attempt', $attempt->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                            <i class="ri-eye-line me-1"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $attempts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
