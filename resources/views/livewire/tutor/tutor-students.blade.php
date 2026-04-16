<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">My students</h1>
            <small class="text-muted">Students enrolled in your courses.</small>
        </div>
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

    <div class="card">
        <div class="card-header">
            Students
        </div>
        <div class="card-body p-0">
            @if($students->isEmpty())
                <p class="text-muted p-3 mb-0">
                    No students found for the selected criteria.
                </p>
            @else
                <div class="list-group list-group-flush">
                    @foreach($students as $student)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $student->name }} {{ $student->surname }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $student->email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="small text-muted mb-1">
                                    Enrolled in your courses:
                                </div>
                                <ul class="small mb-0">
                                    @foreach($student->courses as $course)
                                        <li>
                                            {{ $course->name }}
                                            @if($course->phase)
                                                <span class="text-muted">
                                                    ({{ $course->phase->name }})
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-2">
                                <small class="text-muted">
                                    Latest submissions summary will appear here.
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

