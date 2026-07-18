<?php

namespace App\Livewire\Tutor;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateQuiz extends Component
{
    public string $name = '';

    public $subject_id = '';

    public array $questions = [];

    public function mount()
    {
        // Add one empty question by default
        $this->addQuestion();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'text' => '',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_option' => 'a',
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:a,b,c,d',
        ]);

        $quiz = Quiz::create([
            'tutor_id' => Auth::id(),
            'subject_id' => $this->subject_id,
            'name' => $this->name,
        ]);

        foreach ($this->questions as $questionData) {
            $quiz->questions()->create($questionData);
        }

        session()->flash('message', 'Quiz created successfully.');

        return redirect()->route('tutor.dashboard');
    }

    public function render()
    {
        $subjects = Subject::where('tutor_id', Auth::id())->get();

        return view('livewire.tutor.create-quiz', [
            'subjects' => $subjects,
        ]);
    }
}
