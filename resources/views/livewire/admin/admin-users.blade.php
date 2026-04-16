<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Users</h1>
            <small class="text-muted">Manage users for your school.</small>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <button
                type="button"
                class="nav-link {{ $tab === 'all' ? 'active' : '' }}"
                wire:click="setTab('all')"
            >
                All users
            </button>
        </li>
        <li class="nav-item">
            <button
                type="button"
                class="nav-link {{ $tab === 'pending' ? 'active' : '' }}"
                wire:click="setTab('pending')"
            >
                Pending tutors
            </button>
        </li>
        <li class="nav-item">
            <button
                type="button"
                class="nav-link {{ $tab === 'tutors' ? 'active' : '' }}"
                wire:click="setTab('tutors')"
            >
                Tutors
            </button>
        </li>
        <li class="nav-item">
            <button
                type="button"
                class="nav-link {{ $tab === 'students' ? 'active' : '' }}"
                wire:click="setTab('students')"
            >
                Students
            </button>
        </li>
    </ul>

    <div class="card">
        <div class="card-header">
            @if($tab === 'pending')
                Pending tutors
            @elseif($tab === 'tutors')
                Tutors
            @elseif($tab === 'students')
                Students
            @else
                All users
            @endif
        </div>
        <div class="card-body p-0">
            @if($users->isEmpty())
                <p class="text-muted p-3 mb-0">
                    No users found for this view.
                </p>
            @else
                <div class="list-group list-group-flush">
                    @foreach($users as $user)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="fw-semibold">
                                    {{ $user->name }} {{ $user->surname }}
                                    @if($user->status === 0)
                                        <span class="badge bg-secondary ms-2">Disabled</span>
                                    @endif
                                </div>
                                <div class="small text-muted">
                                    {{ $user->email }}
                                </div>
                                <div class="small text-muted">
                                    Role: {{ $user->role?->name ?? 'N/A' }}
                                    @if($user->role?->name === 'tutor')
                                        @if($user->tutor_approved)
                                            <span class="badge bg-success ms-1">Approved</span>
                                        @else
                                            <span class="badge bg-warning text-dark ms-1">Pending</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="btn-group btn-group-sm" role="group">
                                <button
                                    type="button"
                                    class="btn {{ $user->status === 1 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                    wire:click="toggleUserStatus({{ $user->id }})"
                                >
                                    {{ $user->status === 1 ? 'Disable' : 'Enable' }}
                                </button>
                                
                                @if($user->role?->name === 'tutor')
                                    <button
                                        type="button"
                                        class="btn {{ $user->tutor_approved ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                        wire:click="toggleTutorApproval({{ $user->id }})"
                                    >
                                        {{ $user->tutor_approved ? 'Revoke Approval' : 'Approve' }}
                                    </button>
                                @endif

                                <button
                                    type="button"
                                    class="btn btn-outline-primary"
                                    wire:click="openAssignCourses({{ $user->id }})"
                                >
                                    Assign courses
                                </button>
                                <a href="{{ route('admin.profile', $user->id) }}" class="btn btn-outline-dark">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
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
</div>
