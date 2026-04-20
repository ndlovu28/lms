<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">My Courses</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Assigned Courses</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="card bg-white border border-white rounded-10">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h3 class="fs-18 fw-medium mb-0">Assigned Courses</h3>
            </div>
            @if($courses->isEmpty())
                <div class="p-5 text-center">
                    <i class="ri-book-3-line fs-48 text-light mb-3 d-block"></i>
                    <p class="text-muted mb-0">You have no courses assigned yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-body fw-medium">Course Name</th>
                                <th class="py-3 text-body fw-medium">Phase</th>
                                <th class="py-3 text-body fw-medium text-center">Enrolled Students</th>
                                <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-semibold text-secondary fs-15">{{ $course->name }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                            {{ $course->phase?->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="fw-medium text-body">{{ $course->students_count }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('tutor.manage-materials', $course->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                                <i class="ri-book-open-line me-1"></i> Materials
                                            </a>
                                            <a href="{{ route('tutor.manage-assignments', $course->id) }}" class="btn btn-outline-success btn-sm px-3">
                                                <i class="ri-edit-box-line me-1"></i> Assignments
                                            </a>
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

