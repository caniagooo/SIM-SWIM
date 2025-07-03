<x-default-layout>
<div class="container mt-0 mb-4">
    <div class="card card-flush border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
            <h3 class="mb-0 fw-bold">Edit Materi Kursus</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('course-materials.update', $courseMaterial->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <input type="text" name="level" id="level" class="form-control" value="{{ old('level', $courseMaterial->level) }}" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Materi</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $courseMaterial->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="estimated_sessions" class="form-label">Estimasi Sesi</label>
                    <input type="number" name="estimated_sessions" id="estimated_sessions" class="form-control" value="{{ old('estimated_sessions', $courseMaterial->estimated_sessions) }}" required>
                </div>
                <div class="mb-3">
                    <label for="minimum_score" class="form-label">Minimum Skor</label>
                    <input type="number" name="minimum_score" id="minimum_score" class="form-control" value="{{ old('minimum_score', $courseMaterial->minimum_score) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
</x-default-layout>