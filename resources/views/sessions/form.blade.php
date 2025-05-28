<x-default-layout>
    <div class="container mt-5">
        <h1>{{ isset($session) ? 'Edit' : 'Add' }} Session for {{ $course->name }}</h1>

        <form action="{{ isset($session) ? route('sessions.update', [$course->id, $session->id]) : route('sessions.store', $course->id) }}" method="POST">
            @csrf
            @if (isset($session))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="session_date" class="form-label">Session Date</label>
                <input type="date" name="session_date" id="session_date" class="form-control" value="{{ $session->session_date ?? old('session_date') }}" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $session->start_time ?? old('start_time') }}" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $session->end_time ?? old('end_time') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($session) ? 'Update' : 'Add' }} Session</button>
        </form>
    </div>
</x-default-layout>