<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-1">Create new quiz</h1>
        <p class="text-muted">Design a multiple choice quiz for your students.</p>
    </div>

    <form wire:submit.prevent="save">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Quiz name</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="course_id" class="form-label">Course</label>
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Questions</h2>
                <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="addQuestion">
                    + Add Question
                </button>
            </div>

            @foreach($questions as $index => $question)
                <div class="card mb-3 shadow-sm" wire:key="question-{{ $index }}">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <span class="fw-bold">Question #{{ $index + 1 }}</span>
                        @if(count($questions) > 1)
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" wire:click="removeQuestion({{ $index }})">
                                Remove
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Question text</label>
                            <textarea class="form-control @error('questions.'.$index.'.text') is-invalid @enderror" wire:model="questions.{{ $index }}.text" rows="2"></textarea>
                            @error('questions.'.$index.'.text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">A</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_a') is-invalid @enderror" wire:model="questions.{{ $index }}.option_a" placeholder="Option A">
                                </div>
                                @error('questions.'.$index.'.option_a') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">B</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_b') is-invalid @enderror" wire:model="questions.{{ $index }}.option_b" placeholder="Option B">
                                </div>
                                @error('questions.'.$index.'.option_b') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">C</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_c') is-invalid @enderror" wire:model="questions.{{ $index }}.option_c" placeholder="Option C">
                                </div>
                                @error('questions.'.$index.'.option_c') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">D</span>
                                    <input type="text" class="form-control @error('questions.'.$index.'.option_d') is-invalid @enderror" wire:model="questions.{{ $index }}.option_d" placeholder="Option D">
                                </div>
                                @error('questions.'.$index.'.option_d') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label d-block">Correct option</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="correct_{{ $index }}" id="correct_a_{{ $index }}" value="a" wire:model="questions.{{ $index }}.correct_option">
                                <label class="btn btn-outline-success" for="correct_a_{{ $index }}">A</label>

                                <input type="radio" class="btn-check" name="correct_{{ $index }}" id="correct_b_{{ $index }}" value="b" wire:model="questions.{{ $index }}.correct_option">
                                <label class="btn btn-outline-success" for="correct_b_{{ $index }}">B</label>

                                <input type="radio" class="btn-check" name="correct_{{ $index }}" id="correct_c_{{ $index }}" value="c" wire:model="questions.{{ $index }}.correct_option">
                                <label class="btn btn-outline-success" for="correct_c_{{ $index }}">C</label>

                                <input type="radio" class="btn-check" name="correct_{{ $index }}" id="correct_d_{{ $index }}" value="d" wire:model="questions.{{ $index }}.correct_option">
                                <label class="btn btn-outline-success" for="correct_d_{{ $index }}">D</label>
                            </div>
                            @error('questions.'.$index.'.correct_option') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('tutor.dashboard') }}" class="btn btn-light me-md-2">Cancel</a>
            <button type="submit" class="btn btn-primary px-5">Create Quiz</button>
        </div>
    </form>
</div>
