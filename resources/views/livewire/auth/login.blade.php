<div>
    <div class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area" style="background-image: url(../../img/rainbow.gif)">
                    <div class="login-content">
                        <p class="sub-title">Log in to your account with your credentials</p>
                        <h1 class="title">The Evolution of <span>Learning</span></h1>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">Welcome Back</h3>
                        <p>Login page allows users to enter login credentials for authentication and access to secure content.</p>
                    </div>
                    <h6 class="login-title"><span>Login</span></h6>
                    <form wire:submit.prevent="login">
                        <div class="mb-4">
                            <label class="mb-1 text-dark">Email</label>
                            <input type="email" class="form-control form-control-lg" placeholder="Enter email address *" wire:model.live="email">
                            @error('email')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="mb-1 text-dark">Password</label>
                            <input type="password" class="form-control form-control-lg" placeholder="Enter password *" wire:model.live="password">
                            @error('password')
                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                            <div class="mb-4">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" id="customCheckBox1">
                                    <label class="form-check-label" for="customCheckBox1">Remember my preference</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <a href="{{ url('auth/forgot-password') }}" class="btn-link text-primary">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                        </div>
                        <p class="text-center">Not registered?  
                            <a class="btn-link text-primary" href="{{ url('auth/register') }}">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>