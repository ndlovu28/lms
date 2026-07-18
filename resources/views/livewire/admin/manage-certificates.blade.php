<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Issue Certificates</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Certificates</span>
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
        <div class="col-lg-4">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0">Issue New Certificate</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="issueCertificate">
                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Student</label>
                            <select class="form-select @error('studentId') is-invalid @enderror" wire:model="studentId">
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->surname }}</option>
                                @endforeach
                            </select>
                            @error('studentId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Course (Optional)</label>
                            <select class="form-select @error('courseId') is-invalid @enderror" wire:model="courseId">
                                <option value="">Select Course</option>
                                @foreach($subjects as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('courseId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Certificate Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Issue Date</label>
                            <input type="date" class="form-control @error('issuedAt') is-invalid @enderror" wire:model="issuedAt">
                            @error('issuedAt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-body fw-medium">Description / Citation</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" rows="4" wire:model="description" placeholder="e.g. For outstanding performance and dedication in completing..."></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="ri-award-line me-1"></i> Issue Certificate
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0">Recently Issued Certificates</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">Certificate #</th>
                                    <th class="py-3 border-0">Student</th>
                                    <th class="py-3 border-0">Issued On</th>
                                    <th class="pe-4 py-3 border-0 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($issuedCertificates as $cert)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <span class="text-secondary fw-medium">{{ $cert->certificate_number }}</span>
                                            <div class="small text-muted">{{ $cert->title }}</div>
                                        </td>
                                        <td class="py-3">
                                            <h6 class="mb-0 fs-14">{{ $cert->student->name }} {{ $cert->student->surname }}</h6>
                                            <div class="small text-muted">{{ $cert->course->name ?? 'General' }}</div>
                                        </td>
                                        <td class="py-3 text-muted">
                                            {{ $cert->issued_at->format('M d, Y') }}
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-outline-info" wire:click="downloadCertificate({{ $cert->id }})">
                                                    <i class="ri-download-2-line"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                        wire:click="deleteCertificate({{ $cert->id }})">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No certificates issued yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $issuedCertificates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
