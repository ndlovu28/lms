<?php

namespace App\Livewire\Tutor;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateQuiz extends Component
{
    public string $name = '';
    public $course_id = '';
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
            'course_id' => 'required|exists:courses,id',
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
            'course_id' => $this->course_id,
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
        $courses = Course::where('tutor_id', Auth::id())->get();

        return view('livewire.tutor.create-quiz', [
            'courses' => $courses,
        ]);
    }
}
