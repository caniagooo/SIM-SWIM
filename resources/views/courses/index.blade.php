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

        <!-- Course Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Type</th>
                        <th>Venue</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('courses.show', $course->id) }}" class="text-decoration-none">
                                    {{ $course->name }}
                                </a>
                            </td>
                            <td>{{ ucfirst($course->type) }}</td>
                            <td>{{ $course->venue->name ?? 'N/A' }}</td>
                            <td>{{ $course->start_date ? $course->start_date->format('d M Y') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No courses available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>