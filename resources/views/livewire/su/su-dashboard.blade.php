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
                    <span class="text-secondary">School Management</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h3 class="fs-18 fw-medium mb-0"><i class="ri-school-line me-2 text-primary"></i>Registered Schools</h3>
                        <div class="ms-auto">
                            <a href="{{ route('su.manage-school', 'new') }}" class="btn btn-primary btn-sm px-3" wire:navigate>
                                <i class="ri-add-line me-1"></i> Add School
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($schools as $school)
            <div class="col-sm-6 col-lg-4">
                <div class="card bg-white border border-white rounded-10 h-100 shadow-none hover-shadow transition">
                    <div class="position-relative">
                        @if($school->banner_url)
                            <img src="{{ $school->banner_url }}" class="card-img-top rounded-top-10" alt="{{ $school->name }} banner" style="height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-top-10 d-flex align-items-center justify-content-center" style="height: 120px;">
                                <i class="ri-image-line fs-32 text-muted opacity-50"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute start-50 translate-middle" style="top: 100%;">
                            <div class="bg-white p-1 rounded-circle shadow-sm">
                                @if($school->logo_url)
                                    <img src="{{ $school->logo_url }}" class="rounded-circle" alt="{{ $school->name }} logo" style="width: 70px; height: 70px; object-fit: contain; background: white;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                        <i class="ri-school-line fs-24"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column pt-5 text-center">
                        <h5 class="card-title mb-1 fs-18 fw-bold text-secondary mt-2">{{ $school->name }}</h5>
                        <p class="text-muted small mb-3">ID: {{ $school->slug }}</p>
                        
                        <div class="mb-3">
                            @if($school->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Active</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill"><i class="ri-close-circle-line me-1"></i>Inactive</span>
                            @endif
                        </div>

                        <p class="card-text text-body small mb-4 line-clamp-2" style="min-height: 40px;">
                            {{ $school->description ?: 'No description provided for this school.' }}
                        </p>

                        <div class="mt-auto">
                            <a
                                href="{{ route('su.manage-school', $school->id) }}"
                                class="btn btn-outline-primary btn-sm w-100 rounded-10 py-2"
                                wire:navigate
                            >
                                <i class="ri-settings-4-line me-1"></i> Manage School
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card bg-white border border-white rounded-10 text-center py-5">
                    <div class="card-body">
                        <i class="ri-school-line fs-48 text-light mb-3 d-block"></i>
                        <h5 class="text-secondary">No schools found</h5>
                        <p class="text-muted mb-0">Click the <strong>Add School</strong> button to register your first institution.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
