<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">My Marks & Grades</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">My Marks</span>
                </li>
            </ol>
        </nav>
    </div>

    @forelse($marksByCourse as $courseId => $marks)
        <div class="card bg-white border border-white rounded-10 mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0 text-secondary">{{ $marks->first()->course->name }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 border-0 rounded-start">Assessment Title</th>
                                <th class="px-4 py-3 border-0 text-center">Mark</th>
                                <th class="px-4 py-3 border-0 text-center">Max Mark</th>
                                <th class="px-4 py-3 border-0">Comments</th>
                                <th class="px-4 py-3 border-0 rounded-end">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marks as $mark)
                                <tr>
                                    <td class="px-4 py-3 border-0">
                                        <span class="fw-bold text-secondary">{{ $mark->title }}</span>
                                    </td>
                                    <td class="px-4 py-3 border-0 text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-14">
                                            {{ $mark->mark }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border-0 text-center text-muted">
                                        {{ $mark->max_mark ?: '-' }}
                                    </td>
                                    <td class="px-4 py-3 border-0">
                                        <span class="text-muted small">{{ $mark->comments ?: 'No comments' }}</span>
                                    </td>
                                    <td class="px-4 py-3 border-0 text-muted small">
                                        {{ $mark->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card bg-white border border-white rounded-10 text-center py-5">
            <div class="card-body">
                <i class="ri-medal-line fs-48 text-light mb-3 d-block"></i>
                <p class="text-muted mb-0">No marks have been recorded for you yet.</p>
            </div>
        </div>
    @endforelse
</div>
