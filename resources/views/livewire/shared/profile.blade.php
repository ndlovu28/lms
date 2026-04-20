<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">
            @if($isEditingOther) 
                Edit User: {{ $user->name }} {{ $user->surname }}
            @else
                My Profile
            @endif
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Profile Settings</span>
                </li>
            </ol>
        </nav>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="ri-user-settings-line fs-24"></i>
                        </div>
                        <div>
                            <h3 class="fs-18 fw-medium mb-0">Personal Information</h3>
                            <p class="text-muted small mb-0">Manage account details and preferences.</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="updateProfile">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-body fw-medium">First Name</label>
                                <input type="text" class="form-control bg-light border-0" wire:model="name" placeholder="Enter first name">
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-body fw-medium">Surname</label>
                                <input type="text" class="form-control bg-light border-0" wire:model="surname" placeholder="Enter surname">
                                @error('surname') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Email Address</label>
                            <input type="email" class="form-control bg-light border-0" wire:model="email" placeholder="Enter email address">
                            @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">New Password <small class="text-muted fw-normal">(leave blank to keep current)</small></label>
                            <input type="password" class="form-control bg-light border-0" wire:model="password" placeholder="Enter new password">
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        @if(in_array(Auth::user()->role->name, ['su', 'admin']))
                            <div class="bg-light rounded-10 p-4 mt-4 mb-4">
                                <h5 class="fs-16 fw-bold mb-3 text-secondary"><i class="ri-admin-line me-2"></i>Administrative Controls</h5>
                                
                                <div class="row g-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-body fw-medium">User Role</label>
                                        <select class="form-select border-0" wire:model="role_id">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-body fw-medium">Account Status</label>
                                        <select class="form-select border-0" wire:model="status">
                                            <option value="1">Active</option>
                                            <option value="0">Disabled</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-4">
                                <label class="form-label text-body fw-medium">Your Role</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="ri-shield-user-line"></i></span>
                                    <input type="text" class="form-control bg-light border-0" value="{{ ucfirst($user->role->name) }}" readonly>
                                </div>
                                <small class="text-muted d-block mt-2"><i class="ri-information-line me-1"></i>Contact an administrator to change your role.</small>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            @if($isEditingOther)
                                <a href="{{ route('admin.users') }}" class="btn btn-light px-4">Cancel</a>
                            @endif
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-10">
                                <i class="ri-save-line me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
