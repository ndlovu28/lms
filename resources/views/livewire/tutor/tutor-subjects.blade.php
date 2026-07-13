<div>
    <div class="p-4 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold">My Subjects</h2>
    </div>

    <div class="p-4">
        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($subjects as $subject)
                <div class="p-4 bg-white rounded-lg shadow">
                    <h3 class="text-xl font-bold">{{ $subject->name }}</h3>
                    <p class="text-gray-600">{{ $subject->course->name }}</p>
                    <p class="text-gray-600">{{ $subject->course->phase->name }}</p>
                    <div class="mt-4">
                        <span class="text-sm text-gray-500">{{ $subject->students_count }} students</span>
                    </div>

                    <div class="mt-4">
                        @if($subject->activeSession)
                            <button wire:click="endLiveSession({{ $subject->id }})" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                                End Live Session
                            </button>
                            <a href="{{ $subject->activeSession->join_url }}" target="_blank" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">
                                Join Live Session
                            </a>
                        @else
                            <button wire:click="startLiveSession({{ $subject->id }})" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Start Live Session
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
