<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">My courses</h1>
            <small class="text-muted">Courses assigned to you as tutor.</small>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Assigned courses
        </div>
        <div class="card-body p-0">
            @if($courses->isEmpty())
                <p class="text-muted p-3 mb-0">
                    You have no courses assigned yet.
                </p>
            @else
                <div class="list-group list-group-flush">
                    @foreach($courses as $course)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-semibold">{{ $course->name }}</div>
                                    <small class="text-muted d-block">
                                        Phase: {{ $course->phase?->name ?? 'N/A' }}
                                    </small>
                                    <small class="text-muted d-block">
                                        Enrolled students: {{ $course->students_count }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

