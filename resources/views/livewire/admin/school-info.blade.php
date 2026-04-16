<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-1">School Information</h1>
        <p class="text-muted">Manage the public identity and details of your school.</p>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">General Details</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateSchool">
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-3 text-center">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                                @elseif($school->logo_url)
                                    <img src="{{ asset($school->logo_url) }}" class="img-thumbnail rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 100px; height: 100px;">
                                        <span class="material-symbols-outlined fs-1 text-muted">corporate_fare</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">School Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" wire:model="logo">
                                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Recommended: Square image, max 2MB (PNG, JPG).</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">School Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">School Slug (URL identifier)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">{{ url('/') }}/login/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" wire:model="slug">
                            </div>
                            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                            <div class="form-text text-muted small mt-1">
                                This identifier is used in your unique login page URL.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" rows="5" placeholder="Tell us more about your institution..."></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-5">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">School Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold d-block">Status</label>
                        @if($school->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold d-block">Created On</label>
                        <span>{{ $school->created_at->format('F d, Y') }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted text-uppercase fw-bold d-block">Last Updated</label>
                        <span>{{ $school->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 border-start border-4 border-info">
                <div class="card-body">
                    <h6 class="fw-bold">Login URL</h6>
                    <p class="small text-muted mb-2">Share this URL with your students and tutors for direct login:</p>
                    <div class="bg-light p-2 rounded small text-break">
                        {{ url('/auth/login/' . $school->id) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
