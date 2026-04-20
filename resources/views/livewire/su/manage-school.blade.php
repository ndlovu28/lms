<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">{{ $isNew ? 'Register New School' : 'Manage: ' . $school->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('su.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">{{ $isNew ? 'New School' : 'School Management' }}</span>
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

    <div class="card bg-white border border-white rounded-10 mb-4">
        <div class="card-body p-0">
            <ul class="nav nav-tabs border-0 px-4 pt-3 gap-3">
                <li class="nav-item">
                    <button class="nav-link border-0 pb-3 fs-15 fw-medium {{ $activeTab === 'info' ? 'active text-primary border-bottom border-primary' : 'text-body' }}" wire:click="$set('activeTab', 'info')">
                        <i class="ri-information-line me-1"></i> School Info
                    </button>
                </li>
                @if(!$isNew)
                    <li class="nav-item">
                        <button class="nav-link border-0 pb-3 fs-15 fw-medium {{ $activeTab === 'users' ? 'active text-primary border-bottom border-primary' : 'text-body' }}" wire:click="$set('activeTab', 'users')">
                            <i class="ri-group-line me-1"></i> Users
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link border-0 pb-3 fs-15 fw-medium {{ $activeTab === 'stats' ? 'active text-primary border-bottom border-primary' : 'text-body' }}" wire:click="$set('activeTab', 'stats')">
                            <i class="ri-bar-chart-line me-1"></i> Statistics
                        </button>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if($activeTab === 'info')
                <!-- School Info Card -->
                <div class="card bg-white border border-white rounded-10 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="ri-school-line fs-24"></i>
                            </div>
                            <div>
                                <h3 class="fs-18 fw-medium mb-0">School Information</h3>
                                <p class="text-muted small mb-0">Update institutional details and branding.</p>
                            </div>
                        </div>

                        <form wire:submit.prevent="saveSchool">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-body fw-medium" for="schoolName">School Name</label>
                                        <input id="schoolName" type="text" class="form-control bg-light border-0 py-2" wire:model.live="schoolName" placeholder="e.g. Excellence Academy">
                                        @error('schoolName') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-body fw-medium" for="schoolSlug">Identifier (slug)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 text-muted">/school/</span>
                                            <input id="schoolSlug" type="text" class="form-control bg-light border-0 py-2" wire:model.live="schoolSlug" placeholder="excellence-academy">
                                        </div>
                                        @error('schoolSlug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label text-body fw-medium" for="schoolDescription">Description</label>
                                        <textarea id="schoolDescription" class="form-control bg-light border-0" rows="3" wire:model.live="schoolDescription" placeholder="Briefly describe the institution..."></textarea>
                                        @error('schoolDescription') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch mb-3">
                                        <input id="schoolIsActive" type="checkbox" class="form-check-input" wire:model.live="schoolIsActive">
                                        <label class="form-check-label text-body fw-medium" for="schoolIsActive">Active Status</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-10 fw-bold">
                                    <i class="ri-save-line me-1"></i> {{ $isNew ? 'Create School' : 'Save Changes' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($activeTab === 'users' && !$isNew)
                <!-- Users Management Card -->
                <div class="card bg-white border border-white rounded-10 mb-4">
                    <div class="card-body p-0">
                        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                            <h3 class="fs-18 fw-medium mb-0">User Management</h3>
                            <button class="btn btn-success btn-sm px-3 rounded-10" wire:click="openCreateUserModal">
                                <i class="ri-user-add-line me-1"></i> Add User
                            </button>
                        </div>

                        <div class="px-4 py-3 bg-light">
                            <ul class="nav nav-tabs border-0 gap-2">
                                <li class="nav-item">
                                    <button class="nav-link border-0 rounded-pill px-3 py-1 fs-13 {{ $userTab === 'all' ? 'active bg-primary text-white' : 'text-body' }}" wire:click="setUserTab('all')">All Users</button>
                                </li>
                                @foreach($roles as $role)
                                    <li class="nav-item">
                                        <button class="nav-link border-0 rounded-pill px-3 py-1 fs-13 {{ $userTab === $role->name ? 'active bg-primary text-white' : 'text-body' }}" wire:click="setUserTab('{{ $role->name }}')">{{ ucfirst($role->name) }}s</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if (session()->has('user-message'))
                            <div class="mx-4 mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('user-message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-body fw-medium fs-13">USER</th>
                                        <th class="py-3 text-body fw-medium fs-13">ROLE</th>
                                        <th class="py-3 text-body fw-medium fs-13">STATUS</th>
                                        <th class="pe-4 py-3 text-end text-body fw-medium fs-13">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="ri-user-line text-secondary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-secondary">{{ $user->name }} {{ $user->surname }}</div>
                                                        <div class="small text-muted">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">{{ ucfirst($user->role->name) }}</span>
                                            </td>
                                            <td class="py-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" @checked($user->status) wire:click="toggleUserStatus({{ $user->id }})">
                                                </div>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <button class="btn btn-outline-primary btn-sm px-3 rounded-10" wire:click="openEditUserModal({{ $user->id }})">
                                                    <i class="ri-edit-line me-1"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">No users found for this role.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3 border-top">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'stats' && !$isNew)
                <!-- School Statistics Section -->
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="card bg-white border border-white rounded-10">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="ri-group-line fs-24"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="card-title mb-0 fs-14 fw-medium text-body">Total Users</h5>
                                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $stats['totalUsers'] }}</h3>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-secondary">{{ $stats['adminsCount'] }} Admins</span>
                                    <span class="badge bg-light text-secondary">{{ $stats['tutorsCount'] }} Tutors</span>
                                    <span class="badge bg-light text-secondary">{{ $stats['studentsCount'] }} Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card bg-white border border-white rounded-10">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success bg-opacity-10 text-success rounded-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="ri-book-open-line fs-24"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="card-title mb-0 fs-14 fw-medium text-body">Active Courses</h5>
                                        <h3 class="mb-0 fs-24 fw-semibold text-secondary">{{ $stats['totalCourses'] }}</h3>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-secondary">{{ $stats['totalMaterials'] }} Materials</span>
                                    <span class="badge bg-light text-secondary">{{ $stats['totalAssignments'] }} Assignments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-white border border-white rounded-10 mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-18 fw-medium mb-4">Activity Overview</h3>
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-10 border-start border-primary border-5">
                                    <h6 class="fs-13 text-muted text-uppercase mb-1">Quiz Submissions</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 fs-24 fw-bold text-secondary">{{ $stats['totalAttempts'] }}</h3>
                                        <span class="ms-2 text-muted small pb-1">from {{ $stats['totalQuizzes'] }} quizzes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-10 border-start border-success border-5">
                                    <h6 class="fs-13 text-muted text-uppercase mb-1">Assignment Submissions</h6>
                                    <div class="d-flex align-items-end">
                                        <h3 class="mb-0 fs-24 fw-bold text-secondary">{{ $stats['totalSubmissions'] }}</h3>
                                        <span class="ms-2 text-muted small pb-1">across all courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Branding Sidebar -->
            <div class="card bg-white border border-white rounded-10 mb-4 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">Branding</h3>
                    
                    <div class="mb-4">
                        <label class="form-label text-body fw-medium mb-2">School Logo</label>
                        <div class="mb-3">
                            @if($schoolLogo)
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $schoolLogo->temporaryUrl() }}" class="rounded-circle border border-white shadow-sm" style="width: 120px; height: 120px; object-fit: contain; background: white;">
                                    <span class="position-absolute bottom-0 end-0 badge bg-primary rounded-circle p-2"><i class="ri-check-line"></i></span>
                                </div>
                            @elseif($existingLogoUrl)
                                <img src="{{ $existingLogoUrl }}" class="rounded-circle border border-white shadow-sm" style="width: 120px; height: 120px; object-fit: contain; background: white;">
                            @else
                                <div class="bg-light rounded-circle border border-dashed d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    <i class="ri-image-add-line fs-32 text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm border-0 bg-light shadow-none" wire:model="schoolLogo" accept="image/*">
                        @error('schoolLogo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="mb-3">
                        <label class="form-label text-body fw-medium mb-2">School Banner</label>
                        <div class="mb-3">
                            @if($schoolBanner)
                                <div class="position-relative">
                                    <img src="{{ $schoolBanner->temporaryUrl() }}" class="rounded-10 border border-white shadow-sm w-100" style="height: 120px; object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 badge bg-primary rounded-circle p-2 m-2"><i class="ri-check-line"></i></span>
                                </div>
                            @elseif($existingBannerUrl)
                                <img src="{{ $existingBannerUrl }}" class="rounded-10 border border-white shadow-sm w-100" style="height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-10 border border-dashed d-flex align-items-center justify-content-center w-100" style="height: 120px;">
                                    <i class="ri-gallery-upload-line fs-32 text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <input type="file" class="form-control form-control-sm border-0 bg-light shadow-none" wire:model="schoolBanner" accept="image/*">
                        @error('schoolBanner') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mt-4 p-3 bg-primary bg-opacity-5 rounded-10">
                        <p class="small text-muted mb-0"><i class="ri-information-line me-1 text-primary"></i> Logos look best as square PNGs. Banners should be landscape (3:1 ratio).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    @if($showUserModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-20 shadow">
                    <div class="modal-header border-bottom-light p-4">
                        <h5 class="modal-title fs-18 fw-bold text-secondary">
                            <i class="ri-{{ $editingUserId ? 'user-settings' : 'user-add' }}-line me-2 text-primary"></i>
                            {{ $editingUserId ? 'Edit User Details' : 'Add New User to School' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showUserModal', false)"></button>
                    </div>
                    <form wire:submit.prevent="saveUser">
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-body fw-medium">First Name</label>
                                    <input type="text" class="form-control bg-light border-0 py-2" wire:model.live="userName" placeholder="John">
                                    @error('userName') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-body fw-medium">Surname</label>
                                    <input type="text" class="form-control bg-light border-0 py-2" wire:model.live="userSurname" placeholder="Doe">
                                    @error('userSurname') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-body fw-medium">Email Address</label>
                                    <input type="email" class="form-control bg-light border-0 py-2" wire:model.live="userEmail" placeholder="john.doe@example.com">
                                    @error('userEmail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-body fw-medium">Role</label>
                                    <select class="form-select bg-light border-0" wire:model.live="userRoleId">
                                        <option value="0">Select a role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('userRoleId') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-body fw-medium">Password @if($editingUserId) <small class="text-muted fw-normal">(keep blank to leave unchanged)</small> @endif</label>
                                    <input type="password" class="form-control bg-light border-0 py-2" wire:model.live="userPassword">
                                    @error('userPassword') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-body fw-medium">Account Status</label>
                                    <select class="form-select bg-light border-0" wire:model.live="userStatus">
                                        <option value="1">Active</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                    @error('userStatus') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-light p-4">
                            <button type="button" class="btn btn-light px-4 py-2 rounded-10" wire:click="$set('showUserModal', false)">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-10 fw-bold">
                                <i class="ri-save-line me-1"></i> {{ $editingUserId ? 'Update User' : 'Create User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
