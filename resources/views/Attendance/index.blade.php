<x-default-layout>
    <div class="container mt-5">
        <h1>Attendance for Session on {{ $session->session_date }}</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Participant</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance->student->user->name ?? $attendance->trainer->user->name }}</td>
                        <td>{{ ucfirst($attendance->status) }}</td>
                        <td>
                            <form action="{{ route('attendances.destroy', [$session->id, $attendance->id]) }}" method="POST" style="display:inline;">
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