<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <div class="d-flex align-items-center gap-3">
            <h3 class="mb-0">Users</h3>
            <button class="btn btn-primary d-flex align-items-center" wire:click="openCreateUserModal">
                <i class="ri-add-line me-1"></i> Add User
            </button>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">User Management</span>
                </li>
            </ol>
        </nav>
    </div>

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <ul class="nav nav-tabs border-0 gap-3">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link border-0 rounded-pill px-4 py-2 {{ $tab === 'all' ? 'active bg-primary text-white' : 'text-body bg-light' }}"
                                wire:click="setTab('all')"
                            >
                                All users
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link border-0 rounded-pill px-4 py-2 {{ $tab === 'pending' ? 'active bg-primary text-white' : 'text-body bg-light' }}"
                                wire:click="setTab('pending')"
                            >
                                Pending tutors
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link border-0 rounded-pill px-4 py-2 {{ $tab === 'tutors' ? 'active bg-primary text-white' : 'text-body bg-light' }}"
                                wire:click="setTab('tutors')"
                            >
                                Tutors
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link border-0 rounded-pill px-4 py-2 {{ $tab === 'students' ? 'active bg-primary text-white' : 'text-body bg-light' }}"
                                wire:click="setTab('students')"
                            >
                                Students
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white border border-white rounded-10">
        <div class="card-body p-0">
            @if($users->isEmpty())
                <div class="p-5 text-center">
                    <i class="ri-user-search-line fs-48 text-light mb-3 d-block"></i>
                    <p class="text-muted mb-0">No users found for this view.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-body fw-medium">User Details</th>
                                <th class="py-3 text-body fw-medium">Role & Status</th>
                                <th class="pe-4 py-3 text-end text-body fw-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                <i class="ri-user-line fs-20 text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-secondary fs-15">
                                                    {{ $user->name }} {{ $user->surname }}
                                                </div>
                                                <div class="small text-muted">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex flex-column gap-1">
                                            <span class="text-uppercase small fw-bold text-muted">Role: {{ $user->role?->name ?? 'N/A' }}</span>
                                            <div class="d-flex gap-2">
                                                @if($user->status === 0)
                                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded">Disabled</span>
                                                @else
                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded">Active</span>
                                                @endif

                                                @if($user->role?->name === 'tutor')
                                                    @if($user->tutor_approved)
                                                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded">Approved</span>
                                                    @else
                                                        <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded">Pending</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-light btn-sm dropdown-toggle border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-settings-3-line"></i> Manage
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-2">
                                                <li>
                                                    <button class="dropdown-item rounded mb-1" type="button" wire:click="toggleUserStatus({{ $user->id }})">
                                                        <i class="ri-user-follow-line me-2"></i> {{ $user->status === 1 ? 'Disable Account' : 'Enable Account' }}
                                                    </button>
                                                </li>
                                                @if($user->role?->name === 'tutor')
                                                    <li>
                                                        <button class="dropdown-item rounded mb-1" type="button" wire:click="toggleTutorApproval({{ $user->id }})">
                                                            <i class="ri-checkbox-circle-line me-2"></i> {{ $user->tutor_approved ? 'Revoke Approval' : 'Approve Tutor' }}
                                                        </button>
                                                    </li>
                                                @endif
                                                <li>
                                                    <button class="dropdown-item rounded mb-1" type="button" wire:click="openAssignCourses({{ $user->id }})">
                                                        <i class="ri-book-open-line me-2"></i> Assign Courses
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item rounded" href="{{ route('admin.profile', $user->id) }}">
                                                        <i class="ri-edit-line me-2"></i> Edit Details
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @if($showAssignCoursesModal && $assignUserId)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Assign courses
                            @if($assignUserType === 'tutor')
                                <small class="text-muted"> (as tutor)</small>
                            @elseif($assignUserType === 'student')
                                <small class="text-muted"> (as enrollment)</small>
                            @endif
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            aria-label="Close"
                            wire:click="closeAssignCoursesModal"
                        ></button>
                    </div>

                    <form wire:submit.prevent="saveAssignedCourses">
                        <div class="modal-body">
                            @if($coursesForAssign->isEmpty())
                                <p class="text-muted mb-0">
                                    There are no courses available to assign in this school.
                                </p>
                            @else
                                <p class="small text-muted">
                                    Select the courses to assign to this user.
                                </p>
                                <div class="row">
                                    @foreach($coursesForAssign as $course)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input
                                                    id="courseAssign{{ $course->id }}"
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    value="{{ $course->id }}"
                                                    wire:model="selectedCourseIds"
                                                >
                                                <label
                                                    class="form-check-label"
                                                    for="courseAssign{{ $course->id }}"
                                                >
                                                    {{ $course->name }}
                                                    @if($course->phase)
                                                        <span class="text-muted small">
                                                            ({{ $course->phase->name }})
                                                        </span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                wire:click="closeAssignCoursesModal"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                @if($coursesForAssign->isEmpty()) disabled @endif
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showCreateUserModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New User</h5>
                        <button type="button" class="btn-close" wire:click="closeCreateUserModal"></button>
                    </div>
                    <form wire:submit.prevent="createUser">
                        <div class="modal-body">
                            <div class="row">
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
                                <label class="form-label">Role</label>
                                <select class="form-select @error('role_id') is-invalid @enderror" wire:model="role_id">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeCreateUserModal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
