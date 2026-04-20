<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Manage Learning Materials</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Learning Materials</span>
                </li>
            </ol>
        </nav>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert">
            <i class="ri-checkbox-circle-line me-1"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card bg-white border border-white rounded-10 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">Add New Material</h3>
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Course</label>
                            <select class="form-select @error('course_id') is-invalid @enderror" wire:model.live="course_id">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->phase->name.' - '.$course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="e.g. Introduction to Algebra">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-body fw-medium">Type</label>
                            <div class="row g-2">
                                @foreach(['text' => 'ri-article-line', 'video' => 'ri-play-circle-line', 'file' => 'ri-file-list-3-line'] as $val => $icon)
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="material_type" id="type_{{ $val }}" value="{{ $val }}" wire:model.live="type">
                                        <label class="btn btn-outline-primary w-100 py-2 fs-12 d-flex flex-column align-items-center" for="type_{{ $val }}">
                                            <i class="{{ $icon }} fs-20 mb-1"></i>
                                            {{ ucfirst($val) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($type === 'text')
                            <div class="mb-4">
                                <label class="form-label text-body fw-medium">Content (Supports LaTeX)</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" wire:model="content" rows="6" placeholder="Type your content here..."></textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted mt-2 d-block">Use $ for inline and $$ for block math (LaTeX).</small>
                            </div>
                        @elseif($type === 'video')
                            <div class="mb-4">
                                <label class="form-label text-body fw-medium">Video URL (YouTube/Vimeo)</label>
                                <input type="url" class="form-control @error('content') is-invalid @enderror" wire:model="content" placeholder="https://www.youtube.com/watch?v=...">
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @elseif($type === 'file')
                            <div class="mb-4">
                                <label class="form-label text-body fw-medium">Upload File (PDF, Docs, Images)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" wire:model="file">
                                @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div wire:loading wire:target="file" class="text-primary mt-2 small">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Uploading...
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="ri-add-line me-1"></i> Add Material
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10 shadow-sm">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <h3 class="fs-18 fw-medium mb-0 text-secondary">Existing Materials @if($course_id) for Selected Course @endif</h3>
                    </div>
                    @if(empty($materials))
                        <div class="text-center py-5">
                            <i class="ri-book-open-line fs-48 text-light mb-3 d-block"></i>
                            <p class="text-muted mb-0">Select a course to view its materials or add new ones.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-body fw-medium">Material</th>
                                        <th class="py-3 text-body fw-medium">Type</th>
                                        <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light p-2 rounded me-3">
                                                        @if($material->type === 'text')
                                                            <i class="ri-article-line text-primary fs-20"></i>
                                                        @elseif($material->type === 'video')
                                                            <i class="ri-play-circle-line text-danger fs-20"></i>
                                                        @else
                                                            <i class="ri-file-list-3-line text-success fs-20"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-secondary">{{ $material->title }}</div>
                                                        <small class="text-muted">Added on {{ $material->created_at->format('M d, Y') }}</small>
                                                    </div>
                                                </div>
                                                
                                                @if($material->type === 'text')
                                                    <div class="mt-2 text-muted small text-truncate" style="max-width: 400px;">
                                                        {{ Str::limit($material->content, 100) }}
                                                    </div>
                                                @elseif($material->type === 'video')
                                                    <div class="mt-2 text-primary small text-truncate" style="max-width: 400px;">
                                                        <i class="ri-link me-1"></i>{{ $material->content }}
                                                    </div>
                                                @elseif($material->type === 'file')
                                                    <div class="mt-2 text-success small">
                                                        <i class="ri-attachment-line me-1"></i>{{ $material->file_name }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-light text-secondary text-uppercase px-3 py-2 rounded-pill fs-11 fw-bold tracking-wider">{{ $material->type }}</span>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <button class="btn btn-outline-danger btn-sm btn-icon" wire:click="deleteMaterial({{ $material->id }})" wire:confirm="Are you sure you want to delete this material?">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
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
