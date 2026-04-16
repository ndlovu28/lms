<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Courses</h1>
            <small class="text-muted">Create and manage courses by phase.</small>
        </div>

        <button
            type="button"
            class="btn btn-success"
            wire:click="startCreate"
        >
            + Add course
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <label for="filterPhase" class="form-label">Filter by phase</label>
            <select
                id="filterPhase"
                class="form-select"
                wire:model="filterPhaseId"
            >
                <option value="">All phases</option>
                @foreach($phases as $phase)
                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-header">
                    {{ $editingCourseId ? 'Edit course' : 'Create course' }}
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course name</label>
                            <input
                                id="courseName"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                wire:model.live="name"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="coursePhase" class="form-label">Phase</label>
                            <select
                                id="coursePhase"
                                class="form-select @error('phaseId') is-invalid @enderror"
                                wire:model="phaseId"
                            >
                                <option value="">Select a phase</option>
                                @foreach($phases as $phase)
                                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                @endforeach
                            </select>
                            @error('phaseId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="courseTutor" class="form-label">Tutor</label>
                            <select
                                id="courseTutor"
                                class="form-select @error('tutorId') is-invalid @enderror"
                                wire:model="tutorId"
                            >
                                <option value="">Select a tutor</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">
                                        {{ $tutor->name }} {{ $tutor->surname }} ({{ $tutor->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tutorId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="courseDescription" class="form-label">Description (optional)</label>
                            <textarea
                                id="courseDescription"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                wire:model.live="description"
                            ></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ $editingCourseId ? 'Update course' : 'Create course' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Existing courses
                </div>
                <div class="card-body p-0">
                    @if($courses->isEmpty())
                        <p class="text-muted p-3 mb-0">
                            No courses have been created yet.
                        </p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($courses as $course)
                                <button
                                    type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                    wire:click="startEdit({{ $course->id }})"
                                >
                                    <div>
                                        <div class="fw-semibold">{{ $course->name }}</div>
                                        <small class="text-muted d-block">
                                            Phase: {{ $course->phase?->name ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted d-block">
                                            Tutor: {{ $course->tutor?->name ?? 'N/A' }}
                                        </small>
                                        @if($course->description)
                                            <small class="text-muted d-block mt-1">
                                                {{ $course->description }}
                                            </small>
                                        @endif
                                    </div>
                                    <span class="text-primary small">Edit</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
