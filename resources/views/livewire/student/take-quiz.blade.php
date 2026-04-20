<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">{{ $quiz->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Take Quiz</span>
                </li>
            </ol>
        </nav>
    </div>

    @if(!$showResults)
        <div class="card bg-white border border-white rounded-10 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary fw-medium">Course: {{ $quiz->course?->name }}</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-13">Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}</span>
                </div>
                <div class="progress" style="height: 8px; border-radius: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card bg-white border border-white rounded-10 mb-4">
            <div class="card-body p-4">
                @if($currentQuestion)
                    <h3 class="fs-20 fw-semibold mb-4 text-secondary">Question {{ $currentQuestionIndex + 1 }}</h3>
                    <p class="fs-18 mb-4 lh-base">{{ $currentQuestion->text }}</p>

                    <div class="row g-3">
                        @foreach(['a', 'b', 'c', 'd'] as $option)
                            <div class="col-12">
                                <label class="p-3 border rounded-10 d-flex align-items-center cursor-pointer transition-all @if($selectedOption === $option) border-primary bg-primary bg-opacity-10 @else border-light bg-light bg-opacity-50 @endif" style="cursor: pointer;">
                                    <input type="radio" name="option" value="{{ $option }}" class="form-check-input me-3" wire:model="selectedOption" wire:click="saveAnswer">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-uppercase me-2 text-primary">{{ $option }}:</span>
                                        <span class="text-body">{{ $currentQuestion->{'option_' . $option} }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 text-center">
                        <i class="ri-question-line fs-48 text-light mb-3 d-block"></i>
                        <p class="text-muted mb-0">No questions available for this quiz.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-light border-0 p-4 rounded-bottom-10 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-secondary px-4 py-2" wire:click="previousQuestion" @if($currentQuestionIndex === 0) disabled @endif>
                    <i class="ri-arrow-left-line me-1"></i> Previous
                </button>

                @if($currentQuestionIndex === $totalQuestions - 1)
                    <button type="button" class="btn btn-primary px-5 py-2" wire:click="finishQuiz">
                        Finish Quiz <i class="ri-check-line ms-1"></i>
                    </button>
                @else
                    <button type="button" class="btn btn-primary px-4 py-2" wire:click="nextQuestion">
                        Next <i class="ri-arrow-right-line ms-1"></i>
                    </button>
                @endif
            </div>
        </div>

        @error('finish')
            <div class="alert alert-warning border-0 mb-4">{{ $message }}</div>
        @enderror

        <div class="text-center text-muted small mt-4">
            <i class="ri-information-line align-middle me-1"></i>
            Your progress is automatically saved. You can leave and come back later.
        </div>
    @else
        <div class="card bg-white border border-white rounded-10 text-center py-5 shadow-sm">
            <div class="card-body p-5">
                <div class="mb-4">
                    <div class="bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 100px; height: 100px;">
                        <i class="ri-checkbox-circle-fill text-success" style="font-size: 60px;"></i>
                    </div>
                </div>
                <h2 class="fs-28 fw-bold mb-3">Quiz Completed!</h2>
                <p class="text-muted mb-4 fs-16">You have successfully completed the quiz: <span class="text-secondary fw-semibold">{{ $quiz->name }}</span></p>
                
                <div class="card bg-light border-0 rounded-10 mb-5 d-inline-block p-4" style="min-width: 200px;">
                    <div class="display-4 fw-bold text-primary mb-1">{{ $attempt->score }} / {{ $totalQuestions }}</div>
                    <div class="text-muted fs-15 text-uppercase fw-semibold tracking-wider">Your Score</div>
                </div>

                <div class="progress mb-5 mx-auto" style="height: 12px; width: 60%; border-radius: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($attempt->score / $totalQuestions) * 100 }}%" aria-valuenow="{{ ($attempt->score / $totalQuestions) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-10 shadow-sm">
                        <i class="ri-dashboard-line me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
