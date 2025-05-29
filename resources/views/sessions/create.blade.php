<x-default-layout>
    <div class="container mt-5">
        <h1>Add Session for {{ $course->name }}</h1>
        <form action="{{ route('sessions.store', $course->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="session_date" class="form-label">Session Date</label>
                <input type="date" class="form-control" id="session_date" name="session_date" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="scheduled">Scheduled</option>
                    <option value="completed">Completed</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('sessions.index', $course->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-default-layout>