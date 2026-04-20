<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Courses</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Course List</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <h3 class="fs-18 fw-medium mb-0 me-4">Existing Courses</h3>
                            <div style="width: 250px;">
                                <select
                                    id="filterPhase"
                                    class="form-select border-0 bg-light"
                                    wire:model.live="filterPhaseId"
                                >
                                    <option value="">All phases</option>
                                    @foreach($phases as $phase)
                                        <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                wire:click="startCreate"
                            >
                                <i class="ri-add-line"></i> Add course
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">{{ $editingCourseId ? 'Edit course' : 'Create course' }}</h3>
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label for="courseName" class="form-label text-body fw-medium">Course name</label>
                            <input
                                id="courseName"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                wire:model.live="name"
                                placeholder="Enter course name"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="coursePhase" class="form-label text-body fw-medium">Phase</label>
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
                            <label for="courseTutor" class="form-label text-body fw-medium">Tutor</label>
                            <select
                                id="courseTutor"
                                class="form-select @error('tutorId') is-invalid @enderror"
                                wire:model="tutorId"
                            >
                                <option value="">Select a tutor</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">
                                        {{ $tutor->name }} {{ $tutor->surname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tutorId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="courseDescription" class="form-label text-body fw-medium">Description (optional)</label>
                            <textarea
                                id="courseDescription"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                wire:model.live="description"
                                placeholder="Enter course description"
                            ></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                {{ $editingCourseId ? 'Update course' : 'Create course' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-0">
                    @if($courses->isEmpty())
                        <div class="p-5 text-center">
                            <i class="ri-book-open-line fs-48 text-light mb-3 d-block"></i>
                            <p class="text-muted mb-0">No courses have been created yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-body fw-medium">Course Name</th>
                                        <th class="py-3 text-body fw-medium">Phase</th>
                                        <th class="py-3 text-body fw-medium">Tutor</th>
                                        <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="fw-semibold text-secondary">{{ $course->name }}</div>
                                                @if($course->description)
                                                    <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                        {{ $course->description }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                                    {{ $course->phase?->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                        <i class="ri-user-line text-secondary"></i>
                                                    </div>
                                                    <span class="text-body">{{ $course->tutor?->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary btn-sm px-3"
                                                    wire:click="startEdit({{ $course->id }})"
                                                >
                                                    <i class="ri-edit-line"></i> Edit
                                                </button>
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
