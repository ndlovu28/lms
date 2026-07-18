<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Courses</h3>
        <nav aria-label="breadcrumb">
            <button wire:click="startCreate" class="px-4 py-2 btn btn-primary">
                Create Course
            </button>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white border border-white rounded-10">
                <div class="card-body p-0">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Phase</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr>
                                <td>{{ ucwords($course->name) }}</td>
                                <td>{{ substr($course->description, 0, 50) }}</td>
                                <td>{{ $course->phase->name }}</td>
                                <td class="text-end">
                                    <button wire:click="startEdit({{ $course->id }})" class="btn btn-outline-primary btn-sm px-3">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="course-modal" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editingCourseId ? 'Edit Course' : 'Create Course' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" wire:model.defer="name">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" wire:model.defer="description"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Phase</label>
                                    <select class="form-control" wire:model.defer="phaseId">
                                        <option value="">Select a phase</option>
                                        @foreach ($phases as $phase)
                                            <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('phaseId') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-course-modal', () => {
                $('#course-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
        });
    </script>
    @endpush
</div>
