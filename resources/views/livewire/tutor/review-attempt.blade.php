<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tutor.review-quizzes') }}">Quizzes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tutor.quiz-attempts', $attempt->quiz_id) }}">{{ $attempt->quiz->name }}</a></li>
            <li class="breadcrumb-item active">Review: {{ $attempt->user->name }}</li>
        </ol>
    </nav>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body bg-light rounded">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="h4 mb-1">{{ $attempt->user->name }} {{ $attempt->user->surname }}</h2>
                    <p class="text-muted mb-0">Completed on {{ $attempt->completed_at->format('F d, Y \a	 H:i') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-inline-block text-center px-4">
                        <div class="display-5 fw-bold text-primary">{{ $attempt->score }} / {{ $attempt->quiz->questions->count() }}</div>
                        <div class="text-muted text-uppercase small fw-bold">Final Score</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="h5 mb-3">Question Breakdown</h3>

    @foreach($attempt->quiz->questions as $index => $question)
        @php
            $studentAnswer = $attempt->answers->where('question_id', $question->id)->first();
            $isCorrect = $studentAnswer && $studentAnswer->answer === $question->correct_option;
        @endphp
        <div class="card mb-3 shadow-sm @if($isCorrect) border-success @else border-danger @endif">
            <div class="card-header @if($isCorrect) bg-success-subtle @else bg-danger-subtle @endif d-flex justify-content-between align-items-center">
                <span class="fw-bold">Question {{ $index + 1 }}</span>
                @if($isCorrect)
                    <span class="badge bg-success">Correct</span>
                @else
                    <span class="badge bg-danger">Incorrect</span>
                @endif
            </div>
            <div class="card-body">
                <p class="fs-5 mb-3">{{ $question->text }}</p>
                
                <div class="row g-2">
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                        @php
                            $optionText = $question->{"option_$opt"};
                            $isChosen = $studentAnswer && $studentAnswer->answer === $opt;
                            $isCorrectOpt = $question->correct_option === $opt;
                            
                            $class = 'border rounded p-2 mb-2 d-flex justify-content-between align-items-center ';
                            if ($isCorrectOpt) $class .= 'bg-success text-white border-success';
                            elseif ($isChosen && !$isCorrectOpt) $class .= 'bg-danger text-white border-danger';
                            else $class .= 'bg-light';
                        @endphp
                        <div class="col-12">
                            <div class="{{ $class }}">
                                <span><strong>{{ strtoupper($opt) }}:</strong> {{ $optionText }}</span>
                                @if($isChosen)
                                    <span class="badge bg-white text-dark small">Student's Choice</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-4 text-center">
        <a href="{{ route('tutor.quiz-attempts', $attempt->quiz_id) }}" class="btn btn-primary px-5">Back to Results</a>
    </div>
</div>
