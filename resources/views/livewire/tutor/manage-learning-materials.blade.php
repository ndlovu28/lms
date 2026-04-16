<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-1">Manage Learning Materials</h1>
        <p class="text-muted">Upload documents, add videos, or write study content with LaTeX support.</p>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Add New Material</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <select class="form-select @error('course_id') is-invalid @enderror" wire:model.live="course_id">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->phase->name.' - '.$course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="e.g. Introduction to Algebra">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" wire:model.live="type">
                                <option value="text">Text Content</option>
                                <option value="video">Video Link</option>
                                <option value="file">File Upload</option>
                            </select>
                        </div>

                        @if($type === 'text')
                            <div class="mb-3">
                                <label class="form-label">Content (Supports LaTeX e.g. $x^2 + y^2 = z^2$)</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" wire:model="content" rows="6" placeholder="Type your content here..."></textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Use $ for inline and $$ for block math.</small>
                            </div>
                        @elseif($type === 'video')
                            <div class="mb-3">
                                <label class="form-label">Video URL (YouTube/Vimeo)</label>
                                <input type="url" class="form-control @error('content') is-invalid @enderror" wire:model="content" placeholder="https://www.youtube.com/watch?v=...">
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @elseif($type === 'file')
                            <div class="mb-3">
                                <label class="form-label">Upload File (PDF, Docs, Images)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" wire:model="file">
                                @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div wire:loading wire:target="file" class="text-primary mt-1">Uploading...</div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100">Add Material</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Existing Materials @if($course_id) for Selected Course @endif</h5>
                </div>
                <div class="card-body p-0">
                    @if(empty($materials))
                        <div class="text-center py-5">
                            <p class="text-muted mb-0">Select a course to view its materials or add new ones.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($materials as $material)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                @if($material->type === 'text')
                                                    <span class="material-symbols-outlined text-primary me-2">article</span>
                                                @elseif($material->type === 'video')
                                                    <span class="material-symbols-outlined text-danger me-2">play_circle</span>
                                                @else
                                                    <span class="material-symbols-outlined text-success me-2">description</span>
                                                @endif
                                                <h6 class="mb-0 fw-bold">{{ $material->title }}</h6>
                                            </div>
                                            <small class="text-muted">Added on {{ $material->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="deleteMaterial({{ $material->id }})" wire:confirm="Are you sure you want to delete this material?">
                                            Delete
                                        </button>
                                    </div>
                                    @if($material->type === 'text')
                                        <div class="mt-2 p-2 bg-light rounded small text-truncate" style="max-height: 50px;">
                                            {{ Str::limit($material->content, 100) }}
                                        </div>
                                    @elseif($material->type === 'video')
                                        <div class="mt-2 small text-primary text-truncate">
                                            {{ $material->content }}
                                        </div>
                                    @elseif($material->type === 'file')
                                        <div class="mt-2 small text-success">
                                            <span class="material-symbols-outlined align-middle fs-6">attach_file</span>
                                            {{ $material->file_name }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('material-added', () => {
            if (window.MathJax) {
                MathJax.typesetPromise();
            }
        });
    });
</script>
@endpush
