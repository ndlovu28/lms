<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tutor.manage-assignments') }}">Assignments</a></li>
            <li class="breadcrumb-item active">{{ $assignment->title }}</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="h3 mb-1">Submissions: {{ $assignment->title }}</h1>
        <p class="text-muted">Review student work, provide feedback and assign grades.</p>
    </div>

    <div class="row">
        @foreach($submissions as $submission)
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h6 class="mb-1">{{ $submission->user->name }} {{ $submission->user->surname }}</h6>
                                <p class="text-muted small mb-0">{{ $submission->user->email }}</p>
                                <div class="mt-2">
                                    <span class="badge @if($submission->status === 'reviewed') bg-success @else bg-warning @endif">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small text-muted mb-1">Submitted:</div>
                                <div class="fw-bold">{{ $submission->submitted_at->format('M d, Y H:i') }}</div>
                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-sm btn-link p-0 text-primary">
                                    <span class="material-symbols-outlined align-middle fs-6 me-1">download</span>
                                    {{ $submission->file_name }}
                                </a>
                            </div>
                            <div class="col-md-6 border-start">
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <label class="form-label small mb-1">Feedback</label>
                                        <textarea class="form-control form-control-sm" wire:model="feedback.{{ $submission->id }}" rows="2" placeholder="Great work! Keep it up."></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small mb-1">Grade</label>
                                        <input type="text" class="form-control form-control-sm" wire:model="grade.{{ $submission->id }}" placeholder="e.g. 95/100, A+">
                                    </div>
                                    <div class="col-12 text-end">
                                        @if (session()->has('message-'.$submission->id))
                                            <span class="text-success small me-3">{{ session('message-'.$submission->id) }}</span>
                                        @endif
                                        <button class="btn btn-primary btn-sm px-4" wire:click="saveReview({{ $submission->id }})">
                                            Save Review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($submissions->isEmpty())
            <div class="col-12">
                <div class="card shadow-sm text-center py-5">
                    <p class="text-muted mb-0">No submissions received yet for this assignment.</p>
                </div>
            </div>
        @endif
    </div>
</div>
