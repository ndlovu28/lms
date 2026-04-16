<?php

namespace App\Livewire\Tutor;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewQuizzes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $quizzes = Quiz::where('tutor_id', Auth::id())
            ->withCount(['questions', 'attempts' => function($query) {
                $query->whereNotNull('completed_at');
            }])
            ->paginate(10);

        return view('livewire.tutor.review-quizzes', [
            'quizzes' => $quizzes,
        ]);
    }
}
