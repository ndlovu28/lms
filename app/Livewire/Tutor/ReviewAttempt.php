<?php

namespace App\Livewire\Tutor;

use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewAttempt extends Component
{
    public QuizAttempt $attempt;

    public function mount(QuizAttempt $attempt)
    {
        $attempt->load(['quiz.questions', 'answers.question', 'user']);
        
        if ($attempt->quiz->tutor_id !== Auth::id()) {
            abort(403);
        }
        
        $this->attempt = $attempt;
    }

    public function render()
    {
        return view('livewire.tutor.review-attempt');
    }
}
