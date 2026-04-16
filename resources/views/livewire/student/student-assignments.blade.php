<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-1">Assignments: {{ $course->name }}</h1>
        <p class="text-muted">Review your projects and submit your work before the deadline.</p>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @foreach($assignments as $assignment)
            @php
                $submission = $assignment->submissions->first();
                $isLate = $assignment->due_date->isPast() && !$submission;
            @endphp
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ $assignment->title }}</h5>
                        <span class="badge @if($isLate) bg-danger @elseif($submission) bg-success @else bg-warning @endif">
                            @if($submission) Submitted @elseif($isLate) Overdue @else Pending @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h6 class="text-muted small text-uppercase fw-bold">Instructions</h6>
                                <p class="mb-4">{{ $assignment->description }}</p>

                                @if($assignment->file_path)
                                    <div class="mb-4">
                                        <h6 class="text-muted small text-uppercase fw-bold">Resources</h6>
                                        <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <span class="material-symbols-outlined align-middle fs-6 me-1">download</span>
                                            Download: {{ $assignment->file_name }}
                                        </a>
                                    </div>
                                @endif

                                <div class="p-3 bg-light rounded border-start border-4 @if($isLate) border-danger @else border-primary @endif">
                                    <div class="small text-muted text-uppercase fw-bold">Deadline</div>
                                    <div class="@if($isLate) text-danger @endif fw-bold">
                                        {{ $assignment->due_date->format('F d, Y \a	 H:i') }}
                                        @if($isLate) (Late) @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 border-start">
                                <h6 class="text-muted small text-uppercase fw-bold">Your Submission</h6>
                                
                                @if($submission)
                                    <div class="alert alert-info py-2 small mb-3">
                                        Submitted on {{ $submission->submitted_at->format('M d, Y H:i') }}
                                    </div>
                                    
                                    @if($submission->status === 'reviewed')
                                        <div class="card bg-success-subtle border-success mb-3">
                                            <div class="card-body py-2">
                                                <div class="fw-bold text-success">Grade: {{ $submission->grade }}</div>
                                                <div class="small mt-1"><strong>Feedback:</strong> {{ $submission->feedback }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <div class="small text-muted mb-1">Uploaded File:</div>
                                        <div class="p-2 border rounded bg-white small d-flex justify-content-between align-items-center">
                                            <span class="text-truncate">{{ $submission->file_name }}</span>
                                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-primary">
                                                <span class="material-symbols-outlined fs-5">visibility</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if(!$submission || $submission->status === 'pending')
                                    <form wire:submit.prevent="submitWork({{ $assignment->id }})">
                                        <div class="mb-3">
                                            <label class="form-label small">@if($submission) Update Submission @else Upload Your Work @endif</label>
                                            <input type="file" class="form-control form-control-sm @error('submissionFile') is-invalid @enderror" wire:model="submissionFile">
                                            @error('submissionFile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100" wire:loading.attr="disabled">
                                            <span wire:loading.remove>@if($submission) Re-submit Work @else Submit Work @endif</span>
                                            <span wire:loading>Uploading...</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($assignments->isEmpty())
            <div class="col-12">
                <div class="card shadow-sm text-center py-5">
                    <p class="text-muted mb-0">No assignments have been posted for this course yet.</p>
                </div>
            </div>
        @endif
    </div>
</div>
