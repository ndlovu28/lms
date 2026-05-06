<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Manage Marks - {{ $course->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Manage Marks</span>
                </li>
            </ol>
        </nav>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-3">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0">Existing Assessments</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($existingAssessments as $assessment)
                            <button type="button" 
                                    wire:click="loadAssessment('{{ $assessment->title }}')"
                                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex justify-content-between align-items-center {{ $assessmentTitle === $assessment->title ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}">
                                <span>{{ $assessment->title }}</span>
                                <span class="badge bg-light text-secondary rounded-pill">Max: {{ $assessment->max_mark ?? 'N/A' }}</span>
                            </button>
                        @empty
                            <li class="list-group-item border-0 px-4 py-3 text-muted">No assessments created yet.</li>
                        @endforelse
                        <button type="button" 
                                wire:click="$set('assessmentTitle', ''); $set('maxMark', ''); $set('studentMarks', []); $set('studentComments', []);"
                                class="list-group-item list-group-item-action border-0 px-4 py-3 text-primary fw-medium">
                            <i class="ri-add-circle-line me-1"></i> Create New Entry
                        </button>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label text-body fw-medium small mb-2 text-uppercase">Assessment Title</label>
                            <input type="text" class="form-control bg-light border-0" wire:model="assessmentTitle" placeholder="e.g. Midterm Exam, Final Project">
                            @error('assessmentTitle') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-body fw-medium small mb-2 text-uppercase">Max Mark (Optional)</label>
                            <input type="text" class="form-control bg-light border-0" wire:model="maxMark" placeholder="e.g. 100">
                            @error('maxMark') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 border-0 rounded-start">Student Name</th>
                                    <th class="px-4 py-3 border-0">Mark / Grade</th>
                                    <th class="px-4 py-3 border-0 rounded-end">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                    <i class="ri-user-line fs-16 text-secondary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-14 fw-bold text-secondary">{{ $student->name }} {{ $student->surname }}</h6>
                                                    <p class="text-muted small mb-0">{{ $student->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <input type="text" 
                                                   class="form-control bg-light border-0" 
                                                   style="max-width: 120px;"
                                                   wire:model="studentMarks.{{ $student->id }}" 
                                                   placeholder="Grade">
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <input type="text" 
                                                   class="form-control bg-light border-0" 
                                                   wire:model="studentComments.{{ $student->id }}" 
                                                   placeholder="Add a comment...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-primary px-5 py-2 rounded-10" wire:click="saveMarks">
                            <i class="ri-save-line me-1"></i> Save All Marks
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
