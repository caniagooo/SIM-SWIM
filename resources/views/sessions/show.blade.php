<x-default-layout>
<div class="mt-5">
    <h5 class="text-muted">Students</h5>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Attendance Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($session->students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->student->name }}</td>
                    <td>{{ ucfirst($student->attendance_status ?? 'Not Set') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-5">
    <h5 class="text-muted">Trainers</h5>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($session->trainers as $trainer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trainer->trainer->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-default-layout>