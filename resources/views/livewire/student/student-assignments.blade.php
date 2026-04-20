<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Assignments: {{ $course->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Assignments</span>
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
        @forelse($assignments as $assignment)
            @php
                $submission = $assignment->submissions->first();
                $isLate = $assignment->due_date->isPast() && !$submission;
            @endphp
            <div class="col-12 mb-4">
                <div class="card bg-white border border-white rounded-10">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="ri-projector-line fs-24 text-primary"></i>
                                </div>
                                <h3 class="fs-18 fw-semibold mb-0 text-secondary">{{ $assignment->title }}</h3>
                            </div>
                            <span class="badge @if($isLate) bg-danger @elseif($submission) bg-success @else bg-warning @endif bg-opacity-10 @if($isLate) text-danger @elseif($submission) text-success @else text-warning @endif px-3 py-2 rounded-pill">
                                @if($submission) Submitted @elseif($isLate) Overdue @else Pending @endif
                            </span>
                        </div>

                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase fw-bold d-block mb-2">Instructions</label>
                                    <p class="text-body mb-0 lh-base">{{ $assignment->description }}</p>
                                </div>

                                @if($assignment->file_path)
                                    <div class="mb-4">
                                        <label class="text-muted small text-uppercase fw-bold d-block mb-2">Resources</label>
                                        <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                            <i class="ri-download-2-line me-1"></i>
                                            Download: {{ $assignment->file_name }}
                                        </a>
                                    </div>
                                @endif

                                <div class="p-3 bg-light rounded-10 border-start border-4 @if($isLate) border-danger @else border-primary @endif">
                                    <div class="small text-muted text-uppercase fw-bold">Deadline</div>
                                    <div class="@if($isLate) text-danger @endif fw-bold fs-15 mt-1">
                                        <i class="ri-calendar-event-line me-1"></i>
                                        {{ $assignment->due_date->format('F d, Y \a\t H:i') }}
                                        @if($isLate) <span class="ms-1 text-danger">(Late)</span> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 ps-lg-4 border-start-lg">
                                <label class="text-muted small text-uppercase fw-bold d-block mb-3">Your Submission</label>
                                
                                @if($submission)
                                    <div class="alert alert-primary border-0 bg-primary bg-opacity-10 text-primary small mb-4">
                                        <i class="ri-information-line me-1"></i>
                                        Submitted on {{ $submission->submitted_at->format('M d, Y H:i') }}
                                    </div>
                                    
                                    @if($submission->status === 'reviewed')
                                        <div class="card bg-success bg-opacity-10 border-0 rounded-10 mb-4">
                                            <div class="card-body p-3">
                                                <div class="fw-bold text-success d-flex align-items-center mb-1">
                                                    <i class="ri-medal-line me-2"></i> Grade: {{ $submission->grade }}
                                                </div>
                                                <div class="small text-secondary"><strong>Feedback:</strong> {{ $submission->feedback }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <div class="small text-muted mb-2">Uploaded File:</div>
                                        <div class="p-3 border rounded-10 bg-white small d-flex justify-content-between align-items-center shadow-sm">
                                            <span class="text-truncate fw-medium text-secondary me-2">{{ $submission->file_name }}</span>
                                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-primary">
                                                <i class="ri-eye-line fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if(!$submission || $submission->status === 'pending')
                                    <form wire:submit.prevent="submitWork({{ $assignment->id }})" class="bg-light p-3 rounded-10">
                                        <div class="mb-3">
                                            <label class="form-label text-body fw-medium small">@if($submission) Update Submission @else Upload Your Work @endif</label>
                                            <input type="file" class="form-control form-control-sm @error('submissionFile') is-invalid @enderror border-0 shadow-sm" wire:model="submissionFile">
                                            @error('submissionFile') <div class="invalid-feedback d-block mt-1">{{ $message }}</div> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100 py-2 d-flex align-items-center justify-content-center" wire:loading.attr="disabled">
                                            <span wire:loading.remove>
                                                <i class="ri-upload-cloud-line me-1"></i>
                                                @if($submission) Re-submit Work @else Submit Work @endif
                                            </span>
                                            <span wire:loading>
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                Uploading...
                                            </span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card bg-white border border-white rounded-10 text-center py-5">
                    <div class="card-body">
                        <i class="ri-projector-line fs-48 text-light mb-3 d-block"></i>
                        <p class="text-muted mb-0">No assignments have been posted for this course yet.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
