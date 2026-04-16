<div class="m-lg-auto my-auto w-930 py-4">
    <div class="card bg-white border rounded-10 border-white py-100 px-130">
        <div class="p-md-5 p-4 p-lg-0">
            <div class="text-center mb-4">
                <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">Register</h3>
                <p class="fs-16 text-secondary lh-1-8">Already have an account yet? <a href="{{ url('auth/login') }}" class="text-primary text-decoration-none">Login</a></p>
            </div>
            @if (session('registration_success'))
                <div class="alert alert-success">
                    {{ session('registration_success') }}
                </div>
            @endif
            <form wire:submit.prevent="findSchool" class="space-y-4">
                <div class="mb-20">
                    <label class="label fs-16 mb-2">School identifier</label>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingInput1" placeholder="Enter email address *" wire:model.live="schoolIdentifier">
                        <label for="floatingInput1">e.g. my-school-slug</label>
                    </div>
                    @error('schoolIdentifier')
                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-secondary btn-sm">Find school</button>
                </div>
            </form>
            @if($school)
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <div class="d-flex items-center space-x-4">
                        @if($school->logo_url)
                            <img
                                src="{{ $school->logo_url }}"
                                alt="{{ $school->name }} logo"
                                class="h-10 w-10 rounded-full object-cover"
                                style="width: 100px;"
                            />
                        @endif

                        <div class="ms-3">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $school->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Identifier: {{ $school->slug }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($school)
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                @if(session('registration_success'))
                    <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-800">
                        {{ session('registration_success') }}
                    </div>
                @endif

                <form wire:submit.prevent="register" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">First Name</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput1" placeholder="Enter email address *" wire:model.live="name">
                                <label for="floatingInput1">Name *</label>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">Surname</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput1" placeholder="Enter email address *" wire:model.live="surname">
                                <label for="floatingInput1">Surname *</label>
                            </div>
                            @error('surname')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">Email Address</label>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingInput1" placeholder="Enter email address *" wire:model.live="email">
                                <label for="floatingInput1">Email Address *</label>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">Password</label>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingInput1" placeholder="Enter email address *" wire:model.live="password">
                                <label for="floatingInput1">Email Address *</label>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">Confirm Password</label>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingInput1" placeholder="Enter email address *" wire:model.live="passwordConfirmation">
                                <label for="floatingInput1">Confirm password *</label>
                            </div>
                            @error('passwordConfirmation')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="block text-sm font-medium text-gray-700">
                                I am a
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="student" value="student" wire:model="userType">
                                <label class="form-check-label" for="student">
                                    Student
                                </label>
                            </div>
                            <div class="form-check">
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
                    </div>
                    <div>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                        >
                            Register
                        </button>
                    </div>
                </form>
            </div>
        @endif
        </div>
    </div>
</div>
