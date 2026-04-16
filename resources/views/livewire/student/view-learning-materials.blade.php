<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar: List of Materials -->
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fs-6">Course Materials</h5>
                    <small>{{ $course->name }}</small>
                </div>
                <div class="list-group list-group-flush overflow-auto" style="max-height: 70vh;">
                    @forelse($materials as $material)
                        <button 
                            wire:click="selectMaterial({{ $material->id }})"
                            class="list-group-item list-group-item-action @if($selectedMaterial && $selectedMaterial->id === $material->id) active @endif"
                        >
                            <div class="d-flex align-items-center">
                                @if($material->type === 'text')
                                    <span class="material-symbols-outlined me-2 fs-5">article</span>
                                @elseif($material->type === 'video')
                                    <span class="material-symbols-outlined me-2 fs-5 text-danger">play_circle</span>
                                @else
                                    <span class="material-symbols-outlined me-2 fs-5 text-success">description</span>
                                @endif
                                <span class="text-truncate">{{ $material->title }}</span>
                            </div>
                        </button>
                    @empty
                        <div class="p-4 text-center text-muted">
                            No materials available.
                        </div>
                    @endforelse
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-8 col-lg-9">
            <div class="card shadow-sm h-100 min-vh-75">
                @if($selectedMaterial)
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $selectedMaterial->title }}</h4>
                        <span class="badge bg-light text-dark border">{{ ucfirst($selectedMaterial->type) }}</span>
                    </div>
                    <div class="card-body">
                        @if($selectedMaterial->type === 'text')
                            <div class="study-content p-2" id="math-content">
                                {!! nl2br(e($selectedMaterial->content)) !!}
                            </div>
                        @elseif($selectedMaterial->type === 'video')
                            <div class="ratio ratio-16x9 mb-3">
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
                                <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm">Open Video in New Tab</a>
                            </div>
                        @elseif($selectedMaterial->type === 'file')
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <span class="material-symbols-outlined display-1 text-muted">description</span>
                                </div>
                                <h5>{{ $selectedMaterial->file_name }}</h5>
                                <p class="text-muted">This material is a downloadable file.</p>
                                <a href="{{ Storage::url($selectedMaterial->file_path) }}" target="_blank" class="btn btn-primary btn-lg px-5">
                                    <span class="material-symbols-outlined align-middle me-1">download</span>
                                    Download File
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted py-5">
                        <span class="material-symbols-outlined display-1 mb-3">auto_stories</span>
                        <h4>Select a material to start studying</h4>
                        <p>Click on any item in the sidebar to view its content.</p>
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
        font-size: 1.1rem;
    }
</style>
@endpush
