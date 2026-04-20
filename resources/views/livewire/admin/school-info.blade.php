<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">School Info</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">School Settings</span>
                </li>
            </ol>
        </nav>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert">
            <i class="ri-checkbox-circle-line me-1"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">General Details</h3>
                    <form wire:submit.prevent="updateSchool">
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-3 text-center">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover; border-color: #f1f1f1;">
                                @elseif($school->logo_url)
                                    <img src="{{ asset($school->logo_url) }}" class="img-thumbnail rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover; border-color: #f1f1f1;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 100px; height: 100px;">
                                        <i class="ri-building-4-line fs-1 text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label class="form-label text-body fw-medium">School Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" wire:model="logo">
                                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted mt-1 d-block">Recommended: Square image, max 2MB (PNG, JPG).</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">School Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Enter school name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">School Slug (URL identifier)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">{{ url('/') }}/login/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror border-start-0" wire:model="slug">
                            </div>
                            @error('slug') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            <div class="form-text text-muted small mt-1">
                                This identifier is used in your unique login page URL.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-body fw-medium">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" rows="5" placeholder="Tell us more about your institution..."></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-5 py-2">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">School Status</h3>
                    
                    <div class="mb-4">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Status</label>
                        @if($school->is_active)
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Active</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Created On</label>
                        <span class="text-secondary fw-medium">{{ $school->created_at->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="mb-0">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Last Updated</label>
                        <span class="text-secondary fw-medium">{{ $school->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div class="card bg-primary bg-opacity-10 border-0 rounded-10">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ri-link fs-20 text-primary me-2"></i>
                        <h3 class="fs-16 fw-semibold mb-0">Login URL</h3>
                    </div>
                    <p class="small text-muted mb-3">Share this URL with your students and tutors for direct login:</p>
                    <div class="bg-white p-3 rounded border border-primary border-opacity-20 small text-break fw-medium text-primary">
                        {{ url('/auth/login/' . $school->id) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
