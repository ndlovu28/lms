<?php

namespace App\Livewire\Tutor;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class QuizAttempts extends Component
{
    use WithPagination;

    public Quiz $quiz;
    protected $paginationTheme = 'bootstrap';

    public function mount(Quiz $quiz)
    {
        if ($quiz->tutor_id !== Auth::id()) {
            abort(403);
        }
        $this->quiz = $quiz;
    }

    public function render()
    {
        $attempts = QuizAttempt::where('quiz_id', $this->quiz->id)
            ->whereNotNull('completed_at')
            ->with('user')
            ->orderBy('completed_at', 'desc')
            ->paginate(15);

        return view('livewire.tutor.quiz-attempts', [
            'attempts' => $attempts,
        ]);
    }
}
