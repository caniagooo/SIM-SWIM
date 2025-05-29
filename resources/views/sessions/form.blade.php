<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">{{ isset($session) ? 'Edit Session' : 'Add Session' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($session) ? route('sessions.update', [$course->id, $session->id]) : route('sessions.store', $course->id) }}" method="POST">
                    @csrf
                    @if (isset($session))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="session_date" class="form-label">Session Date</label>
                        <input type="date" class="form-control" id="session_date" name="session_date" value="{{ old('session_date', $session->session_date ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', $session->start_time ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', $session->end_time ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="scheduled" {{ old('status', $session->status ?? '') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="completed" {{ old('status', $session->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ old('status', $session->status ?? '') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ isset($session) ? 'Update Session' : 'Add Session' }}</button>
                    <a href="{{ route('sessions.index', $course->id) }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-default-layout>