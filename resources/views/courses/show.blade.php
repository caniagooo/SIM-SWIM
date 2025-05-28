<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">Course Details</h3>
                <div class="card-toolbar">
                    <a href="{{ route('sessions.create', $course->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Add a new session">
                        <i class="bi bi-plus-circle"></i> Add Session
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Back to course list">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit this course">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="courseTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
                            Course Information
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="false">
                            Schedule
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">
                            Attendance
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-4" id="courseTabsContent">
                    <!-- Informasi Kursus -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-muted">Basic Information</h5>
                                <p><strong>Name:</strong> {{ $course->name }}</p>
                                <p><strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($course->type) }}</span></p>
                                <p><strong>Venue:</strong> {{ $course->venue->name ?? 'N/A' }}</p>
                                <p><strong>Price:</strong> Rp. {{ number_format($course->price, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted">Schedule</h5>
                                <p><strong>Start Date:</strong> {{ $course->start_date ? $course->start_date->format('d M Y') : 'N/A' }}</p>
                                <p><strong>Duration:</strong> {{ $course->duration_days ?? 'N/A' }} days</p>
                                <p><strong>Max Sessions:</strong> {{ $course->max_sessions ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Jadwal -->
                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                        <h4 class="mb-3 text-primary">Course Sessions</h4>
                        @if ($course->sessions && $course->sessions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
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
                                        @foreach ($course->sessions as $session)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $session->session_date }}</td>
                                                <td>{{ $session->start_time }}</td>
                                                <td>{{ $session->end_time }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $session->status == 'completed' ? 'success' : ($session->status == 'canceled' ? 'danger' : 'info') }}">
                                                        {{ ucfirst($session->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('sessions.edit', [$course->id, $session->id]) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit this session">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('sessions.destroy', [$course->id, $session->id]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete this session" onclick="return confirm('Are you sure you want to delete this session?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No sessions scheduled.</p>
                        @endif
                    </div>

                    <!-- Informasi Absensi -->
                    <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                        <h4 class="mb-3 text-primary">Attendance Records</h4>
                        @if ($course->sessions && $course->sessions->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Session Date</th>
                                            <th>Student/Trainer</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($course->sessions as $session)
                                            @foreach ($session->attendances as $attendance)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $session->session_date }}</td>
                                                    <td>{{ $attendance->student->user->name ?? $attendance->trainer->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $attendance->student_id ? 'Student' : 'Trainer' }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $attendance->status == 'present' ? 'success' : ($attendance->status == 'late' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($attendance->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No attendance records available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tooltip Initialization -->
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</x-default-layout>

