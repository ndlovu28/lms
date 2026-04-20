<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">My Students</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Enrolled Students</span>
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
                            <h3 class="fs-18 fw-medium mb-0 me-4">Student Directory</h3>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white border border-white rounded-10">
        <div class="card-body p-0">
            @if($students->isEmpty())
                <div class="p-5 text-center">
                    <i class="ri-user-search-line fs-48 text-light mb-3 d-block"></i>
                    <p class="text-muted mb-0">No students found for the selected criteria.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-body fw-medium">Student Info</th>
                                <th class="py-3 text-body fw-medium">Course Enrollments</th>
                                <th class="pe-4 py-3 text-end text-body fw-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                <i class="ri-user-smile-line fs-20 text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-secondary fs-15">
                                                    {{ $student->name }} {{ $student->surname }}
                                                </div>
                                                <div class="small text-muted">
                                                    {{ $student->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($student->courses as $course)
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">
                                                    {{ $course->name }}
                                                    @if($course->phase)
                                                        <small class="opacity-75">({{ $course->phase->name }})</small>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Active</span>
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

