<x-auth-layout>
<h3>Attendance Summary for {{ $course->name }}</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Student</th>
            <th>Total Sessions</th>
            <th>Attended Sessions</th>
            <th>Attendance Percentage</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendanceSummary as $summary)
            <tr>
                <td>{{ $summary['student']->user->name }}</td>
                <td>{{ $summary['total_sessions'] }}</td>
                <td>{{ $summary['attended_sessions'] }}</td>
                <td>{{ number_format($summary['attendance_percentage'], 2) }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>
</x-auth-layout>