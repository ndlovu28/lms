<div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Phases</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">Phases</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h3 class="fs-18 fw-medium mb-0">Learning Phases</h3>
                        <div class="ms-auto">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                wire:click="startCreate"
                            >
                                <i class="ri-add-line"></i> Add phase
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-4">
                    <h3 class="fs-18 fw-medium mb-4">{{ $editingPhaseId ? 'Edit Phase' : 'Create Phase' }}</h3>
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label for="phaseName" class="form-label text-body fw-medium">Phase name</label>
                            <input
                                id="phaseName"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                wire:model.live="name"
                                placeholder="Enter phase name"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phaseDescription" class="form-label text-body fw-medium">Description (optional)</label>
                            <textarea
                                id="phaseDescription"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                wire:model.live="description"
                                placeholder="Enter phase description"
                            ></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                {{ $editingPhaseId ? 'Update Phase' : 'Create Phase' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-0">
                    @if($phases->isEmpty())
                        <div class="p-5 text-center">
                            <i class="ri-stack-line fs-48 text-light mb-3 d-block"></i>
                            <p class="text-muted mb-0">No phases have been created yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-body fw-medium">Phase Name</th>
                                        <th class="py-3 text-body fw-medium text-center">Courses</th>
                                        <th class="pe-4 py-3 text-end text-body fw-medium">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($phases as $phase)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="fw-semibold text-secondary">{{ $phase->name }}</div>
                                                @if($phase->description)
                                                    <small class="text-muted d-block text-truncate" style="max-width: 300px;">
                                                        {{ $phase->description }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="py-3 text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                                    {{ $phase->courses_count }} {{ \Illuminate\Support\Str::plural('Course', $phase->courses_count) }}
                                                </span>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary btn-sm px-3"
                                                    wire:click="startEdit({{ $phase->id }})"
                                                >
                                                    <i class="ri-edit-line"></i> Edit
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
