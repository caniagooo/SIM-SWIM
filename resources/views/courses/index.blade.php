<x-default-layout>
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Courses</h1>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Course
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter -->
        <div class="mb-4">
            <form method="GET" action="{{ route('courses.index') }}" class="d-flex align-items-center gap-3">
                <label for="type" class="form-label mb-0">Filter by Type:</label>
                <select name="type" id="type" class="form-select w-auto">
                    <option value="">All</option>
                    <option value="private" {{ request('type') == 'private' ? 'selected' : '' }}>Private</option>
                    <option value="group" {{ request('type') == 'group' ? 'selected' : '' }}>Group</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Course Cards -->
        <div class="row g-4">
            @forelse ($courses as $course)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-white text-decoration-none">
                                    {{ $course->name }}
                                </a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Type:</strong> <span class="badge bg-info text-dark">{{ ucfirst($course->type) }}</span></p>
                            <p><strong>Venue:</strong> {{ $course->venue->name ?? 'N/A' }}</p>
                            <p><strong>Start Date:</strong> {{ $course->start_date ? $course->start_date->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Valid Until:</strong> {{ $course->valid_until ? $course->valid_until->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Max Sessions:</strong> {{ $course->max_sessions ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> Rp. {{ number_format($course->price, 2) }}</p>
                            <p><strong>Trainers:</strong></p>
                            <ul class="list-unstyled">
                                @foreach ($course->trainers as $trainer)
                                    <li>
                                        <a href="{{ route('trainers.show', $trainer->id) }}" class="text-primary text-decoration-underline">
                                            {{ $trainer->user->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <p><strong>Students:</strong> 
                                <span 
                                    class="text-primary text-decoration-underline" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-html="true" 
                                    title="
                                        @foreach ($course->students as $student)
                                            {{ $student->user->name }}<br>
                                        @endforeach
                                    ">
                                    View Students ({{ $course->students->count() }})
                                </span>
                            </p>
                            <p><strong>Status:</strong> 
                                @if ($course->isValid())
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No courses available.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tooltip Initialization -->
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</x-default-layout>