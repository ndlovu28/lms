<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Review Submissions</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('tutor.manage-assignments') }}" class="text-body fs-14 hover">Assignments</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">{{ $assignment->title }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border border-white rounded-10 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                    <i class="ri-file-list-3-line fs-24"></i>
                </div>
                <div>
                    <h4 class="mb-1 fs-18 fw-bold text-secondary">{{ $assignment->title }}</h4>
                    <p class="text-muted mb-0">Review student work, provide feedback and assign grades.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($submissions as $submission)
            <div class="col-12 mb-4">
                <div class="card bg-white border border-white rounded-10 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <i class="ri-user-line fs-20 text-secondary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-15 fw-bold text-secondary">{{ $submission->user->name }} {{ $submission->user->surname }}</h6>
                                        <p class="text-muted small mb-0">{{ $submission->user->email }}</p>
                                    </div>
                                </div>
                                <div>
                                    @if($submission->status === 'reviewed')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Reviewed</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill"><i class="ri-time-line me-1"></i>Pending Review</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 border-start-lg ps-lg-4">
                                <div class="small text-muted mb-2 text-uppercase fw-bold">Submission Details</div>
                                <div class="fw-semibold text-secondary mb-3"><i class="ri-calendar-event-line me-1"></i>{{ $submission->submitted_at->format('M d, Y H:i') }}</div>
                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-light btn-sm w-100 text-start d-flex align-items-center justify-content-between px-3 py-2 rounded-10">
                                    <span class="text-truncate me-2"><i class="ri-file-download-line me-2 text-primary"></i>{{ $submission->file_name }}</span>
                                    <i class="ri-download-2-line text-primary"></i>
                                </a>
                            </div>
                            <div class="col-lg-6 border-start-lg ps-lg-4">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label text-body fw-medium small mb-2 text-uppercase">Feedback</label>
                                        <textarea class="form-control bg-light border-0" wire:model="feedback.{{ $submission->id }}" rows="2" placeholder="Great work! Keep it up."></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label text-body fw-medium small mb-2 text-uppercase">Grade</label>
                                        <input type="text" class="form-control bg-light border-0" wire:model="grade.{{ $submission->id }}" placeholder="e.g. 95/100">
                                    </div>
                                    <div class="col-12 text-end">
                                        <div class="d-flex align-items-center justify-content-end gap-3">
                                            @if (session()->has('message-'.$submission->id))
                                                <span class="text-success small fw-medium"><i class="ri-checkbox-circle-line me-1"></i>{{ session('message-'.$submission->id) }}</span>
                                            @endif
                                            <button class="btn btn-primary px-4 py-2 rounded-10" wire:click="saveReview({{ $submission->id }})">
                                                <i class="ri-save-line me-1"></i> Save Review
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card bg-white border border-white rounded-10 text-center py-5">
                    <div class="card-body">
                        <i class="ri-inbox-archive-line fs-48 text-light mb-3 d-block"></i>
                        <p class="text-muted mb-0">No submissions received yet for this assignment.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
