<div>
    <div class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area" style="background-image: url(../../img/rainbow.gif)">
                    <div class="login-content">
                        <p class="sub-title">Register your account with your school details & login credentials</p>
                        <h1 class="title">The Evolution of <span>Learning</span></h1>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">Welcome</h3>
                    </div>
                    <h6 class="login-title @if($school) mb-0 @endif"><span>Register</span></h6>
                    @if(!$school)
                    <form wire:submit.prevent="findSchool">
                        <div class="mb-4">
                            <label class="mb-1 text-dark">School Identifier</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" placeholder="e.g. my-school-slug *" wire:model.live="schoolIdentifier">
                                <button class="btn btn-outline-secondary" type="submit">Find School</button>
                            </div>
                            @error('schoolIdentifier')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                    @endif
                    @if($school)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="profile card card-body px-3 pt-3 pb-0">
                                <div class="profile-head">
                                    <div class="photo-content">
                                        <div class="cover-photo" @if($school->banner_url) style="background-image: url('{{ asset('storage/'.$school->banner_url) }}'); height: 111px;" @else style="background-image: url('{{ asset('img/cover.jpg') }}'); height: 111px;" @endif></div>
                                    </div>
                                    <div class="profile-info">
                                        <div class="profile-photo">
                                            @if($school->logo_url)
                                                <img src="{{ asset('storage/'.$school->logo_url) }}" class="img-fluid rounded-circle" alt="">
                                            @else
                                                <img src="{{ asset('img/logo_placeholder.png') }}" class="img-fluid rounded-circle" alt="">
                                            @endif
                                        </div>
                                        <div class="profile-details">
                                            <div class="profile-name px-3 pt-2">
                                                <h4 class="text-primary mb-0 text-uppercase">{{ $school->name }}</h4>
                                                <p>{{ $school->slug }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(session('registration_success'))
                        <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-800">
                            {{ session('registration_success') }}
                        </div>
                    @endif
                    <form wire:submit.prevent="register">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="mb-1 text-dark">First Name *</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.live="name">
                                    @error('name')
                                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="mb-1 text-dark">Surname *</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.live="surname">
                                    @error('surname')
                                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="mb-1 text-dark">Email *</label>
                            <input type="email" class="form-control form-control-sm" wire:model.live="email">
                            @error('email')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="mb-1 text-dark">Password</label>
                                    <input type="password" class="form-control form-control-sm" wire:model.live="password">
                                    @error('password')
                                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="mb-1 text-dark">Confirm Password</label>
                                    <input type="password" class="form-control form-control-sm" wire:model.live="passwordConfirmation">
                                    @error('passwordConfirmation')
                                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="student" value="student" wire:model="userType">
                                <label class="form-check-label" for="student">
                                    Student
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="tutor" value="tutor" wire:model="userType">
                                <label class="form-check-label" for="tutor">
                                    Tutor
                                    <span class="text-xs text-gray-500">
                                        (school admin will approve your account)
                                    </span>
                                </label>
                            </div>
                            @error('userType')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
