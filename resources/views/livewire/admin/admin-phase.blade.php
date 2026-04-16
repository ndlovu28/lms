<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Phases</h1>
            <small class="text-muted">Manage learning phases.</small>
        </div>

        <button
            type="button"
            class="btn btn-success"
            wire:click="startCreate"
        >
            + Add phase
        </button>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-header">
                    {{ $editingPhaseId ? 'Edit phase' : 'Create phase' }}
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label for="phaseName" class="form-label">Phase name</label>
                            <input
                                id="phaseName"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                wire:model.live="name"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phaseDescription" class="form-label">Description (optional)</label>
                            <textarea
                                id="phaseDescription"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                wire:model.live="description"
                            ></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ $editingPhaseId ? 'Update phase' : 'Create phase' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Existing phases
                </div>
                <div class="card-body p-0">
                    @if($phases->isEmpty())
                        <p class="text-muted p-3 mb-0">
                            No phases have been created yet.
                        </p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($phases as $phase)
                                <button
                                    type="button"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                    wire:click="startEdit({{ $phase->id }})"
                                >
                                    <div>
                                        <div class="fw-semibold">{{ $phase->name }}</div>
                                        <div class="small text-muted">
                                            {{ $phase->courses_count }} {{ \Illuminate\Support\Str::plural('course', $phase->courses_count) }}
                                        </div>
                                        @if($phase->description)
                                            <small class="text-muted d-block mt-1">{{ $phase->description }}</small>
                                        @endif
                                    </div>
                                    <span class="text-primary small">Edit</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
