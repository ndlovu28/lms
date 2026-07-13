<div>
    <div class="p-4 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold">My Courses</h2>
    </div>

    <div class="p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($courses as $course)
                <div class="p-4 bg-white rounded-lg shadow">
                    <h3 class="text-xl font-bold">{{ $course->name }}</h3>
                    <p class="text-gray-600">{{ $course->description }}</p>
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">{{ $course->subjects_count }} subjects</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
