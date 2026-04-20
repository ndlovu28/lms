<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Create Quiz</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">New Quiz</span>
                </li>
            </ol>
        </nav>
    </div>

    <form wire:submit.prevent="save">
        <div class="card bg-white border border-white rounded-10 mb-4 shadow-sm">
            <div class="card-body p-4">
                <h3 class="fs-18 fw-medium mb-4">Quiz Information</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label text-body fw-medium">Quiz name</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Enter quiz name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="course_id" class="form-label text-body fw-medium">Course</label>
                        <select id="course_id" class="form-select @error('course_id') is-invalid @enderror" wire:model="course_id">
                            <option value="">Select a course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name.' ('.$course->phase->name.')' }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fs-18 fw-medium mb-0 text-secondary">Questions</h3>
                <button type="button" class="btn btn-primary btn-sm" wire:click="addQuestion">
                    <i class="ri-add-line"></i> Add Question
                </button>
            </div>

            @foreach($questions as $index => $question)
                <div class="card bg-white border border-white rounded-10 mb-4 shadow-sm" wire:key="question-{{ $index }}">
                    <div class="card-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center rounded-top-10">
                        <span class="fw-semibold text-secondary">Question #{{ $index + 1 }}</span>
                        @if(count($questions) > 1)
                            <button type="button" class="btn btn-sm btn-outline-danger border-0" wire:click="removeQuestion({{ $index }})">
                                <i class="ri-delete-bin-line"></i> Remove
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label text-body fw-medium">Question text</label>
                            <textarea class="form-control @error('questions.'.$index.'.text') is-invalid @enderror" wire:model="questions.{{ $index }}.text" rows="2" placeholder="Enter the question text here..."></textarea>
                            @error('questions.'.$index.'.text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-body fw-medium small">Option A</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">A</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_a') is-invalid @enderror border-start-0" wire:model="questions.{{ $index }}.option_a" placeholder="Option A">
                                </div>
                                @error('questions.'.$index.'.option_a') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-body fw-medium small">Option B</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">B</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_b') is-invalid @enderror border-start-0" wire:model="questions.{{ $index }}.option_b" placeholder="Option B">
                                </div>
                                @error('questions.'.$index.'.option_b') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-body fw-medium small">Option C</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">C</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_c') is-invalid @enderror border-start-0" wire:model="questions.{{ $index }}.option_c" placeholder="Option C">
                                </div>
                                @error('questions.'.$index.'.option_c') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-body fw-medium small">Option D</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">D</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_d') is-invalid @enderror border-start-0" wire:model="questions.{{ $index }}.option_d" placeholder="Option D">
                                </div>
                                @error('questions.'.$index.'.option_d') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label d-block text-body fw-medium mb-3">Which is the correct answer?</label>
                            <div class="d-flex gap-3">
                                @foreach(['a', 'b', 'c', 'd'] as $opt)
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check" name="correct_{{ $index }}" id="correct_{{ $opt }}_{{ $index }}" value="{{ $opt }}" wire:model="questions.{{ $index }}.correct_option">
                                        <label class="btn btn-outline-primary w-100 py-2 fw-semibold" for="correct_{{ $opt }}_{{ $index }}">Option {{ strtoupper($opt) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('questions.'.$index.'.correct_option') <small class="text-danger d-block mt-2">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('tutor.dashboard') }}" class="btn btn-light px-4 py-2 text-secondary fw-medium">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 py-2">
                <i class="ri-save-line me-1"></i> Create Quiz
            </button>
        </div>
    </form>
</div>
