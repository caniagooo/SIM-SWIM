<x-default-layout>
    <div class="container">
        <h1 class="mb-4">Edit Material</h1>
        <form action="{{ route('course-materials.update', $courseMaterial->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Tambahkan method PUT untuk update -->
            
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <input type="text" name="level" id="level" class="form-control" value="{{ old('level', $courseMaterial->level) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $courseMaterial->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="estimated_sessions" class="form-label">Estimated Sessions</label>
                <input type="number" name="estimated_sessions" id="estimated_sessions" class="form-control" value="{{ old('estimated_sessions', $courseMaterial->estimated_sessions) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="minimum_score" class="form-label">Minimum Score</label>
                <input type="number" name="minimum_score" id="minimum_score" class="form-control" value="{{ old('minimum_score', $courseMaterial->minimum_score) }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</x-default-layout>