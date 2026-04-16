<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminCourses;
use App\Livewire\Admin\AdminPhase;
use App\Livewire\Admin\AdminUsers;
use App\Livewire\Admin\SchoolInfo;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Student\StudentDashboard;
use App\Livewire\Student\TakeQuiz;
use App\Livewire\Su\SuDashboard;
use App\Livewire\Tutor\TutorCourses;
use App\Livewire\Tutor\TutorDashboard;
use App\Livewire\Tutor\TutorStudents;
use App\Livewire\Tutor\CreateQuiz;
use App\Livewire\Tutor\ReviewQuizzes;
use App\Livewire\Tutor\QuizAttempts;
use App\Livewire\Tutor\ReviewAttempt;
use App\Livewire\Tutor\ManageLearningMaterials;
use App\Livewire\Tutor\ManageAssignments;
use App\Livewire\Tutor\ReviewSubmissions;
use App\Livewire\Shared\Profile;
use App\Livewire\Student\ViewLearningMaterials;
use App\Livewire\Student\StudentAssignments;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth/login');
});

Route::get('auth/logout', [AuthController::class, 'logout']);

Route::livewire('/auth/login/{school_id?}', Login::class)
    ->name('auth.login');

Route::livewire('/auth/register', Register::class)
    ->name('auth.register');

Route::middleware(['auth', 'super'])
    ->prefix('su')
    ->group(function (): void {
        Route::livewire('/dashboard', SuDashboard::class)
            ->name('su.dashboard');
        
        Route::livewire('/profile', Profile::class)
            ->name('su.profile');
    });

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function (): void {
        Route::livewire('/dashboard', AdminDashboard::class)
            ->name('admin.dashboard');

        Route::livewire('/phases', AdminPhase::class)
            ->name('admin.phases');

        Route::livewire('/courses', AdminCourses::class)
            ->name('admin.courses');

        Route::livewire('/users', AdminUsers::class)
            ->name('admin.users');

        Route::livewire('/profile/{user?}', Profile::class)
            ->name('admin.profile');

        Route::livewire('/school-info', SchoolInfo::class)
            ->name('admin.school-info');
    });

Route::middleware(['auth', 'tutor'])
    ->prefix('tutor')
    ->group(function (): void {
        Route::livewire('/dashboard', TutorDashboard::class)
            ->name('tutor.dashboard');
        
        Route::livewire('/profile', Profile::class)
            ->name('tutor.profile');

        Route::livewire('/courses', TutorCourses::class)
            ->name('tutor.courses');

        Route::livewire('/students', TutorStudents::class)
            ->name('tutor.students');

        Route::livewire('/create-quiz', CreateQuiz::class)
            ->name('tutor.create-quiz');

        Route::livewire('/review-quizzes', ReviewQuizzes::class)
            ->name('tutor.review-quizzes');

        Route::livewire('/quiz-attempts/{quiz}', QuizAttempts::class)
            ->name('tutor.quiz-attempts');

        Route::livewire('/review-attempt/{attempt}', ReviewAttempt::class)
            ->name('tutor.review-attempt');

        Route::livewire('/materials/{course_id?}', ManageLearningMaterials::class)
            ->name('tutor.materials');

        Route::livewire('/assignments', ManageAssignments::class)
            ->name('tutor.manage-assignments');

        Route::livewire('/assignment-submissions/{assignment}', ReviewSubmissions::class)
            ->name('tutor.assignment-submissions');
    });

Route::middleware(['auth', 'student'])
    ->prefix('student')
        ->group(function (): void {
            Route::livewire('/dashboard', StudentDashboard::class)
                ->name('student.dashboard');
    
            Route::livewire('/profile', Profile::class)
                ->name('student.profile');
    
            Route::livewire('/quiz/{quiz}', TakeQuiz::class)            ->name('student.take-quiz');

        Route::livewire('/materials/{course}', ViewLearningMaterials::class)
            ->name('student.view-materials');

        Route::livewire('/assignments/{course}', StudentAssignments::class)
            ->name('student.assignments');
    });
