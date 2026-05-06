<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Student Reports</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Academic Reports</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0">Select Student</h5>
                </div>
                <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                    <div class="p-3">
                        <input type="text" class="form-control bg-light border-0 mb-3" placeholder="Search student...">
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($students as $studentItem)
                            <button type="button" 
                                    wire:click="selectStudent({{ $studentItem->id }})"
                                    class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center {{ $selectedStudentId == $studentItem->id ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                    <i class="ri-user-line fs-16 text-secondary"></i>
                                </div>
                                <div class="text-start">
                                    <h6 class="mb-0 fs-14 {{ $selectedStudentId == $studentItem->id ? 'text-primary' : 'text-secondary' }}">{{ $studentItem->name }} {{ $studentItem->surname }}</h6>
                                    <p class="text-muted small mb-0">{{ $studentItem->email }}</p>
                                </div>
                            </button>
                        @empty
                            <li class="list-group-item border-0 px-4 py-3 text-muted text-center">No students found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            @if($student)                
                <div class="card bg-white border border-white rounded-10 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="ri-file-chart-line fs-30"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 fs-20 fw-bold text-secondary">{{ $student->name }} {{ $student->surname }}</h4>
                                    <p class="text-muted mb-0">Academic Performance Summary</p>
                                </div>
                            </div>
                            <button class="btn btn-primary rounded-10 px-4" wire:click="downloadReport({{ $student->id }})">
                                <i class="ri-download-cloud-line me-1"></i> Download PDF Report
                            </button>
                        </div>

                        <hr class="my-4">
                        @forelse($studentMarks as $mark)
                            <div class="mb-5">
                                <h5 class="text-primary mb-3"><i class="ri-book-open-line me-2"></i>{{ $studentMarks->first()->course->name }}</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="px-3 py-2 border-0">Assessment</th>
                                                <th class="px-3 py-2 border-0 text-center">Mark</th>
                                                <th class="px-3 py-2 border-0 text-center">Max Mark</th>
                                                <th class="px-3 py-2 border-0">Tutor Comments</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td class="px-3 py-3 border-0 fw-medium text-secondary">{{ $mark->title }}</td>
                                                    <td class="px-3 py-3 border-0 text-center">
                                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                                            {{ $mark->mark }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-3 border-0 text-center text-muted">
                                                        {{ $mark->max_mark ?: '-' }}
                                                    </td>
                                                    <td class="px-3 py-3 border-0">
                                                        <span class="text-muted small italic">{{ $mark->comments ?: 'No comments' }}</span>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="ri-medal-line fs-48 text-light mb-3 d-block"></i>
                                <p class="text-muted">No marks recorded for this student yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @else
                <div class="card bg-white border border-white rounded-10 text-center py-5" style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body">
                        <i class="ri-user-search-line fs-48 text-light mb-3 d-block"></i>
                        <h5 class="text-secondary">No Student Selected</h5>
                        <p class="text-muted">Please select a student from the list to view their academic report.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
