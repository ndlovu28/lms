<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Manage Assignments</h3>
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
        <div class="col-lg-5 mb-4">
            <div class="card bg-white border border-white rounded-10 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">Create Assignment</h3>
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Course</label>
                            <select class="form-select @error('course_id') is-invalid @enderror" wire:model.live="course_id">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Assignment Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="e.g. Final Project: Algebra">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Description / Instructions</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" rows="5" placeholder="Enter detailed instructions..."></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Due Date</label>
                            <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" wire:model="due_date">
                            @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-body fw-medium">Assignment File (Optional)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" wire:model="file">
                            @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="ri-add-line me-1"></i> Create Assignment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card bg-white border border-white rounded-10 shadow-sm">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <h3 class="fs-18 fw-medium mb-0 text-secondary">Existing Assignments</h3>
                    </div>
                    @if(empty($assignments))
                        <div class="text-center py-5">
                            <i class="ri-projector-line fs-48 text-light mb-3 d-block"></i>
                            <p class="text-muted mb-0">Select a course to view its assignments.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-body fw-medium">Title</th>
                                        <th class="py-3 text-body fw-medium">Due Date</th>
                                        <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $assignment)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="fw-semibold text-secondary">{{ $assignment->title }}</div>
                                                @if($assignment->file_path)
                                                    <small class="text-primary d-flex align-items-center mt-1">
                                                        <i class="ri-attachment-line me-1"></i>
                                                        {{ $assignment->file_name }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                <span class="badge @if($assignment->due_date->isPast()) bg-danger @else bg-primary @endif bg-opacity-10 @if($assignment->due_date->isPast()) text-danger @else text-primary @endif px-3 py-2 rounded-pill">
                                                    {{ $assignment->due_date->format('M d, Y H:i') }}
                                                </span>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('tutor.assignment-submissions', $assignment->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                                        Submissions
                                                    </a>
                                                    <button class="btn btn-outline-danger btn-sm btn-icon" wire:click="deleteAssignment({{ $assignment->id }})" wire:confirm="Are you sure? This will delete all student submissions too.">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
