<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">My Certificates</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">My Certificates</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        @forelse($certificates as $cert)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card bg-white border border-white rounded-10 h-100 overflow-hidden shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="ri-award-fill fs-24"></i>
                            </div>
                            <span class="badge bg-light text-secondary rounded-pill px-3 py-2 small">
                                #{{ $cert->certificate_number }}
                            </span>
                        </div>
                        
                        <h4 class="fs-18 fw-bold text-secondary mb-2">{{ $cert->title }}</h4>
                        @if($cert->course)
                            <p class="text-primary fw-medium small mb-3"><i class="ri-book-open-line me-1"></i>{{ $cert->course->name }}</p>
                        @endif
                        
                        <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.5em;">
                            {{ $cert->description }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto border-top pt-3">
                            <div class="text-muted small">
                                <i class="ri-calendar-line me-1"></i> {{ $cert->issued_at->format('M d, Y') }}
                            </div>
                            <button class="btn btn-primary btn-sm rounded-pill px-4" wire:click="downloadCertificate({{ $cert->id }})">
                                <i class="ri-download-cloud-line me-1"></i> Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card bg-white border border-white rounded-10 text-center py-5">
                    <div class="card-body">
                        <i class="ri-award-line fs-48 text-light mb-3 d-block"></i>
                        <h5 class="text-secondary">No Certificates Yet</h5>
                        <p class="text-muted mb-0">Certificates will appear here once issued by your administrator.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
