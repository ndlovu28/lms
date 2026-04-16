<div class="container py-5">
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $quiz->name }}</h1>
            <p class="text-muted">Course: {{ $quiz->course?->name }} | Total questions: {{ $totalQuestions }}</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary fs-6">{{ $currentQuestionIndex + 1 }} / {{ $totalQuestions }}</span>
        </div>
    </div>

    @if(!$showResults)
        <div class="progress mb-4" style="height: 10px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                @if($currentQuestion)
                    <h5 class="card-title mb-4">Question {{ $currentQuestionIndex + 1 }}:</h5>
                    <p class="fs-5 mb-4">{{ $currentQuestion->text }}</p>

                    <div class="list-group">
                        <label class="list-group-item list-group-item-action @if($selectedOption === 'a') active @endif cursor-pointer">
                            <input type="radio" name="option" value="a" class="form-check-input me-3" wire:model="selectedOption" wire:click="saveAnswer">
                            <strong>A:</strong> {{ $currentQuestion->option_a }}
                        </label>
                        <label class="list-group-item list-group-item-action @if($selectedOption === 'b') active @endif cursor-pointer">
                            <input type="radio" name="option" value="b" class="form-check-input me-3" wire:model="selectedOption" wire:click="saveAnswer">
                            <strong>B:</strong> {{ $currentQuestion->option_b }}
                        </label>
                        <label class="list-group-item list-group-item-action @if($selectedOption === 'c') active @endif cursor-pointer">
                            <input type="radio" name="option" value="c" class="form-check-input me-3" wire:model="selectedOption" wire:click="saveAnswer">
                            <strong>C:</strong> {{ $currentQuestion->option_c }}
                        </label>
                        <label class="list-group-item list-group-item-action @if($selectedOption === 'd') active @endif cursor-pointer">
                            <input type="radio" name="option" value="d" class="form-check-input me-3" wire:model="selectedOption" wire:click="saveAnswer">
                            <strong>D:</strong> {{ $currentQuestion->option_d }}
                        </label>
                    </div>
                @else
                    <p class="text-center py-5 text-muted">No questions available for this quiz.</p>
                @endif
            </div>
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-secondary" wire:click="previousQuestion" @if($currentQuestionIndex === 0) disabled @endif>
                    Previous
                </button>

                @if($currentQuestionIndex === $totalQuestions - 1)
                    <button type="button" class="btn btn-primary px-5" wire:click="finishQuiz">
                        Finish Quiz
                    </button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="nextQuestion">
                        Next
                    </button>
                @endif
            </div>
        </div>

        @error('finish')
            <div class="alert alert-warning mb-4">{{ $message }}</div>
        @enderror

        <div class="text-center text-muted small">
            <span class="material-symbols-outlined align-middle fs-6">info</span>
            Your progress is automatically saved. You can leave and come back later.
        </div>
    @else
        <div class="card shadow-sm text-center py-5">
            <div class="card-body">
                <div class="mb-4">
                    <span class="material-symbols-outlined text-success display-1">check_circle</span>
                </div>
                <h2 class="h3 mb-3">Quiz Completed!</h2>
                <p class="text-muted mb-4">You have successfully completed the quiz: <strong>{{ $quiz->name }}</strong></p>
                
                <div class="mb-4">
                    <div class="display-3 fw-bold text-primary">{{ $attempt->score }} / {{ $totalQuestions }}</div>
                    <div class="text-muted fs-5">Your score</div>
                </div>

                <div class="progress mb-4 mx-auto" style="height: 10px; width: 60%;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($attempt->score / $totalQuestions) * 100 }}%" aria-valuenow="{{ ($attempt->score / $totalQuestions) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-5">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary btn-lg px-4 gap-3">Back to Dashboard</a>
                </div>
            </div>
        </div>
    @endif
</div>
