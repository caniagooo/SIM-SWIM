<x-default-layout>
    <div class="container mt-5">
        <h1>Sessions for {{ $course->name }}</h1>
        <a href="{{ route('sessions.create', $course->id) }}" class="btn btn-primary mb-3">Add Session</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $session->session_date }}</td>
                        <td>{{ $session->start_time }}</td>
                        <td>{{ $session->end_time }}</td>
                        <td>{{ ucfirst($session->status) }}</td>
                        <td>
                            <a href="{{ route('sessions.edit', [$course->id, $session->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('sessions.destroy', [$course->id, $session->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-default-layout>