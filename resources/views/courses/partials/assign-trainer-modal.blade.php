<!-- Assign Trainer Modal -->
<div class="modal fade" id="assignTrainerModal-{{ $course->id }}" tabindex="-1" aria-labelledby="assignTrainerModalLabel-{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('courses.assign', $course->id) }}" method="POST" class="form-assign-trainer">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignTrainerModalLabel-{{ $course->id }}">Pilih Pelatih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="trainers-{{ $course->id }}" class="form-label">Pelatih</label>
                        <select name="trainers[]" id="trainers-{{ $course->id }}" class="form-select" multiple required>
                            @foreach ($allTrainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ $course->trainers->contains($trainer->id) ? 'selected' : '' }}>
                                    {{ $trainer->user->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih satu atau lebih pelatih untuk kursus ini.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>