<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">General Schedule</h3>
                <div class="card-toolbar">
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">Back to Dashboard</a>
                    <a href="{{ route('general-schedule.export-pdf') }}" class="btn btn-danger btn-sm">Export to PDF</a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="row">
                    <!-- Kalender -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 shadow-sm">
                            <h5 class="text-muted mb-3">Calendar</h5>
                            <div id="calendar" style="height: 400px;"></div>
                        </div>
                    </div>
                    <!-- Summary -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 shadow-sm">
                            <h5 class="text-muted mb-3">Summary</h5>
                            <div id="summary">
                                <p class="text-muted">Select a date on the calendar to see the summary.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Jadwal -->
                <div class="mt-5">
                    <h5 class="text-muted">Schedule List</h5>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
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
                                    <td>{{ $session->course->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($session->start_time)->format('H : i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($session->end_time)->format('H : i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $session->status == 'completed' ? 'success text-white' : ($session->status == 'canceled' ? 'danger text-white' : 'info text-white') }}">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('attendances.index', $session->id) }}" class="btn btn-info btn-sm">Manage Attendance</a>
                                        <a href="{{ route('sessions.edit', [$session->course->id, $session->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('sessions.destroy', [$session->course->id, $session->id]) }}" method="POST" style="display:inline;">
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
            </div>
        </div>
    </div>

    <!-- FullCalendar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 400, // Membatasi tinggi kalender agar lebih compact
                events: @json($sessions->map(function ($session) {
                    return [
                        'title' => $session->course->name,
                        'start' => $session->session_date,
                        'extendedProps' => [
                            'students' => $session->course->students->count()
                        ]
                    ];
                })),
                eventClick: function(info) {
                    var studentsCount = info.event.extendedProps.students;
                    var date = info.event.start.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    document.getElementById('summary').innerHTML = `
                        <h6>${date}</h6>
                        <p><strong>Course:</strong> ${info.event.title}</p>
                        <p><strong>Estimated Students:</strong> ${studentsCount}</p>
                    `;
                }
            });
            calendar.render();
        });
    </script>
</x-default-layout>