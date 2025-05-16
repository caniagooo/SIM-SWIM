
<x-default-layout>
    <div class="container">
        <h1 class="mb-4">Course Materials</h1>
        <a href="{{ route('course-materials.create') }}" class="btn btn-primary mb-3">Add Material</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Level</th>
                    <th>Name</th>
                    <th>Estimated Sessions</th>
                    <th>Minimum Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($materials as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->level }}</td>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->estimated_sessions }}</td>
                        <td>{{ $material->minimum_score }}</td>
                        <td>
                            <a href="{{ route('course-materials.edit', $material->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('course-materials.destroy', $material->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No materials available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-default-layout>