<?php

namespace App\Livewire\Auth;

use App\Models\School;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{

    public string $email = '';
    public string $password = '';

    public function mount(){
        if(!Auth::guest()){
            $this->redirectToDash();
        }
    }

    public function redirectToDash(){
        if(Auth::user()->role->name == 'su'){
            return redirect()->intended('su/dashboard');
        }
        elseif(Auth::user()->role->name == 'admin'){
            return redirect()->intended('admin/dashboard');
        }
        elseif(Auth::user()->role->name == 'tutor'){
            return redirect()->intended('tutor/dashboard');
        }
        elseif(Auth::user()->role->name == 'student'){
            return redirect()->intended('student/dashboard');
        }
        else{
            return redirect()->intended('dashboard');
        }
    }

    public function login()
    {
        $this->resetErrorBag();

        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            $this->addError('email', 'These credentials do not match our records.');

            return null;
        }

        /** @var User $user */
        $user = Auth::user();

        $this->redirectToDash();
    }

    public function render(){
        return view('livewire.auth.login');
    }
}
