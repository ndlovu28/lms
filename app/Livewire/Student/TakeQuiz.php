<?php

namespace App\Livewire\Student;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TakeQuiz extends Component
{
    public Quiz $quiz;
    public QuizAttempt $attempt;
    public $currentQuestionIndex = 0;
    public $selectedOption = null;
    public $showResults = false;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;

        // Check if student is enrolled in the course
        if (!Auth::user()->courses->contains($quiz->course_id)) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Find or create an incomplete attempt
        $this->attempt = QuizAttempt::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'completed_at' => null,
            ]
        );

        // Find progress: where did the student leave off?
        $answeredQuestionIds = $this->attempt->answers->pluck('question_id')->toArray();
        $allQuestions = $this->quiz->questions;

        foreach ($allQuestions as $index => $question) {
            if (!in_array($question->id, $answeredQuestionIds)) {
                $this->currentQuestionIndex = $index;
                break;
            }
        }

        // If all answered but not completed, show the last one or results
        if (count($answeredQuestionIds) === $allQuestions->count() && $allQuestions->count() > 0) {
            $this->currentQuestionIndex = $allQuestions->count() - 1;
            // Optionally auto-complete here if needed, but let's let them review
        }

        $this->loadCurrentAnswer();
    }

    public function loadCurrentAnswer()
    {
        $question = $this->quiz->questions[$this->currentQuestionIndex];
        $answer = QuizAnswer::where('quiz_attempt_id', $this->attempt->id)
            ->where('question_id', $question->id)
            ->first();

        $this->selectedOption = $answer ? $answer->answer : null;
    }

    public function saveAnswer()
    {
        if (!$this->selectedOption) return;

        $question = $this->quiz->questions[$this->currentQuestionIndex];

        QuizAnswer::updateOrCreate(
            [
                'quiz_attempt_id' => $this->attempt->id,
                'question_id' => $question->id,
            ],
            ['answer' => $this->selectedOption]
        );
    }

    public function nextQuestion()
    {
        $this->saveAnswer();

        if ($this->currentQuestionIndex < $this->quiz->questions->count() - 1) {
            $this->currentQuestionIndex++;
            $this->loadCurrentAnswer();
        }
    }

    public function previousQuestion()
    {
        $this->saveAnswer();

        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->loadCurrentAnswer();
        }
    }

    public function finishQuiz()
    {
        $this->saveAnswer();

        // Check if all questions are answered
        if ($this->attempt->answers()->count() < $this->quiz->questions->count()) {
            $this->addError('finish', 'Please answer all questions before finishing.');
            return;
        }

        // Calculate score
        $score = 0;
        $answers = $this->attempt->answers()->with('question')->get();
        foreach ($answers as $answer) {
            if ($answer->answer === $answer->question->correct_option) {
                $score++;
            }
        }

        $this->attempt->update([
            'completed_at' => now(),
            'score' => $score,
        ]);

        $this->showResults = true;
    }

    public function render()
    {
        $totalQuestions = $this->quiz->questions->count();
        $answeredCount = $this->attempt->answers()->count();
        $progress = $totalQuestions > 0 ? ($answeredCount / $totalQuestions) * 100 : 0;

        return view('livewire.student.take-quiz', [
            'currentQuestion' => $this->quiz->questions[$this->currentQuestionIndex] ?? null,
            'totalQuestions' => $totalQuestions,
            'progress' => $progress,
        ]);
    }
}
