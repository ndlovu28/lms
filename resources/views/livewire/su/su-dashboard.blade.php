<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Super User Dashboard</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span>School</span>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">School List</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="fs-18 fw-medium">Schools</h3>
                        <div class="ms-auto">
                            <a href="#" class="btn btn-primary btn-sm" wire:click.prevent="openCreateSchoolModal">+ Add School</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-3">
            @forelse($schools as $school)
                <div class="col-md-4">
                    <div class="card h-100">
                        @if($school->logo_url)
                            <img src="{{ $school->logo_url }}" class="card-img-top" alt="{{ $school->name }} logo" style="object-fit: contain; height: 160px;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $school->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Identifier: {{ $school->slug }}</h6>
                            <p class="card-text small text-muted mb-2">
                                {{ $school->description ?: 'No description provided.' }}
                            </p>

                            <span class="badge {{ $school->is_active ? 'bg-success' : 'bg-secondary' }} mb-3 align-self-start">
                                {{ $school->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            <div class="mt-auto">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    wire:click="openEditSchoolModal({{ $school->id }})"
                                >
                                    Edit school
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        No schools have been created yet. Click <strong>“Create School”</strong> to add the first one.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @if($showSchoolModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $editingSchoolId ? 'Edit school' : 'Create school' }}
                    </h5>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="closeSchoolModal"></button>
                </div>
                <form wire:submit.prevent="saveSchool" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="mb-2">School details</h6>
                                <div class="mb-3">
                                    <label class="form-label" for="schoolName">Name</label>
                                    <input id="schoolName" type="text" class="form-control @error('schoolName') is-invalid @enderror" wire:model.live="schoolName">
                                    @error('schoolName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="schoolSlug">Identifier (slug)</label>
                                    <input id="schoolSlug" type="text" class="form-control @error('schoolSlug') is-invalid @enderror" wire:model.live="schoolSlug">
                                    @error('schoolSlug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="schoolDescription">Description</label>
                                    <textarea id="schoolDescription" class="form-control @error('schoolDescription') is-invalid @enderror" rows="3" wire:model.live="schoolDescription"></textarea>
                                    @error('schoolDescription')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                    <div class="form-check mb-3">
                                        <input
                                            id="schoolIsActive"
                                            type="checkbox"
                                            class="form-check-input @error('schoolIsActive') is-invalid @enderror"
                                            wire:model.live="schoolIsActive"
                                        >
                                        <label class="form-check-label" for="schoolIsActive">
                                            Active
                                        </label>
                                        @error('schoolIsActive')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="mb-2">School logo</h6>

                                    <div class="mb-3">
                                        <input
                                            type="file"
                                            class="form-control @error('schoolLogo') is-invalid @enderror"
                                            wire:model="schoolLogo"
                                            accept="image/*"
                                        >
                                        @error('schoolLogo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        @if($schoolLogo)
                                            <p class="small text-muted mb-1">Preview:</p>
                                            <img
                                                src="{{ $schoolLogo->temporaryUrl() }}"
                                                alt="Logo preview"
                                                class="img-fluid rounded border"
                                                style="max-height: 160px; object-fit: cover;"
                                            >
                                        @elseif($existingLogoUrl)
                                            <p class="small text-muted mb-1">Current logo:</p>
                                            <img
                                                src="{{ $existingLogoUrl }}"
                                                alt="Current logo"
                                                class="img-fluid rounded border"
                                                style="max-height: 160px; object-fit: cover;"
                                            >
                                        @else
                                            <p class="text-muted small mb-0">No logo uploaded.</p>
                                        @endif
                                    </div>

                                    <hr>

                                    <h6 class="mb-2">Admin user</h6>

                                    <div class="mb-3">
                                        <label class="form-label" for="adminName">First name</label>
                                        <input
                                            id="adminName"
                                            type="text"
                                            class="form-control @error('adminName') is-invalid @enderror"
                                            wire:model.live="adminName"
                                        >
                                        @error('adminName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="adminSurname">Surname</label>
                                        <input
                                            id="adminSurname"
                                            type="text"
                                            class="form-control @error('adminSurname') is-invalid @enderror"
                                            wire:model.live="adminSurname"
                                        >
                                        @error('adminSurname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="adminEmail">Email</label>
                                        <input
                                            id="adminEmail"
                                            type="email"
                                            class="form-control @error('adminEmail') is-invalid @enderror"
                                            wire:model.live="adminEmail"
                                        >
                                        @error('adminEmail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="adminPassword">
                                            Password
                                            @if($editingSchoolId)
                                                <small class="text-muted">(leave blank to keep existing)</small>
                                            @endif
                                        </label>
                                        <input
                                            id="adminPassword"
                                            type="password"
                                            class="form-control @error('adminPassword') is-invalid @enderror"
                                            wire:model="adminPassword"
                                        >
                                        @error('adminPassword')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="adminPasswordConfirmation">Confirm password</label>
                                        <input
                                            id="adminPasswordConfirmation"
                                            type="password"
                                            class="form-control @error('adminPasswordConfirmation') is-invalid @enderror"
                                            wire:model="adminPasswordConfirmation"
                                        >
                                        @error('adminPasswordConfirmation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                wire:click="closeSchoolModal"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Save school
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


</div>
