<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <h1 class="h3 mb-1">
                    @if($isEditingOther) 
                        Edit User: {{ $user->name }} {{ $user->surname }}
                    @else
                        My Profile
                    @endif
                </h1>
                <p class="text-muted">Manage account details and preferences.</p>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateProfile">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Surname</label>
                                <input type="text" class="form-control @error('surname') is-invalid @enderror" wire:model="surname">
                                @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        @if(in_array(Auth::user()->role->name, ['su', 'admin']))
                            <hr class="my-4">
                            <h5 class="mb-3">Administrative Controls</h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">User Role</label>
                                    <select class="form-select @error('role_id') is-invalid @enderror" wire:model="role_id">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Account Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                        <option value="1">Active</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Your Role</label>
                                <input type="text" class="form-control bg-light" value="{{ ucfirst($user->role->name) }}" readonly>
                                <small class="text-muted">Contact an administrator to change your role.</small>
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            @if($isEditingOther)
                                <a href="{{ route('admin.users') }}" class="btn btn-light me-md-2">Cancel</a>
                            @endif
                            <button type="submit" class="btn btn-primary px-5">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
