<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Learning Materials: {{ $course->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Study</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Sidebar: List of Materials -->
        <div class="col-lg-4 col-xl-3 mb-4">
            <div class="card bg-white border border-white rounded-10 h-100 shadow-sm">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <h5 class="fs-18 fw-semibold mb-1 text-secondary">Course Content</h5>
                        <p class="small text-muted mb-0">{{ $course->name }}</p>
                    </div>
                    <div class="list-group list-group-flush overflow-auto custom-scrollbar" style="max-height: 65vh;">
                        @forelse($materials as $material)
                            <button 
                                wire:click="selectMaterial({{ $material->id }})"
                                class="list-group-item list-group-item-action border-0 py-3 px-4 d-flex align-items-center transition-all @if($selectedMaterial && $selectedMaterial->id === $material->id) bg-primary bg-opacity-10 text-primary fw-semibold @endif"
                            >
                                @if($material->type === 'text')
                                    <i class="ri-article-line me-3 fs-18 @if($selectedMaterial && $selectedMaterial->id === $material->id) text-primary @else text-secondary @endif"></i>
                                @elseif($material->type === 'video')
                                    <i class="ri-play-circle-line me-3 fs-18 @if($selectedMaterial && $selectedMaterial->id === $material->id) text-primary @else text-danger @endif"></i>
                                @else
                                    <i class="ri-file-list-3-line me-3 fs-18 @if($selectedMaterial && $selectedMaterial->id === $material->id) text-primary @else text-success @endif"></i>
                                @endif
                                <span class="text-truncate fs-14">{{ $material->title }}</span>
                            </button>
                        @empty
                            <div class="p-5 text-center text-muted">
                                <i class="ri-inbox-line fs-32 d-block mb-2"></i>
                                <span class="small">No materials available.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-light border-0 p-3 rounded-bottom-10">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center">
                        <i class="ri-arrow-left-line me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-8 col-xl-9">
            <div class="card bg-white border border-white rounded-10 h-100 min-vh-75 shadow-sm">
                @if($selectedMaterial)
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex justify-content-between align-items-start mb-4 pb-4 border-bottom">
                            <div>
                                <h2 class="fs-24 fw-bold text-secondary mb-2">{{ $selectedMaterial->title }}</h2>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-12 text-uppercase fw-semibold tracking-wider">
                                    <i class="@if($selectedMaterial->type === 'text') ri-article-line @elseif($selectedMaterial->type === 'video') ri-play-circle-line @else ri-file-list-3-line @endif me-1"></i>
                                    {{ $selectedMaterial->type }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="material-content-body">
                            @if($selectedMaterial->type === 'text')
                                <div class="study-content text-body" id="math-content">
                                    {!! nl2br(e($selectedMaterial->content)) !!}
                                </div>
                            @elseif($selectedMaterial->type === 'video')
                                <div class="ratio ratio-16x9 mb-4 rounded-10 overflow-hidden shadow-sm">
                                    @php
                                        $url = $selectedMaterial->content;
                                        $embedUrl = $url;
                                        if (strpos($url, 'youtube.com/watch?v=') !== false) {
                                            $embedUrl = str_replace('watch?v=', 'embed/', $url);
                                        } elseif (strpos($url, 'youtu.be/') !== false) {
                                            $embedUrl = 'https://www.youtube.com/embed/' . substr($url, strrpos($url, '/') + 1);
                                        }
                                    @endphp
                                    <iframe src="{{ $embedUrl }}" title="{{ $selectedMaterial->title }}" allowfullscreen></iframe>
                                </div>
                                <div class="text-center">
                                    <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary px-4 py-2 rounded-pill d-inline-flex align-items-center">
                                        <i class="ri-external-link-line me-2"></i> Open Video in New Tab
                                    </a>
                                </div>
                            @elseif($selectedMaterial->type === 'file')
                                <div class="text-center py-5 bg-light rounded-10">
                                    <div class="mb-4">
                                        <div class="bg-white p-4 rounded-circle d-inline-flex shadow-sm">
                                            <i class="ri-file-download-line text-primary" style="font-size: 64px;"></i>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold mb-2">{{ $selectedMaterial->file_name }}</h4>
                                    <p class="text-muted mb-4 fs-16">This material is available as a downloadable document.</p>
                                    <a href="{{ Storage::url($selectedMaterial->file_path) }}" target="_blank" class="btn btn-primary btn-lg px-5 py-3 rounded-10 shadow-sm d-inline-flex align-items-center">
                                        <i class="ri-download-cloud-line me-2 fs-20"></i>
                                        Download File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted p-5 text-center">
                        <div class="bg-light p-4 rounded-circle mb-4">
                            <i class="ri-book-read-line text-primary" style="font-size: 80px;"></i>
                        </div>
                        <h3 class="fw-bold text-secondary mb-3">Start Your Learning Journey</h3>
                        <p class="fs-16 max-w-400 mx-auto">Select a material from the course content sidebar to begin studying. Your progress will be tracked as you go.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('material-selected', () => {
            setTimeout(() => {
                if (window.MathJax) {
                    MathJax.typesetPromise();
                }
            }, 100);
        });
    });
</script>
<style>
    .min-vh-75 { min-height: 75vh; }
    .study-content {
        line-height: 1.8;
        font-size: 1.15rem;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endpush
