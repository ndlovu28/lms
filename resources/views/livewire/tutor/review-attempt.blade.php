<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Review Quiz Attempt</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('tutor.review-quizzes') }}" class="text-body fs-14 hover">Quizzes</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tutor.quiz-attempts', $attempt->quiz_id) }}" class="text-body fs-14 hover">{{ $attempt->quiz->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Review: {{ $attempt->user->name }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border border-white rounded-10 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="ri-user-voice-line fs-24 text-primary"></i>
                        </div>
                        <div>
                            <h2 class="fs-20 fw-bold mb-1">{{ $attempt->user->name }} {{ $attempt->user->surname }}</h2>
                            <p class="text-muted mb-0"><i class="ri-calendar-check-line me-1"></i>Completed on {{ $attempt->completed_at->format('F d, Y \a	 H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-block text-center px-4 py-2 bg-primary bg-opacity-10 rounded-10">
                        <div class="fs-24 fw-bold text-primary">{{ $attempt->score }} / {{ $attempt->quiz->questions->count() }}</div>
                        <div class="text-primary text-uppercase small fw-bold">Final Score</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <h3 class="fs-18 fw-medium mb-0">Question Breakdown</h3>
                </div>
            </div>
        </div>
    </div>

    @foreach($attempt->quiz->questions as $index => $question)
        @php
            $studentAnswer = $attempt->answers->where('question_id', $question->id)->first();
            $isCorrect = $studentAnswer && $studentAnswer->answer === $question->correct_option;
        @endphp
        <div class="card bg-white border border-white rounded-10 mb-4 overflow-hidden">
            <div class="card-header @if($isCorrect) bg-success bg-opacity-10 @else bg-danger bg-opacity-10 @endif border-0 py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold @if($isCorrect) text-success @else text-danger @endif">Question {{ $index + 1 }}</span>
                @if($isCorrect)
                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Correct</span>
                @else
                    <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="ri-error-warning-line me-1"></i>Incorrect</span>
                @endif
            </div>
            <div class="card-body p-4">
                <p class="fs-16 text-secondary mb-4">{{ $question->text }}</p>
                
                <div class="row g-3">
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                        @php
                            $optionText = $question->{"option_$opt"};
                            $isChosen = $studentAnswer && $studentAnswer->answer === $opt;
                            $isCorrectOpt = $question->correct_option === $opt;
                            
                            $class = 'border rounded-10 p-3 d-flex justify-content-between align-items-center transition ';
                            if ($isCorrectOpt) $class .= 'bg-success bg-opacity-10 border-success text-success';
                            elseif ($isChosen && !$isCorrectOpt) $class .= 'bg-danger bg-opacity-10 border-danger text-danger';
                            else $class .= 'bg-light border-light text-body';
                        @endphp
                        <div class="col-12">
                            <div class="{{ $class }}">
                                <span class="fs-15"><strong>{{ strtoupper($opt) }}:</strong> {{ $optionText }}</span>
                                @if($isChosen)
                                    <span class="badge @if($isCorrectOpt) bg-success @else bg-danger @endif text-white small px-2 py-1">Student's Choice</span>
                                @elseif($isCorrectOpt)
                                    <span class="badge bg-success text-white small px-2 py-1">Correct Answer</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <div class="card bg-white border border-white rounded-10 mb-4">
        <div class="card-body text-center py-4">
            <a href="{{ route('tutor.quiz-attempts', $attempt->quiz_id) }}" class="btn btn-primary px-5 py-2">
                <i class="ri-arrow-left-line me-1"></i> Back to Results
            </a>
        </div>
    </div>
</div>
