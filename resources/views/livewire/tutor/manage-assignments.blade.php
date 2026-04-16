<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-1">Manage Assignments</h1>
        <p class="text-muted">Create projects and tasks for your students to complete.</p>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Create Assignment</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <select class="form-select @error('course_id') is-invalid @enderror" wire:model.live="course_id">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assignment Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="e.g. Final Project: Algebra">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description / Instructions</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" rows="5" placeholder="Enter detailed instructions..."></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" wire:model="due_date">
                            @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assignment File (Optional)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" wire:model="file">
                            @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Create Assignment</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Existing Assignments</h5>
                </div>
                <div class="card-body p-0">
                    @if(empty($assignments))
                        <div class="text-center py-5">
                            <p class="text-muted mb-0">Select a course to view its assignments.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Due Date</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $assignment)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $assignment->title }}</div>
                                                @if($assignment->file_path)
                                                    <small class="text-success">
                                                        <span class="material-symbols-outlined align-middle fs-6">attach_file</span>
                                                        {{ $assignment->file_name }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="{{ $assignment->due_date->isPast() ? 'text-danger' : 'text-muted' }}">
                                                    {{ $assignment->due_date->format('M d, Y H:i') }}
                                                </small>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('tutor.assignment-submissions', $assignment->id) }}" class="btn btn-outline-primary">
                                                        Submissions
                                                    </a>
                                                    <button class="btn btn-outline-danger" wire:click="deleteAssignment({{ $assignment->id }})" wire:confirm="Are you sure? This will delete all student submissions too.">
                                                        Delete
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
